<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 26/12/17
 * Time: 3:53 PM
 */

namespace Drupal\theme_example\Controller;
use Drupal\Core\Controller\ControllerBase;

class ThemeExampleController extends ControllerBase
{
  public function simple() {
    return [
      '#markup' => 123,
      '#theme' => 'my_element',
//      '#type' => 'my_element',
      '#label' => $this->t('Example Label'),
      '#description' => $this->t('This is the description text.')
    ];
  }
}