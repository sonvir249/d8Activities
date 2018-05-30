<?php

namespace Drupal\qed42_activities\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 */
class WeatherConfig extends ConfigFormBase
{

    /**
   *
   */
    public function getEditableConfigNames() 
    {
        return ['qed42_activities.settings'];
    }

    /**
   * {@inheritdoc}
   */
    public function getFormId() 
    {
        return 'weather_Form';
    }

    /**
   * {@inheritdoc}
   */
    public function buildForm(array $form, FormStateInterface $form_state) 
    {
        $config = $this->config('qed42_activities.settings');

        $form['app_id'] = [
        '#type' => 'textfield',
        '#title' => 'App ID',
        '#default_value' => $config->get('app_id'),
        ];
        return parent::buildForm($form, $form_state);
    }

    /**
   * {@inheritdoc}
   */
    public function validateForm(array &$form, FormStateInterface $form_state) 
    {
        parent::validateForm($form, $form_state);
    }

    /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state) 
    {
        parent::submitForm($form, $form_state);
        $this->config('qed42_activities.settings')
            ->set('app_id', $form_state->getValue('app_id'))
            ->save();
    }

}
