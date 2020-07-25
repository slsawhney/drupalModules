<?php

namespace Drupal\ej_market_data\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Get A Stock Quote' Block.
 *
 * @Block(
 *   id = "ej_get_a_stock_quote_block",
 *   admin_label = @Translation("Get A Stock Quote"),
 *   category = @Translation("Edward Jones Get A Stock Quote"),
 * )
 */
class GetAStockQuoteBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $quoteForm = \Drupal::formBuilder()->getForm('Drupal\ej_market_data\Form\GetAStockQuoteForm');

    return [
      '#theme' => 'ej_get_a_stock_quote_block',
      '#title' => $this->t('Get A Stock Quote'),
      '#quoteForm' => $quoteForm,
    ];
  }
  
  public function getCacheMaxAge() {
    return False;
  }
  
}
