<?php

namespace Drupal\mbgna_tweaks\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_product\Entity\ProductVariationInterface;
use Drupal\commerce_stock\StockServiceManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Event subscriber to update stock levels on order placement.
 */
class OrderEventSubscriber implements EventSubscriberInterface {

  /**
   * The stock service manager.
   *
   * @var \Drupal\commerce_stock\StockServiceManagerInterface
   */
  protected $stockServiceManager;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new OrderEventSubscriber object.
   *
   * @param \Drupal\commerce_stock\StockServiceManagerInterface $stock_service_manager
   *   The stock service manager.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(StockServiceManagerInterface $stock_service_manager, EntityTypeManagerInterface $entity_type_manager) {
    $this->stockServiceManager = $stock_service_manager;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'commerce_order.place.post_transition' => 'onOrderPlace',
    ];
  }

  /**
   * Reacts to the order placement transition.
   *
   * @param \Drupal\state_machine\Event\WorkflowTransitionEvent $event
   *   The workflow transition event.
   */
  public function onOrderPlace(WorkflowTransitionEvent $event) {
    $order = $event->getEntity();
    if ($order instanceof OrderInterface) {
      $this->updateStockLevels($order);
    }
  }

  /**
   * Update stock levels for all variations of the purchased products.
   *
   * @param \Drupal\commerce_order\Entity\OrderInterface $order
   *   The order entity.
   */

  protected function updateStockLevels(OrderInterface $order) {
    foreach ($order->getItems() as $order_item) {
      // Start with purchased variation and backtrack to get
      // the full product info along with any other variations.
      $purchased_variation = $order_item->getPurchasedEntity();
      if ($purchased_variation instanceof ProductVariationInterface) {
        $product = $purchased_variation->getProduct();

        // Only sync products that have the relevant field and that
        // it is checked/activated for syncing.
        if ($product->hasField('field_sync_stock_adjustments')) {
          if ($product->get('field_sync_stock_adjustments')->value) {
            $variations = $product->getVariations();

            // Get the purchased variation quantity ordered
            // to subtract from other variation stock levels.
            $purchased_variation_qty = (int)$order_item->get('quantity')->getValue()[0]['value'];

            // Update stock levels for all variations of the product.
            foreach ($variations as $variation) {
              if ($variation->id() != $purchased_variation->id()) {
                $variation_stock_level = $this->stockServiceManager->getStockLevel($variation);
                // Only reduce stock if current stock is positive.
                if ($variation_stock_level > 0) {
                  // Prevent negative stock levels. If purchased
                  // variation stock is larger than
                  // the variation stock we're about to adjust,
                  // then we only want to subtract the remainder
                  // of the variation stock.
                  if ($purchased_variation_qty > $variation_stock_level) {
                    $purchased_variation_qty = $variation_stock_level;
                  }
                  $qty_adjust = -1 * $purchased_variation_qty; // We will subtract this qty from all other variation stock levels.
                  \Drupal::service('commerce_stock.service_manager')->createTransaction($variation, 1, '', $qty_adjust, 0, 'USD', \Drupal\commerce_stock\StockTransactionsInterface::STOCK_IN, ['data' => []]);
                }
              }
            }
          }
        }
      }
    }
  }

}
