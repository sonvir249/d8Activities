<?php

namespace Drupal\qed42_activities;

use Drupal\Core\Routing\Access\AccessInterface;
use Symfony\Component\Routing\Route;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatch;

/**
 *
 */
class ActivitiesService implements AccessInterface
{

    protected $currentUser;
    protected $nodeId;
    protected $nodeOwnerId;

    /**
   *
   */
    public function __construct(AccountProxy $current_user) 
    {
        $this->currentUser = $current_user;
    }

    /**
   *
   */
    public function access(Route $route, RouteMatch $routeMatch) 
    {

        $nodeId = $routeMatch->getParameter('node')->id();
        $nodeOwnerId = $routeMatch->getParameter('node')->getOwner()->id();

        /**
     * Compare login user with node author.
     */
        if ($route->getRequirement('_custom_access_check') === 'TRUE') {
            if ($this->currentUser->id() == $nodeOwnerId) {
                return AccessResult::allowed();
            }
            else {
                return AccessResult::forbidden();
            }
        }
        elseif ($route->getRequirement('_custom_access_check') === 'FALSE') {
            return AccessResult::forbidden();
        }
        else {
            return AccessResult::neutral();
        }
    }

}
