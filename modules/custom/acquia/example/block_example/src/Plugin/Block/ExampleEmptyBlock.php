<?php

namespace Drupal\block_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'ExampleEmptyBlock' block.
 *
 * Drupal\block\BlockBase gives us a very useful set of basic functionality for
 * this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "example_empty_text",
 *   admin_label = @Translation("Title of first block (ExampleEmptyBlock)"),
 *   category = @Translation("Custom Block ExampleEmptyBlock")
 * )
 */
class ExampleEmptyBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $form = \Drupal::formBuilder()->getForm('Drupal\page_example\Form\PageExampleForm');
    return [
      'block_example_form' => $form,
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\page_example\Form\PageExampleForm');
    dpm($form);
    return [
      '#markup' => $this->configuration['block_example_form'],
    ];
  }
}
