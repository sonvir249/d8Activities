<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 29/11/17
 * Time: 1:38 PM
 */

/**
 * @file
 * Contains \Drupal\block_example\Plugin\Block\ExampleConfigurableTextBlock.
 */

namespace Drupal\block_example\Plugin\Block;

use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Example: configurable text string' block.
 *
 * Drupal\block\BlockBase gives us a very useful set of basic functionality for
 * this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "example_configurable_text",
 *   admin_label = @Translation("Title of first block (example_configurable_text)"),
 *   category = @Translation("Custom Block Example")
 * )
 */
class ExampleConfigurableTextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'block_example_string' => $this->t('A default value. This block was created at %time', ['%time' => date('c')]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter City'),
      '#size' => 60,
      '#description' => $this->t('City name to get weather data.'),
      '#default_value' => $this->configuration['block_example_string'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['block_example_string']
      = $form_state->getValue('block_example_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'markup',
      '#markup' => $this->configuration['block_example_string'],
    ];
  }

}