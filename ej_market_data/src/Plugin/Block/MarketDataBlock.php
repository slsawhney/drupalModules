<?php

namespace Drupal\ej_market_data\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Market data' Block.
 *
 * @Block(
 *   id = "ej_market_data_block",
 *   admin_label = @Translation("Market Data"),
 *   category = @Translation("Edward Jones Market Data"),
 * )
 */
class MarketDataBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $market_data_service = \Drupal::service('ej_market_data.market_data_api_service');

    $marketData = $market_data_service->getMarketData();

    return [
      '#theme' => 'ej_market_data_block',
      '#title' => $this->t('Market data'),
      '#marketData' => $marketData,
    ];
  }
    
  public function getCacheMaxAge() {
    return False;
  }
  
}
