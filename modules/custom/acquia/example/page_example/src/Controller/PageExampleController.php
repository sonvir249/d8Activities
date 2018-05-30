<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 27/11/17
 * Time: 7:29 PM
 */

namespace Drupal\page_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PageExampleController
 * @package Drupal\page_example\Controller
 */
class PageExampleController extends ControllerBase
{

  protected $entity_query;
  public function __construct(QueryFactory $entity_query) {
    $this->entity_query = $entity_query;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.query')
    );
  }

  public function description() {
    $entity_manager = \Drupal::entityTypeManager();
    $node = $entity_manager->getStorage('node')->load(1);
    $simple_url = Url::fromRoute('page_example_simple');
    $simple_link = Link::fromTextAndUrl(t('Simple Page'), $simple_url)->toString();

    $arguments_url = Url::fromRoute('page_example_description', [], ['absolute' => TRUE]);
    $arguments_link = Link::fromTextAndUrl(t('arguments page'), $arguments_url)->toString();

    return [
      '#markup' => t('The Page example module provides two pages, "simple" and "arguments".'),
    ];
  }

  public function simple() {
    return [
      '#markup' => t('The Page example module provides two pages, "simple" and "arguments".'),
    ];
  }
}