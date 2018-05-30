<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 29/11/17
 * Time: 3:07 PM
 */

namespace Drupal\page_example\Form;

use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class PageExampleForm extends FormBase {

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your .com email address'),
      '#description' => $this->t('Contains email address.'),
      '#required' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  public function getFormId() {
    return 'page_example_form';
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    if (!preg_match('/.com/', $email)) {
      $form_state->setErrorByName('email', t('Invalid email address'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    drupal_set_message(t('Entered email:  @email', ['@email' => $email]));
  }
}