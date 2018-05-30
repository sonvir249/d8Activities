<?php

namespace Drupal\qed42_activities\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 */
class SimpleForm extends FormBase
{

    /**
   *
   */
    public function getFormId() 
    {
        // TODO: Implement getFormId() method.
        return 'simple_form';
    }

    /**
   *
   */
    public function buildForm(array $form, FormStateInterface $form_state) 
    {
        $form['name'] = [
        '#type' => 'textfield',
        '#title' => 'Name',
        ];

        $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
        ];

        return $form;
    }

    /**
   *
   */
    public function validateForm(array &$form, FormStateInterface $form_state) 
    {
        if (strlen($form_state->getValue('name')) > 5) {
            $form_state->setErrorByName('name', t('Error Message'));
        }
    }

    /**
   *
   */
    public function submitForm(array &$form, FormStateInterface $form_state) 
    {
        // TODO: Implement submitForm() method.
        drupal_set_message(t('You entered name is ' . $form_state->getValue('name')), 'status', true);
    }

}
