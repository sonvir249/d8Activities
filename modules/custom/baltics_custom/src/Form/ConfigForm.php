<?php

namespace Drupal\baltics_custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the settings form.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['baltics_custom.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'baltics_config_Form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('baltics_custom.settings');
    $form['menu_title_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Menu title character length'),
      '#description' => $this->t('Menu title length can be between 8 and 15 characters.'),
      '#min' => 8,
      '#max' => 15,
      '#default_value' => !$config->get('menu_title_char_length') ? 12 : $config->get('menu_title_char_length'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('baltics_custom.settings')
      ->set('menu_title_char_length', $form_state->getValue('menu_title_length'))
      ->save();
  }

}
