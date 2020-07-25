<?php

/**
 * @file
 * Contains \Drupal\ej_market_data\Form\StockWatchListForm.
 */

namespace Drupal\ej_market_data\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class StockWatchListForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'stock_watch_list_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if (isset($_COOKIE['EJW_WATCHLIST'])) {
      $watchListItems = explode('|', $_COOKIE['EJW_WATCHLIST']);

      // #TODO working without TR AND  TD CSS 
      $header = array(
        'symbol' => $this->t('Symbol'),
        'exchange' => $this->t('Exchange'),
        'price' => $this->t('Price'),
        'change' => $this->t('Change'),
        'week_high' => $this->t('52-week High'),
        'week_low' => $this->t('52-week Low'),
        'pe_ration' => $this->t('P/E Ratio'),
        'dividend' => $this->t('Dividend'),
        'remove' => $this->t('Remove'),
      );
      $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#attributes' => [
          'class' => ['table table-auto w-full'],
        ],
        '#suffix' => '<br>'
      ];

      $i = 0;
      foreach ($watchListItems as $key => $watchListItem) {
        $form['table'][$i]['symbol'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['exchange'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['price'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['change'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['week_high'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['week_low'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['pe_ration'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['dividend'] = [
          '#markup' => t($watchListItem),
        ];
        $form['table'][$i]['remove'] = [
          '#type' => 'checkbox',
          '#return_value' => $watchListItem,
        ];
        $i++;
      }


      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Remove Selected')
      ];
      return $form;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $submittedSymbols = $form_state->getValue('table');
    $explodedSymbols = explode("|", $_COOKIE['EJW_WATCHLIST']);
    foreach ($submittedSymbols as $key => $submittedSymbol) {
      if ($submittedSymbol['remove']) {
        unset($explodedSymbols[$key]);
      }
    }

    $implodeString = implode("|", $explodedSymbols);

    setcookie("EJW_WATCHLIST", $implodeString, strtotime('+365 days'), '/', \Drupal::request()->getHost());

    $form_state->setRedirect('ej_market_data.stockWatchList');
  }

}
