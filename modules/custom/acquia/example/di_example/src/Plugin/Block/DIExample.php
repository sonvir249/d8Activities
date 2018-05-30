<?php

/**
 * @file
 * Contains \Drupal\di_example\Plugin\Block\DIExample.
 */

namespace Drupal\di_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\di_example\DITalk;

/**
 * Provides a block to that shows a conversation about mood.
 *
 * @Block(
 *   id = "di_example_conversation_mood",
 *   admin_label = @Translation("DI Example: Conversation about mood")
 * )
 */
class DIExample extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * @var $dITalk \Drupal\di_example\DITalk
   */
  protected $dITalk;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\di_example\DITalk $DITalk
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DITalk $DITalk) {
    // Call parent construct method.
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    // Store our dependency.
    $this->dITalk = $DITalk;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('di_example.talk')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // We use the injected service to get the message.
    $message = $this->dITalk->getResponseToMood();

    // We return a render array of the message.
    return [
      '#type' => 'markup',
      '#markup' => '<p>' . $this->t($message) . '</p>',
    ];
  }
}