<?php

namespace Drupal\mbgna_tweaks\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Redirects position urls by appending a querystring.
 * 
 * Requests are redirected if a position's nid is not present as querystring in
 * the url. For example, position with an id of "1" will be redirected
 * from /position/1 to /position/1?position=1.
 *
 * The reason for this unusual url format is to allow webforms to
 * prepopulate fields using querystrings; it cannot prepopulate using
 * normal url parameters.
 */
class PositionRedirectSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
  */
  public function handle(RequestEvent $event) {
    $query = \Drupal::request()->query->get('node');

    if (!$query) {
      $route_name = \Drupal::routeMatch()->getRouteName();

      if ($route_name == 'entity.node.canonical') {
        $current_path = \Drupal::service('path.current')->getPath();
        $params = \Drupal\Core\Url::fromUserInput($current_path)->getRouteParameters();

        if (isset($params['node'])) {
          $node = \Drupal\node\Entity\Node::load($params['node']);

          if ($node->getType() == 'position') {
            $url = \Drupal\Core\Url::fromRoute($route_name, ['node' => $node->id()], ['query' => ['node' => $node->id()], 'absolute' => FALSE]);
            $response = new RedirectResponse($url->toString());
            $event->setResponse($response);
          }
        }
      }
    }
  }

  /**
   * {@inheritdoc}
  */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['handle'];
    return $events;
  }

}
