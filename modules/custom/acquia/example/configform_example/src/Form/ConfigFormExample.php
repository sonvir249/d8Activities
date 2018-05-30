<?php

namespace Drupal\configform_example\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * {@inheritdoc}.
 */
class ConfigFormExample extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getEditableConfigNames() {
    return ['configform_example.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'configform_example_settings_form';
  }


  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('configform_example.settings');
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your .com email address.'),
      '#default_value' => $config->get('email'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('configform_example.settings')
      ->set('bio', $form_state->getValue('email'))
      ->save();
  }
}
