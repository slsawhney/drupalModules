<?php

/**
 * @file
 * Contains \Drupal\ej_market_data\Form\EJMDConfiguration.
 */

namespace Drupal\ej_market_data\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class EJMDConfigurationForm extends ConfigFormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'ej_market_data_configuration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $configuration = $this->config('ej_market_data.adminsettings');

    $form['ej_market_data_web_service_url'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Web Service URL'),
        '#description' => $this->t('Web Service API URL for Market Data. Don\'t include slashes'),
        '#default_value' => $configuration->get('ej_market_data_web_service_url'),
        '#required' => true,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    parent::submitForm($form, $form_state);

    $this->config('ej_market_data.adminsettings')
        ->set('ej_market_data_web_service_url', $form_state->getValue('ej_market_data_web_service_url'))
        ->save();
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
        'ej_market_data.adminsettings',
    ];
  }
}
