<?php

namespace Drupal\qed42_activities\Controller;

use Drupal\node\NodeInterface;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatch;

/**
 *
 */
class RoutingController
{

    protected $currentUser;
    protected $nodeId;
    protected $nodeOwnerId;

    /**
   *
   */
    public function static_callback() 
    {
        return [
        '#markup' => 'Hello! I am your node listing page.',
        ];
    }

    /**
   *
   */
    public function arg_demo($arg) 
    {
        return [
        '#markup' => 'Hello! I am your arg: ' . $arg,
        ];
    }

    /**
   *
   */
    public function node_list(NodeInterface $node) 
    {
        return [
        '#markup' => 'Node Title: ' . $node->getTitle(),
        ];
    }

    public function access(RouteMatch $routeMatch) 
    {
        $user_id = \Drupal::currentUser()->id();
        $nodeOwnerId = $routeMatch->getParameter('node')->getOwner()->id();
        if ($user_id == $nodeOwnerId) {
          return AccessResult::allowed();
        }
        else {
          // Return 403 Access Denied page.
          return AccessResult::forbidden();
        }

        //    /**
        //     * Compare login user with node author.
        //     */
        //    if ($route->getRequirement('_custom_access_check') === 'TRUE') {
        //      if ($user_id == $nodeOwnerId) {
        //        return AccessResult::allowed();
        //      }
        //      else {
        //        return AccessResult::forbidden();
        //      }
        //    }
        //    elseif ($route->getRequirement('_custom_access_check') === 'FALSE') {
        //      return AccessResult::forbidden();
        //    }
        //    else {
        //      return AccessResult::neutral();
        //    }
    }
}
