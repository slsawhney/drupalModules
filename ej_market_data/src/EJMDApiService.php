<?php

namespace Drupal\ej_market_data;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EJMDApiService {

  protected $ej_market_data_web_service_url;

  /**
   * The HTTP client to fetch the Image data with.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Constructs a new DataPush object.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
    $this->ej_market_data_web_service_url = \Drupal::config('ej_market_data.adminsettings')->get('ej_market_data_web_service_url');
  }

  // Uses Symfony's ContainerInterface to declare dependency to be passed to constructor
  public static function create(ContainerInterface $container) {
    return new static($container->get('http_client'));
  }

  public function getMarketData() {
    $apiResponse = '[
            {
                "closeDate": "09 APR 2020",
                "description": "DJ INDU AVERG",
                "lastClosePrice": "23,719.37",
                "lastTradeDate": "13 APR 2020",
                "lastTradePrice": "23,274.96",
                "lastTradeTime": "11:48 EST",
                "percentChange": "-1.87",
                "priceChange": "-444.41",
                "symbol": "DJIA",
                "todaysHigh": "23,698.93",
                "todaysLow": "23,095.35",
                "type": "I",
                "week52High": "29,568.57",
                "week52Low": "18,213.65"
            },
            {
                "closeDate": "09 APR 2020",
                "description": "NASDAQ COMPOSITE",
                "lastClosePrice": "8,153.58",
                "lastTradeDate": "13 APR 2020",
                "lastTradePrice": "8,102.47",
                "lastTradeTime": "11:48 EST",
                "percentChange": "-0.63",
                "priceChange": "51.11",
                "symbol": "NASDAQ",
                "todaysHigh": "8,145.28",
                "todaysLow": "8,035.95",
                "type": "I",
                "week52High": "9,838.37",
                "week52Low": "6,631.42"
            },
            {
                "closeDate": "09 APR 2020",
                "description": "S&P 500 INDEX",
                "lastClosePrice": "2,789.82",
                "lastTradeDate": "13 APR 2020",
                "lastTradePrice": "2,743.47",
                "lastTradeTime": "11:48 EST",
                "percentChange": "-1.66",
                "priceChange": "-46.35",
                "symbol": "S&P 500",
                "todaysHigh": "2,782.46",
                "todaysLow": "2,721.17",
                "type": "I",
                "week52High": "3,393.52",
                "week52Low": "2,191.86"
            }
        ]';

    return $apiResponse = json_decode($apiResponse);
    /* try {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $request = $this->httpClient->get($this->ej_market_data_web_service_url . '/v1/quotes/exchanges/{country}/country', [
      'headers' => [
      'Authorization' => 'Bearer ' . $auth_token,
      'Content-Type' => 'application/json',
      ],
      ]);

      return $apiResponse = json_decode($request->getBody());
      }
      catch (ClientException | RequestException | TransferException | BadResponseException $exception) {
      watchdog_exception('ej_market_data', $exception, null, [], 6);

      return json_decode((string) $exception->getResponse()->getBody());
      } */
  }

  /**
   * @param string $input
   *
   * @return array $apiResponse
   */
  public function getSymbols($input = null) {
    $apiResponse = '[
            {
              "symbol": "APLE",
              "symbolDescription": "APPLE HOSPITALITY REIT NEW"
            },
            {
              "symbol": "AAPL",
              "symbolDescription": "APPLE INC"
            },
            {
              "symbol": "APPLX",
              "symbolDescription": "APPLESEED"
            },
            {
              "symbol": "APPIX",
              "symbolDescription": "APPLESEED INSTL"
            },
            {
              "symbol": "CHK.N",
              "symbolDescription": "CHESAPEAKE ENER"
            },
            {
              "symbol": "F.N",
              "symbolDescription": "FORD MOTOR CO"
            },
            {
              "symbol": "CCL.N",
              "symbolDescription": "CARNIVAL CORP"
            },
            {
              "symbol": "DAL.N",
              "symbolDescription": "DELTA AIR LIN"
            },
            {
              "symbol": "GE.N",
              "symbolDescription": "GENERAL ELEC CO"
            },
            {
              "symbol": "MRO.N",
              "symbolDescription": "MARATHON OIL"
            }
        ]';

    return $apiResponse = $this->convertDataToAutoFillFormat(json_decode($apiResponse), $input);
    /* try {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $request = $this->httpClient->get($this->ej_market_data_web_service_url . '/v1/symbols/'.$input.'/lookup', [
      'headers' => [
      'Authorization' => 'Bearer ' . $auth_token,
      'Content-Type' => 'application/json',
      ],
      ]);

      return $apiResponse = json_decode($request->getBody());
      }
      catch (ClientException | RequestException | TransferException | BadResponseException $exception) {
      watchdog_exception('ej_market_data', $exception, null, [], 6);

      return json_decode((string) $exception->getResponse()->getBody());
      } */
  }

  public function getSymbolDetails($symbol = null) {
    //#todo: API MISSING in Confluence Doc

    $apiResponse = [];
    if ($symbol) {
      $apiResponse = '[
            {
              "closeDate": "09 APR 2020",
              "currency": "USA",
              "description": "BARRICK GOLD CRP",
              "dividendPayDate": "16 MAR 2020",
              "dividendYield": "0.28",
              "dividendYieldPercent": "1.15",
              "eps": "2.25",
              "expirationDate": "27 FEB 2020",
              "lastClosePrice": "22.51",
              "lastTradeDate": "13 APR 2020",
              "lastTradePrice": "24.37",
              "lastTradeTime": "13:36 EST",
              "peRatio": "10.00",
              "percentChange": "+8.26",
              "priceChange": "+1.86",
              "stockExchange": "NYSE",
              "stockVolume": "4,001,609",
              "symbol": "GOLD.N",
              "todaysHigh": "24.76",
              "todaysLow": "22.25",
              "type": "S",
              "week52High": "22.56",
              "week52Low": "11.66"
            }
          ]';
    }

    return $apiResponse = json_decode($apiResponse);
    /* try {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $request = $this->httpClient->get($this->ej_market_data_web_service_url . '/v1/quotes/exchanges/{country}/country', [
      'headers' => [
      'Authorization' => 'Bearer ' . $auth_token,
      'Content-Type' => 'application/json',
      ],
      ]);

      return $apiResponse = json_decode($request->getBody());
      }
      catch (ClientException | RequestException | TransferException | BadResponseException $exception) {
      watchdog_exception('ej_market_data', $exception, null, [], 6);

      return json_decode((string) $exception->getResponse()->getBody());
      } */
  }

  public function getChartsData() {
    $apiResponse = '[
            {
                "name": "DIJA",
                "date": [
                    "2020,04,09",
                    "2020,04,08",
                    "2020,04,07",
                    "2020,04,06",
                    "2020,04,03",
                    "2020,04,02",
                    "2020,04,01",
                    "2020,03,31",
                    "2020,03,30",
                    "2020,03,27",
                    "2020,03,26",
                    "2020,03,25",
                    "2020,03,24",
                    "2020,03,23",
                    "2020,03,20",
                    "2020,03,19",
                    "2020,03,18",
                    "2020,03,17",
                    "2020,03,16",
                    "2020,03,13",
                    "2020,03,12",
                    "2020,03,11",
                    "2020,03,10",
                    "2020,03,09",
                    "2020,03,06",
                    "2020,03,05",
                    "2020,03,04",
                    "2020,03,03",
                    "2020,03,02",
                    "2020,02,28",
                    "2020,02,27",
                    "2020,02,26",
                    "2020,02,25",
                    "2020,02,24",
                    "2020,02,21",
                    "2020,02,20",
                    "2020,02,19",
                    "2020,02,18",
                    "2020,02,14",
                    "2020,02,13",
                    "2020,02,12",
                    "2020,02,11",
                    "2020,02,10",
                    "2020,02,07",
                    "2020,02,06",
                    "2020,02,05",
                    "2020,02,04",
                    "2020,02,03",
                    "2020,01,31",
                    "2020,01,30",
                    "2020,01,29",
                    "2020,01,28",
                    "2020,01,27",
                    "2020,01,24",
                    "2020,01,23",
                    "2020,01,22",
                    "2020,01,21",
                    "2020,01,17",
                    "2020,01,16",
                    "2020,01,15",
                    "2020,01,14"
                ],
                "price": [
                    "23719.4",
                    "23433.6",
                    "22653.9",
                    "22680",
                    "21052.5",
                    "21413.4",
                    "20943.5",
                    "21917.2",
                    "22327.5",
                    "21636.8",
                    "22552.2",
                    "21200.6",
                    "20704.9",
                    "18591.9",
                    "19174",
                    "20087.2",
                    "19898.9",
                    "21237.4",
                    "20188.52",
                    "23185.6",
                    "21200.6",
                    "23553.22",
                    "25018.2",
                    "23851",
                    "25864.8",
                    "26121.3",
                    "27090.9",
                    "25917.4",
                    "26703.3",
                    "25409.4",
                    "25766.6",
                    "26957.6",
                    "27081.4",
                    "27960.8",
                    "28992.4",
                    "29220",
                    "29348",
                    "29232.2",
                    "29398.1",
                    "29423.3",
                    "29551.4",
                    "29276.3",
                    "29276.8",
                    "29102.5",
                    "29379.8",
                    "29290.8",
                    "28807.6",
                    "28399.8",
                    "28256",
                    "28859.4",
                    "28734.4",
                    "28722.85",
                    "28535.8",
                    "28989.7",
                    "29160.1",
                    "29186.3",
                    "29196",
                    "29348.1",
                    "29297.6",
                    "29030.2",
                    "28939.7"
                ]
            },
            {
                "name": "SPX",
                "date": [
                    "2020,04,09",
                    "2020,04,08",
                    "2020,04,07",
                    "2020,04,06",
                    "2020,04,03",
                    "2020,04,02",
                    "2020,04,01",
                    "2020,03,31",
                    "2020,03,30",
                    "2020,03,27",
                    "2020,03,26",
                    "2020,03,25",
                    "2020,03,24",
                    "2020,03,23",
                    "2020,03,20",
                    "2020,03,19",
                    "2020,03,18",
                    "2020,03,17",
                    "2020,03,16",
                    "2020,03,13",
                    "2020,03,12",
                    "2020,03,11",
                    "2020,03,10",
                    "2020,03,09",
                    "2020,03,06",
                    "2020,03,05",
                    "2020,03,04",
                    "2020,03,03",
                    "2020,03,02",
                    "2020,02,28",
                    "2020,02,27",
                    "2020,02,26",
                    "2020,02,25",
                    "2020,02,24",
                    "2020,02,21",
                    "2020,02,20",
                    "2020,02,19",
                    "2020,02,18",
                    "2020,02,14",
                    "2020,02,13",
                    "2020,02,12",
                    "2020,02,11",
                    "2020,02,10",
                    "2020,02,07",
                    "2020,02,06",
                    "2020,02,05",
                    "2020,02,04",
                    "2020,02,03",
                    "2020,01,31",
                    "2020,01,30",
                    "2020,01,29",
                    "2020,01,28",
                    "2020,01,27",
                    "2020,01,24",
                    "2020,01,23",
                    "2020,01,22",
                    "2020,01,21",
                    "2020,01,17",
                    "2020,01,16",
                    "2020,01,15",
                    "2020,01,14"
                ],
                "price": [
                    "2789.82",
                    "2749.98",
                    "2659.41",
                    "2663.68",
                    "2488.65",
                    "2526.9",
                    "2470.5",
                    "2584.59",
                    "2626.65",
                    "2541.47",
                    "2630.07",
                    "2475.56",
                    "2447.33",
                    "2237.4",
                    "2304.92",
                    "2409.39",
                    "2398.1",
                    "2529.19",
                    "2386.13",
                    "2711.02",
                    "2480.64",
                    "2741.38",
                    "2882.23",
                    "2746.56",
                    "2972.37",
                    "3023.94",
                    "3130.12",
                    "3003.37",
                    "3090.23",
                    "2954.22",
                    "2978.76",
                    "3116.39",
                    "3128.21",
                    "3225.89",
                    "3337.75",
                    "3373.23",
                    "3386.15",
                    "3370.29",
                    "3380.16",
                    "3373.94",
                    "3379.45",
                    "3357.75",
                    "3352.09",
                    "3327.71",
                    "3345.78",
                    "3334.69",
                    "3297.59",
                    "3248.92",
                    "3225.52",
                    "3283.66",
                    "3273.4",
                    "3276.24",
                    "3243.63",
                    "3295.47",
                    "3325.54",
                    "3321.75",
                    "3320.79",
                    "3329.62",
                    "3316.81",
                    "3289.29",
                    "3283.15"
                ]
            },
            {
                "name": "COMPQ",
                "date": [
                    "2020,04,09",
                    "2020,04,08",
                    "2020,04,07",
                    "2020,04,06",
                    "2020,04,03",
                    "2020,04,02",
                    "2020,04,01",
                    "2020,03,31",
                    "2020,03,30",
                    "2020,03,27",
                    "2020,03,26",
                    "2020,03,25",
                    "2020,03,24",
                    "2020,03,23",
                    "2020,03,20",
                    "2020,03,19",
                    "2020,03,18",
                    "2020,03,17",
                    "2020,03,16",
                    "2020,03,13",
                    "2020,03,12",
                    "2020,03,11",
                    "2020,03,10",
                    "2020,03,09",
                    "2020,03,06",
                    "2020,03,05",
                    "2020,03,04",
                    "2020,03,03",
                    "2020,03,02",
                    "2020,02,28",
                    "2020,02,27",
                    "2020,02,26",
                    "2020,02,25",
                    "2020,02,24",
                    "2020,02,21",
                    "2020,02,20",
                    "2020,02,19",
                    "2020,02,18",
                    "2020,02,14",
                    "2020,02,13",
                    "2020,02,12",
                    "2020,02,11",
                    "2020,02,10",
                    "2020,02,07",
                    "2020,02,06",
                    "2020,02,05",
                    "2020,02,04",
                    "2020,02,03",
                    "2020,01,31",
                    "2020,01,30",
                    "2020,01,29",
                    "2020,01,28",
                    "2020,01,27",
                    "2020,01,24",
                    "2020,01,23",
                    "2020,01,22",
                    "2020,01,21",
                    "2020,01,17",
                    "2020,01,16",
                    "2020,01,15",
                    "2020,01,14"
                ],
                "price": [
                    "8153.57",
                    "8090.9",
                    "7887.26",
                    "7913.24",
                    "7373.08",
                    "7487.31",
                    "7360.58",
                    "7700.1",
                    "7774.15",
                    "7502.38",
                    "7797.54",
                    "7384.3",
                    "7417.86",
                    "6860.67",
                    "6879.52",
                    "7150.58",
                    "6989.84",
                    "7334.78",
                    "6904.59",
                    "7874.87",
                    "7201.8",
                    "7952.05",
                    "8344.25",
                    "7950.68",
                    "8575.62",
                    "8738.59",
                    "9018.09",
                    "8684.09",
                    "8952.16",
                    "8567.37",
                    "8566.48",
                    "8980.77",
                    "8965.61",
                    "9221.28",
                    "9576.59",
                    "9750.96",
                    "9817.18",
                    "9732.74",
                    "9731.18",
                    "9711.97",
                    "9725.96",
                    "9638.94",
                    "9628.39",
                    "9520.51",
                    "9572.15",
                    "9508.68",
                    "9467.97",
                    "9273.4",
                    "9150.94",
                    "9298.93",
                    "9275.16",
                    "9269.68",
                    "9139.31",
                    "9314.91",
                    "9402.48",
                    "9383.77",
                    "9370.81",
                    "9388.95",
                    "9357.13",
                    "9258.7",
                    "9251.33"
                ]
            }
        ]';

    return $apiResponse = json_decode($apiResponse);
    /* try {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $request = $this->httpClient->get($this->ej_market_data_web_service_url . '/v1/quotes/exchanges/charts/{country}/country', [
      'headers' => [
      'Authorization' => 'Bearer ' . $auth_token,
      'Content-Type' => 'application/json',
      ],
      ]);

      return $apiResponse = json_decode($request->getBody());
      }
      catch (ClientException | RequestException | TransferException | BadResponseException $exception) {
      watchdog_exception('ej_market_data', $exception, null, [], 6);

      return json_decode((string) $exception->getResponse()->getBody());
      } */
  }

  public function getMostActiveFunds() {
    $apiResponse = '[
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "CHESAPEAKE ENER",
            "dividendPayDate": "15 APR 2020",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "-0.22",
            "expirationDate": "13 APR 2015",
            "lastClosePrice": "0.17",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "0.16",
            "lastTradeTime": "13:36 EST",
            "peRatio": "0.00",
            "percentChange": "-8.47",
            "priceChange": "-0.01",
            "stockExchange": "NYSE",
            "stockVolume": "16,526,628",
            "symbol": "CHK.N",
            "todaysHigh": "0.18",
            "todaysLow": "0.16",
            "type": "S",
            "week52High": "3.20",
            "week52Low": "0.12"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "FORD MOTOR CO",
            "dividendPayDate": "02 MAR 2020",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "0.03",
            "expirationDate": "29 JAN 2020",
            "lastClosePrice": "5.37",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "5.08",
            "lastTradeTime": "13:36 EST",
            "peRatio": "154.71",
            "percentChange": "-5.40",
            "priceChange": "-0.29",
            "stockExchange": "NYSE",
            "stockVolume": "9,921,937",
            "symbol": "F.N",
            "todaysHigh": "5.41",
            "todaysLow": "5.03",
            "type": "S",
            "week52High": "10.56",
            "week52Low": "3.97"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "CARNIVAL CORP",
            "dividendPayDate": "13 MAR 2020",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "2.70",
            "expirationDate": "20 FEB 2020",
            "lastClosePrice": "12.42",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "11.51",
            "lastTradeTime": "13:36 EST",
            "peRatio": "4.60",
            "percentChange": "-7.33",
            "priceChange": "-0.91",
            "stockExchange": "NYSE",
            "stockVolume": "9,430,624",
            "symbol": "CCL.N",
            "todaysHigh": "11.80",
            "todaysLow": "10.95",
            "type": "S",
            "week52High": "56.04",
            "week52Low": "7.80"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "DELTA AIR LIN",
            "dividendPayDate": "12 MAR 2020",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "7.32",
            "expirationDate": "19 FEB 2020",
            "lastClosePrice": "24.39",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "22.95",
            "lastTradeTime": "13:36 EST",
            "peRatio": "3.33",
            "percentChange": "-5.90",
            "priceChange": "-1.44",
            "stockExchange": "NYSE",
            "stockVolume": "8,531,555",
            "symbol": "DAL.N",
            "todaysHigh": "25.06",
            "todaysLow": "22.08",
            "type": "S",
            "week52High": "63.43",
            "week52Low": "19.11"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "GENERAL ELEC CO",
            "dividendPayDate": "27 APR 2020",
            "dividendYield": "0.04",
            "dividendYieldPercent": "0.58",
            "eps": "0.00",
            "expirationDate": "06 MAR 2020",
            "lastClosePrice": "7.14",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "6.92",
            "lastTradeTime": "13:36 EST",
            "peRatio": "16,227.27",
            "percentChange": "-3.15",
            "priceChange": "-0.22",
            "stockExchange": "NYSE",
            "stockVolume": "8,102,985",
            "symbol": "GE.N",
            "todaysHigh": "7.11",
            "todaysLow": "6.76",
            "type": "S",
            "week52High": "13.26",
            "week52Low": "5.90"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "MARATHON OIL",
            "dividendPayDate": "10 MAR 2020",
            "dividendYield": "0.2",
            "dividendYieldPercent": "4.61",
            "eps": "0.59",
            "expirationDate": "18 FEB 2020",
            "lastClosePrice": "4.12",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "4.34",
            "lastTradeTime": "13:36 EST",
            "peRatio": "6.98",
            "percentChange": "+5.22",
            "priceChange": "+0.22",
            "stockExchange": "NYSE",
            "stockVolume": "7,367,533",
            "symbol": "MRO.N",
            "todaysHigh": "4.45",
            "todaysLow": "4.16",
            "type": "S",
            "week52High": "18.93",
            "week52Low": "3.02"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "AURORA CANNABIS",
            "dividendPayDate": "",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "-1.02",
            "expirationDate": "",
            "lastClosePrice": "0.88",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "0.74",
            "lastTradeTime": "13:36 EST",
            "peRatio": "0.00",
            "percentChange": "-15.37",
            "priceChange": "-0.13",
            "stockExchange": "NYSE",
            "stockVolume": "7,227,309",
            "symbol": "ACB.N",
            "todaysHigh": "0.82",
            "todaysLow": "0.74",
            "type": "S",
            "week52High": "9.37",
            "week52Low": "0.60"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "BANK OF AMERICA",
            "dividendPayDate": "27 MAR 2020",
            "dividendYield": "0.72",
            "dividendYieldPercent": "3.00",
            "eps": "2.75",
            "expirationDate": "05 MAR 2020",
            "lastClosePrice": "24.86",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "23.97",
            "lastTradeTime": "13:36 EST",
            "peRatio": "9.04",
            "percentChange": "-3.58",
            "priceChange": "-0.89",
            "stockExchange": "NYSE",
            "stockVolume": "6,864,254",
            "symbol": "BAC.N",
            "todaysHigh": "24.85",
            "todaysLow": "23.78",
            "type": "S",
            "week52High": "35.71",
            "week52Low": "17.96"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "OCCIDENTAL PETE",
            "dividendPayDate": "15 APR 2020",
            "dividendYield": "0.44",
            "dividendYieldPercent": "2.88",
            "eps": "-0.88",
            "expirationDate": "09 MAR 2020",
            "lastClosePrice": "15.36",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "15.28",
            "lastTradeTime": "13:36 EST",
            "peRatio": "0.00",
            "percentChange": "-0.52",
            "priceChange": "-0.08",
            "stockExchange": "NYSE",
            "stockVolume": "5,778,199",
            "symbol": "OXY.N",
            "todaysHigh": "16.01",
            "todaysLow": "14.77",
            "type": "S",
            "week52High": "65.17",
            "week52Low": "9.01"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "NIO INC",
            "dividendPayDate": "",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "-1.59",
            "expirationDate": "",
            "lastClosePrice": "2.67",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "2.94",
            "lastTradeTime": "13:36 EST",
            "peRatio": "0.00",
            "percentChange": "+9.93",
            "priceChange": "+0.26",
            "stockExchange": "NYSE",
            "stockVolume": "4,944,525",
            "symbol": "NIO.N",
            "todaysHigh": "2.97",
            "todaysLow": "2.63",
            "type": "S",
            "week52High": "5.65",
            "week52Low": "1.21"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "MFA FINANCIAL",
            "dividendPayDate": "31 JAN 2020",
            "dividendYield": "0.8",
            "dividendYieldPercent": "43.36",
            "eps": "0.80",
            "expirationDate": "27 DEC 2019",
            "lastClosePrice": "1.98",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "1.85",
            "lastTradeTime": "13:35 EST",
            "peRatio": "2.48",
            "percentChange": "-6.82",
            "priceChange": "-0.14",
            "stockExchange": "NYSE",
            "stockVolume": "4,826,247",
            "symbol": "MFA.N",
            "todaysHigh": "2.09",
            "todaysLow": "1.74",
            "type": "S",
            "week52High": "8.08",
            "week52Low": "0.32"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "NORWGN CRUS LINE",
            "dividendPayDate": "",
            "dividendYield": "",
            "dividendYieldPercent": "0.00",
            "eps": "4.30",
            "expirationDate": "",
            "lastClosePrice": "13.11",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "11.40",
            "lastTradeTime": "13:36 EST",
            "peRatio": "3.05",
            "percentChange": "-13.04",
            "priceChange": "-1.71",
            "stockExchange": "NYSE",
            "stockVolume": "4,394,260",
            "symbol": "NCLH.N",
            "todaysHigh": "12.02",
            "todaysLow": "11.00",
            "type": "S",
            "week52High": "59.78",
            "week52Low": "7.03"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "PETROLEO BRASIL",
            "dividendPayDate": "18 FEB 2020",
            "dividendYield": "0.2681",
            "dividendYieldPercent": "4.05",
            "eps": "1.14",
            "expirationDate": "12 NOV 2019",
            "lastClosePrice": "6.72",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "6.62",
            "lastTradeTime": "13:36 EST",
            "peRatio": "5.87",
            "percentChange": "-1.49",
            "priceChange": "-0.10",
            "stockExchange": "NYSE",
            "stockVolume": "4,231,635",
            "symbol": "PBR.N",
            "todaysHigh": "6.73",
            "todaysLow": "6.45",
            "type": "S",
            "week52High": "16.94",
            "week52Low": "4.01"
        },
        {
            "closeDate": "09 APR 2020",
            "currency": "USA",
            "description": "BARRICK GOLD CRP",
            "dividendPayDate": "16 MAR 2020",
            "dividendYield": "0.28",
            "dividendYieldPercent": "1.15",
            "eps": "2.25",
            "expirationDate": "27 FEB 2020",
            "lastClosePrice": "22.51",
            "lastTradeDate": "13 APR 2020",
            "lastTradePrice": "24.37",
            "lastTradeTime": "13:36 EST",
            "peRatio": "10.00",
            "percentChange": "+8.26",
            "priceChange": "+1.86",
            "stockExchange": "NYSE",
            "stockVolume": "4,001,609",
            "symbol": "GOLD.N",
            "todaysHigh": "24.76",
            "todaysLow": "22.25",
            "type": "S",
            "week52High": "22.56",
            "week52Low": "11.66"
        }
      ]';

    return $apiResponse = json_decode($apiResponse);
    /* try {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $request = $this->httpClient->get($this->ej_market_data_web_service_url . '/v1/quotes/exchanges/{country}/country', [
      'headers' => [
      'Authorization' => 'Bearer ' . $auth_token,
      'Content-Type' => 'application/json',
      ],
      ]);

      return $apiResponse = json_decode($request->getBody());
      }
      catch (ClientException | RequestException | TransferException | BadResponseException $exception) {
      watchdog_exception('ej_market_data', $exception, null, [], 6);

      return json_decode((string) $exception->getResponse()->getBody());
      } */
  }

  /**
   * @param string $inputItems
   *
   * @return array
   */
  private function convertDataToAutoFillFormat($inputItems, $input) {
    $response = [];

    if ($inputItems) {
      foreach ($inputItems as $item) {
        $displayText = $item->symbolDescription;

        preg_match_all("/$input+/i", $displayText, $matches);
        if (is_array($matches[0]) && count($matches[0]) >= 1) {
          foreach ($matches[0] as $match) {
            $displayText = str_replace($match, '<strong>' . $match . '</strong>', $displayText);
          }
        }

        $response[] = [
          'value' => $item->symbol.'-'.$item->symbolDescription,
          'label' => $displayText,
        ];
      }
    }

    return $response;
  }

}
