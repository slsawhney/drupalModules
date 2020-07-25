<?php

namespace Drupal\ej_market_data\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Market Graph' Block.
 *
 * @Block(
 *   id = "ej_market_graph_block",
 *   admin_label = @Translation("Market Graph"),
 *   category = @Translation("Edward Jones Market Graph"),
 * )
 */
class MarketGraphBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {

    return [
      'fixed_income' => $this->t('Fixed Income Block Text'),
      'economic_indicators' => $this->t('Economic Indicators Block Text'),
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'ej_market_data_graph_form';
  }
  
  /**
   * {@inheritdoc}
   */
   public function blockForm($form, FormStateInterface $form_state)
   {
      $form = parent::blockForm($form, $form_state);

      $config = $this->getConfiguration();
      $form['fixed_income'] = array(
          '#type' => 'text_format',
          '#title' => $this->t('Fixed Income'),
          '#description' => $this->t('Fixed Income'),
          '#rows' => 50,
          '#default_value' => isset($config['fixed_income']) ? $this->t($config['fixed_income']) : '',
      );

      $form['economic_indicators'] = array(
          '#type' => 'text_format',
          '#title' => $this->t('Economic Indicators'),
          '#description' => $this->t('Economic Indicators'),
          '#rows' => 50,
          '#default_value' => isset($config['economic_indicators']) ? $config['economic_indicators'] : '',
      );

      return $form;
   }

   /**
    * {@inheritdoc}
    */
   public function blockSubmit($form, FormStateInterface $form_state) {
      parent::blockSubmit($form, $form_state);

      $values = $form_state->getValues();
      $this->configuration['fixed_income'] = $values['fixed_income']['value'];
      $this->configuration['economic_indicators'] = $values['economic_indicators']['value'];
   }
   
  /**
    * {@inheritdoc}
    */
  public function build() {
    $market_data_service = \Drupal::service('ej_market_data.market_data_api_service');
    $chartsData = $market_data_service->getChartsData();

    $chartIndexData = [];
    foreach($chartsData as $key => $chartData){
      foreach($chartData -> date as $itemKey => $indexDate){
        $chartIndexData[strtolower($chartData->name)][] = [
          strtotime(str_replace(',' , '/', $indexDate)), round($chartData->price[$itemKey],2)
        ];
      }
    }

    return [
      '#theme' => 'ej_market_graph_block',
      '#title' => $this->t(''),
      '#chartData' => $chartData,
      '#fixed_income' => $this->configuration['fixed_income'],
      '#economic_indicators' => $this->configuration['economic_indicators'],
      '#attached' => [
        'library' => [
          'ej_market_data/ej_market_graph',
        ],
        'drupalSettings' => [
          'dijaData' => json_encode($chartIndexData['dija']),
          'spx' => json_encode($chartIndexData['spx']),
          'compq' => json_encode($chartIndexData['compq'])
        ],
      ],
    ];
  }
 
  public function getCacheMaxAge() {
    return False;
  }
  
}
