<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 26/12/17
 * Time: 2:51 PM
 */

namespace Drupal\service_example\Controller;

use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\service_example\ServiceExampleService;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceExampleController extends ControllerBase
{
  /**
   * @var \Drupal\service_example\ServiceExampleService
   */
  protected $serviceExampleService;

  /**
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $query_factory;

  /**
   * {@inheritdoc}
   */
  public function __construct(ServiceExampleService $serviceExampleService, QueryFactory $query_factory) {
    $this->serviceExampleService = $serviceExampleService;
    $this->query_factory = $query_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('service_example.example_service'),
      $container->get('entity.query')
    );
  }

  public function simple_example() {
    return [
      '#markup' => $this->serviceExampleService->getServiceExampleValue()
    ];
  }
}