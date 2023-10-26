<?php

namespace Drupal\mbgna_tweaks\Plugin\Block;

use Drupal\commerce_promotion\Entity\PromotionInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\user\Entity\User;


use Drupal\commerce_price\Price;
use Drupal\commerce_order\Entity\OrderItem;
use Drupal\commerce_order\Entity\Order;

/**
 * Provides a product promotions block.
 *
 * @Block(
 *   id = "mbgna_tweaks_product_promotions",
 *   admin_label = @Translation("Product promotions"),
 *   category = @Translation("Custom")
 * )
 */

class ProductPromotionsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    if (\Drupal::routeMatch()->getRouteName() == 'entity.commerce_product.canonical') {
      // Service should be injected rather than instantiated.
      $entityTypeManager = \Drupal::entityTypeManager();

      // Load the product.
      $product = \Drupal::routeMatch()->getParameter('commerce_product');

      /**
       * Create a temporary "model" order. 
       * 
       * Promotion conditions are evaluated on orders, and
       * promotion offers are evaluated on order items. So, to
       * use commerce_promotion's built-in condition checks,
       * we'll create a model order and order items using the
       * product's properties in addition to the environmental
       * context.
       */

      // Create an order item for each variation.
      $order_items = [];
      foreach ($product->getVariations() as $variation) {
        $order_items[] = OrderItem::create([
          'type' => $variation->getOrderItemTypeId(),
          'purchased_entity' => $variation->id(),
          'quantity' => 1,
        ]);
      }

      // Create an order of this product type with the order items.
      $product_type = $product->get('type')->getValue()[0]['target_id'];
      $order = Order::create([
        'type' => $product_type, // Assume product types have matching order types.
        'mail' => \Drupal::currentUser()->getEmail(),
        'uid' => \Drupal::currentUser()->id(),
        'store_id' => 1, // Assume no promo condition.
        'order_items' => $order_items,
        'placed' => \Drupal::time()->getCurrentTime(),
        'payment_gateway' => 'credit_card', // Assume no promo condition.
        'checkout_step' => 'order_summary',
        'state' => 'draft',
      ]);

      // Find promotions meeting conditions.
      $promotions_filtered = [];
      $promotions = \Drupal::entityTypeManager()->getStorage('commerce_promotion')->loadMultiple();

      // Find promotions meeting conditions.
      foreach ($promotions as $promotion) {
        $conditions = $promotion->getConditions();
        $condition_operator = $promotion->getConditionOperator();
        $promo_evaluations = [];

        // Evaluate each promotion condition.
        foreach ($conditions as $condition) {
          $promo_evaluations[] = $condition->evaluate($order);
        }

      /**
       * List promotions that meet conditions.
       *
       * "AND" conditions exclude promotions when there's *any* FALSE condition.
       * "OR" conditions exclude promotions when there's *no* TRUE condition.
       * When neither of those exclusions apply, we keep the promotion.
       */
        if (
          !($condition_operator === 'AND' && in_array(FALSE, $promo_evaluations)) && 
          !($condition_operator === 'OR' && !in_array(TRUE, $promo_evaluations)))
        {
          $promotions_filtered[] = $promotion;
        }
      }

      // Remove listed promotions whose offer does not meet conditions.
      foreach ($promotions_filtered as $key => $promotion_filtered) {
        $offer = $promotion_filtered->getOffer();
        $condition_operator = $offer->getConditionOperator();
        $conditions = $offer->getConditions();
        $offer_evaluations = [];

        // Evaluate each promotion offer.
        foreach ($conditions as $condition) {
          // And evaluate each product variation.
          foreach ($order_items as $order_item) {
            $offer_evaluations[] = $condition->evaluate($order_item);
          }
        }

      /**
       * De-list promotions with offers not meeting conditions.
       *
       * Remove promotions and its child offer, when the offer does not
       * meet conditions. "AND" conditions exclude promotions when there's *any* FALSE
       * condition. "OR" conditions exclude promotions when there's *no* TRUE condition.
       * When one or both of those exclusions apply, the filtered promotion remains listed.
       */
        if (
          ($condition_operator === 'AND' && in_array(FALSE, $offer_evaluations)) || 
          ($condition_operator === 'OR' && !in_array(TRUE, $offer_evaluations)))
        {
          unset($promotions_filtered[$key]);
        }
      }

      // No promotions then no block.
      if (!$promotions_filtered) {
        return;
      }

      // Reset array keys from 0.
      $promotions_filtered = array_values($promotions_filtered);

      // Get the coupons.
      $coupons = '';
      foreach ($promotions_filtered as $promotion_filtered) {
        foreach ($promotion_filtered->getCoupons() as $coupon) {
          // Render the coupon.
          $view_builder = \Drupal::entityTypeManager()->getViewBuilder('commerce_promotion_coupon');
          $pre_render = $view_builder->view($coupon, 'full');
          $coupons .= \Drupal::service('renderer')->render($pre_render);
        }
      }

      // No coupons then no block.
      if (!$coupons) {
        return;
      }

      // Otherwise add output and return.
      $build = [];
      $build['#markup'] = $coupons;

      return $build;
    }
  }

}
