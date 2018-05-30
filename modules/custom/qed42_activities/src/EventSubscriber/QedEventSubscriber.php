<?php

namespace Drupal\qed42_activities\EventSubscriber;

use Drupal\qed42_activities\Event\NodeInsert;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event Subscriber QedEventSubscriber.
 */
class QedEventSubscriber implements EventSubscriberInterface
{

    /**
   * Code that should be triggered on event specified.
   */
    public static function getSubscribedEvents() 
    {
        $events[KernelEvents::RESPONSE][] = ['onRespond'];
        $events[NodeInsert::INSERT][] = ['nodeInsert'];
        return $events;
    }

    /**
   * {@inheritdoc}
   */
    public function onRespond(FilterResponseEvent $event) 
    {
      $current_path = \Drupal::service('path.current')->getPath();
      $current_path_arr = explode('/', $current_path);
      if (isset($current_path_arr[1]) && $current_path_arr[1] === 'node') {
        $response = $event->getResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
      }
    }

    /**
   * Code that should be triggered on node insert.
   */
    public function nodeInsert(NodeInsert $events) 
    {
        $message = 'Node title: ' . $events->getReferenceNode()->getTitle() . ' has been created.';
        // Logs a notice.
        \Drupal::logger('qed42_activities')->notice($message);
    }

}
