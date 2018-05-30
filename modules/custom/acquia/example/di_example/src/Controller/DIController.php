<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 27/12/17
 * Time: 3:44 PM
 */

namespace Drupal\di_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\di_example\DIMoodRing;
use Drupal\di_example\DITalk;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DIController extends ControllerBase
{
  protected $DITalk;
  protected $DIMoodRing;

  public function __construct(DITalk $DITalk, DIMoodRing $DIMoodRing)
  {
    $this->DITalk = $DITalk;
    $this->DIMoodRing = $DIMoodRing;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('di_example.talk'),
      $container->get('di_example.mood_ring')
    );
  }

  public function conversationAboutMood() {
    return [
      '#markup' => $this->DITalk->getResponseToMood()
    ];
  }
}