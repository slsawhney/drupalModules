<?php

namespace Drupal\ej_market_data\Plugin\api_proxy;

use Drupal\api_proxy\Plugin\api_proxy\HttpApiCommonConfigs;
use Drupal\api_proxy\Plugin\HttpApiPluginBase;
use Drupal\Core\Form\SubformStateInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * The Example API.
 *
 * @HttpApi(
 *   id = "api-market-data",
 *   label = @Translation("Get market data API"),
 *   description = @Translation("Proxies requests to the Get market data API."),
 *   serviceUrl = "https://private-76df77-mockapi58.apiary-mock.com",
 * )
 */
final class getMarketData extends HttpApiPluginBase {

  use HttpApiCommonConfigs;

  /**
   * {@inheritdoc}
   */
  public function addMoreConfigurationFormElements(array $form, SubformStateInterface $form_state): array {
    $form['auth_token'] = $this->authTokenConfigForm($this->configuration);
    $form['more_stuff'] = ['#type' => 'textfield', '#title' => $this->t('Extra config')];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function postprocessOutgoing(Response $response): Response {
    $content = [];
    if (!empty($response->getContent())) {
      $response_content = json_decode($response->getContent());
      if (!empty($response_content->result) && $response_content->status->code == '200') {
        // Modify the response from the API.
        foreach ($response_content->result as $response_item) {
          $content['result'][] = (object) ['lastClosePrice'=> (float) str_replace(',', '', $response_item->lastClosePrice), 'priceChange' => (float) str_replace(',', '', $response_item->priceChange), 'symbol' => $response_item->symbol];
        }
      }
    }
    $response->setContent(json_encode($content));
    return $response;
  }

}
