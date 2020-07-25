<?php

/**
 * @file
 * Contains \Drupal\ej_market_data\Form\GetAStockQuoteForm.
 */

namespace Drupal\ej_market_data\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;


class GetAStockQuoteForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'get_a_stock_quote_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['quote_symbol'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Enter a Symbol'),
      '#required' => true,
      '#autocomplete_route_name' => 'ej_market_data.symbol_autocomplete',
      '#attributes' => [
        'class' => ['form-input w-full py-3 pl-10 text-sm mb-5 lg:mb-0'],
      ],
    ];

    $form['quote_submit_url'] = [
      '#type' => 'hidden',
    ];
    $form['form_type'] = [
      '#type' => 'hidden',
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit')
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $symbolData= explode('-',$form_state->getValue('quote_symbol'));
    $symbolId = '';
    if(is_array($symbolData)){
      $symbolId = $symbolData[0];
    }

    $savedUrl = Url::fromUri($form_state->getValue('quote_submit_url'))->toString();
    $redirectLink = $savedUrl.'&id='.$symbolId;

    $response = new RedirectResponse($redirectLink, 302);

    return $response->send();
  }
}
