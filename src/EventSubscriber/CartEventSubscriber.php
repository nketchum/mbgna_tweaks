<?php

namespace Drupal\mbgna_tweaks\EventSubscriber;

use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\EventSubscriber\CartEventSubscriber as CommerceCartEventSubscriber;
use Drupal\Core\Url;

/**
 * Override commerce_cart's displayAddToCartMessage so we can improve
 * the status message and add some css classes.
 */
class CartEventSubscriber extends CommerceCartEventSubscriber {

  public function displayAddToCartMessage(CartEntityAddEvent $event) {
    // Modification: Remove the contrib cart status messages (and all others unfortunately).
    \Drupal::messenger()->deleteByType('status');

    $order = $event->getCart();
    $order_type_storage = $this->entityTypeManager->getStorage('commerce_order_type');
    /** @var \Drupal\commerce_order\Entity\OrderTypeInterface $order_type */
    $order_type = $order_type_storage->load($order->bundle());
    if ($order_type->getThirdPartySetting('commerce_cart', 'enable_cart_message', TRUE)) {

      // Modification: Use $build array to render more data for the status message output.
      $build = [
        '#type' => 'container',
        '#markup' => $this->t('@entity has been added to <a href=":url">your shopping cart</a>', ['@entity' => $event->getEntity()->label(), ':url' => Url::fromRoute('commerce_cart.page')->toString(),]),
        '#attributes' => ['class' => ['custom-messages--status', 'custom-messages--status--shopping-cart']],
      ];

      $message = \Drupal::service('renderer')->renderPlain($build);
      $this->messenger->addMessage($message);
    }
  }

}
