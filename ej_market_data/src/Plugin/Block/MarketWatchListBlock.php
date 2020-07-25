<?php

namespace Drupal\ej_market_data\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a 'Market WathcList' Block.
 *
 * @Block(
 *   id = "ej_market_watch_list_block",
 *   admin_label = @Translation("Market WathcList"),
 *   category = @Translation("Edward Jones Market WathcList"),
 * )
 */
class MarketWatchListBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    //$market_data_service = \Drupal::service('ej_market_data.market_data_api_service');
    //$marketData = $market_data_service->getMarketData();
    $watchListItems = [];
    if(isset($_COOKIE['EJW_WATCHLIST'])){
      $watchListItems = explode('|', $_COOKIE['EJW_WATCHLIST']);
    }

    $header = array(
      'symbol' => $this->t('Company or Fund'),
      'price' => $this->t('Price'),
      'change' => $this->t('Change')
    );

    $rows = [];


    $i = 1;
    $editWatchLisLink = '';
    if($watchListItems){
      foreach ($watchListItems as $key => $watchListItem) {
        $rows[] = [
          'class' => (0 == $i % 2) ? ['bg-gray-300'] : '',
          'data' => [
            'symbol' => $watchListItem,
            'price' => '',
            'change' => '',
          ],
        ];
        ++$i;
      }
      $editWatchLisLink = Link::fromTextAndUrl($this->t('Edit your watch list >'), Url::fromRoute('ej_market_data.stockWatchList'))->toString();
    }

    $watchListTable = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#sticky' => false,
      '#empty' => $this->t('Sorry, No watchlist created.'),
      '#attributes' => [
        'class' => ['table table-auto, w-full'],
      ],
    ];
    
    return [
      '#theme' => 'ej_market_watch_list_block',
      '#watchListTable' => $watchListTable,
      '#title' => $this->t('Your Watch List'),
      '#editWatchLisLink' => $editWatchLisLink
    ];
  }
  
  public function getCacheMaxAge() {
    return False;
  }

}
