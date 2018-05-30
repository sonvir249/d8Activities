<?php

namespace Drupal\qed42_activities\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\qed42_activities\DICFormService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class DicForm extends FormBase
{
    protected $DICFormService;

    /**
   *
   */
    public function __construct(DICFormService $DICFormService) 
    {
        $this->DICFormService = $DICFormService;
    }

    /**
   *
   */
    public static function create(ContainerInterface $container) 
    {
        return new static(
        $container->get('dic_form.fetchservice')
        );
    }

    /**
   *
   */
    public function getFormId() 
    {
        // TODO: Implement getFormId() method.
        return 'dic_form';
    }

    /**
   *
   */
    public function buildForm(array $form, FormStateInterface $form_state) 
    {
        // Fetch data.
        $user_data = $this->DICFormService->fetchData();

        $form['fname'] = [
        '#type' => 'textfield',
        '#title' => 'First Name',
        '#default_value' => !empty($user_data['fname']) ? $user_data['fname'] : '',
        ];

        $form['lname'] = [
        '#type' => 'textfield',
        '#title' => 'Last Name',
        '#default_value' => !empty($user_data['lname']) ? $user_data['lname'] : '',
        ];

        $form['qualification'] = [
        '#type' => 'select',
        '#title' => 'Qualification',
        '#options' => ['UG' => 'U.G.', 'PG' => 'P.G.', 'Other' => 'Other'],
        '#default_value' => !empty($user_data['qualification']) ? $user_data['qualification'] : '',
        ];

        $form['other'] = [
        '#type' => 'textfield',
        '#title' => 'Please specify other',
        '#default_value' => !empty($user_data['other']) ? $user_data['other'] : '',
        '#states' => [
        'visible' => [
          ':input[name="qualification"]' => ['value' => 'Other'],
        ],
        ],
        ];

        $form['country'] = [
        '#type' => 'select',
        '#title' => 'Country',
        '#options' => ['India' => 'India', 'UK' => 'UK'],
        '#default_value' => !empty($user_data['country']) ? [$user_data['country']] : '',
        ];

        $form['indian_state'] = [
        '#type' => 'select',
        '#title' => 'State',
        '#options' => ['MH' => 'MH', 'RJ' => 'RJ'],
        '#default_value' => !empty($user_data['state']) ? $user_data['state'] : '',
        '#states' => [
        'visible' => [
          ':input[name="country"]' => ['value' => 'India'],
        ],
        ],
        ];

        $form['uk_state'] = [
        '#type' => 'select',
        '#title' => 'State',
        '#options' => ['UK' => 'UK'],
        '#default_value' => !empty($user_data['state']) ? $user_data['state'] : '',
        '#states' => [
        'visible' => [
          ':input[name="country"]' => ['value' => 'UK'],
        ],
        ],
        ];

        $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
        ];

        return $form;
    }

    // Public function validateForm(array &$form, FormStateInterface $form_state) {
    // .
    /**
   * }.
   */
    public function submitForm(array &$form, FormStateInterface $form_state) 
    {
        // TODO: Implement submitForm() method.
        $user_data = [
        'fname' => $form_state->getValue('fname'),
        'lname' => $form_state->getValue('lname'),
        'qualification' => $form_state->getValue('qualification'),
        'other' => $form_state->getValue('other'),
        'country' => $form_state->getValue('country'),
        'state' => ($form_state->getValue('country') == 'India') ? $form_state->getValue('indian_state') : $form_state->getValue('uk_state'),
        ];

        // Insert dorm data.
        if ($this->DICFormService->insertFormValue($user_data)) {
            drupal_set_message(t('User data saved.'), 'status', true);
        }
    }

}
