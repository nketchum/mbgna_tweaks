<?php

namespace Drupal\mbgna_tweaks\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Url;


class ControllerAlterSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
  */
  public function onView(ViewEvent $event) {
    $request = $event->getRequest();
    $route = $request->attributes->get('_route');

    if ($route == 'commerce_order.address_book.overview') {
      $build = $event->getControllerResult();

      if (is_array($build)) {
        if (\Drupal::routeMatch()->getParameter('user')) {
          $account_uid = \Drupal::routeMatch()->getParameter('user')->id();

          $markup = '<h1 class="page-title">My address book</h1>';
          $build['page-title'] = array(
            '#type' => 'markup',
            '#markup' => $markup,
            '#weight' => -1,
          );

          $back_to_dash_url = Url::fromRoute('entity.user.canonical', ['user' => $account_uid]);
          $back_to_dash_link = array(
            '#type' => 'link',
            '#url' => $back_to_dash_url,
            '#title' => t('&larr; My dashboard'),
            '#weight' => -99,
          );

          $build['back_to_dash_link'] = [
            '#type' => 'link',
            '#url' => $back_to_dash_url,
            '#attributes' => [
              'id' => 'edit-back-to-dash-link',
            ],
            '#title' => t('&larr; My dashboard'),
            '#weight' => -99,
          ];
        }

        $event->setControllerResult($build);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    // priority > 0 so that it runs before the controller output
    // rendered by \Drupal\Core\EventSubscriber\MainContentViewSubscriber.
    $events[KernelEvents::VIEW][] = ['onView', 50];
    return $events;
  }

}