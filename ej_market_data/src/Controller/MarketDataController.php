<?php

/**
 * @file
 * Contains \Drupal\ej_market_data\Controller\MarketDataController.
 */

namespace Drupal\ej_market_data\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InsertCommand;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MarketDataController extends ControllerBase {

  public function symbolAutocomplete(Request $request) {
    $input = $request->query->get('q');

    $market_data_service = \Drupal::service('ej_market_data.market_data_api_service');

    $symbolData = $market_data_service->getSymbols($input);

    return new JsonResponse($symbolData);
  }

  public function getAQuote($symbolId = null) {
    $market_data_service = \Drupal::service('ej_market_data.market_data_api_service');

    $symbolDetails = array_shift($market_data_service->getSymbolDetails($symbolId));

    $header_table = [
      'key' => t(''),
      'value' => t(''),
    ];
    $rows = [];

    $stockDetails = [
      'stockName' => $symbolDetails->description,
      'stockDate' => $symbolDetails->lastTradeDate . ' ' . $symbolDetails->lastTradeTime,
    ];

    $i = 1;
    foreach ($symbolDetails as $key => $symbolDetail) {
      $rows[] = [
        'class' => (0 == $i % 2) ? ['bg-gray-300'] : '',
        'data' => [
          'key' => $key,
          'value' => $symbolDetail,
        ],
      ];
      ++$i;
    }

    $table = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#sticky' => false,
      '#attributes' => [
        'class' => ['table table-auto, w-9/12'],
      ],
    ];

    return [
      '#theme' => 'ej_get_a_quote',
      '#table' => $table,
      '#stockDetails' => $stockDetails,
      '#stockSymbol' => $symbolId,
      '#attached' => [
        'library' => [
          'ej_market_data/ej_market_data',
        ],
        'drupalSettings' => [
          'selectedSymbol' => $symbolId,
        ],
      ],
    ];
  }
  
  public function getMostActiveFunds(){
    $response = new AjaxResponse ();

    $market_data_service = \Drupal::service('ej_market_data.market_data_api_service');
    $mostActiveFunds = $market_data_service->getMostActiveFunds();
    
    $header_table = [
      'description' => $this->t('Index'),
      'lastClosePrice' => $this->t('Current'),
      'priceChange' => $this->t('Net Change'),
      'percentChange' => $this->t('% Change'),
    ];
    $rows = [];

    $i = 1;
    foreach ($mostActiveFunds as $key => $mostActiveFund) {
      $tdClass = ($mostActiveFund->priceChange > 0) ? 'text-green-500' : 'text-red-500';
      $rows[$key] = [
        'class' => (0 == $i % 2) ? ['bg-gray-300'] : '',
        'data' => [
          'description' => ['data' => $mostActiveFund->description],
          'lastClosePrice' => ['data' => $mostActiveFund->lastClosePrice],
          'priceChange' => ['data' => $mostActiveFund->priceChange, 'class' => $tdClass],
          'percentChange' => ['data' => $mostActiveFund->percentChange, 'class' => $tdClass]
        ],
      ];
      ++$i;
    }

    $table = [
      '#type' => 'table',
      '#header' => $header_table,
      '#rows' => $rows,
      '#sticky' => false,
      '#attributes' => [
        'class' => ['table table-auto w-full'],
      ],
    ];

    $response-> addCommand (new InsertCommand ('#nyse_most_active_container', drupal_render($table)));
 
    return $response;
  }
}
