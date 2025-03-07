<?php

declare(strict_types=1);

namespace Drupal\anytown;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;


class ForecastClient implements ForecastClientInterface {

  protected $httpClient;
  protected $logger;

  public function __construct(ClientInterface $httpClient, LoggerChannelFactoryInterface $logger_factory) {
    $this->httpClient = $httpClient;
    $this->logger = $logger_factory->get('anytown');
  }

  public function getForecast(string $url): ?array {
    try {
      $response = $this->httpClient->request('GET', $url);
      $data = json_decode($response->getBody()->getContents(), TRUE);
    } catch (GuzzleException $e) {
      $this->logger->error('Failed to fetch weather data: @message', ['@message' => $e->getMessage()]);
      $data = [];
    }

    $forecast = [];

    foreach ($data['list'] as $day) {
      $forecast[$day['day']] = [
        'weekday' => ucfirst($day['day']),
        'description' => $day['weather'][0]['description'],
        'high' => $this->kelvinToFahrenheit($day['main']['temp_max']),
        'low' => $this->kelvinToFahrenheit($day['main']['temp_min']),
        'icon' => $day['weather'][0]['icon'],
      ];
    }

    return $forecast;
  }

  public function kelvinToFahrenheit(float $kelvin): float {
    // Convert units in Kelvin to Fahrenheit.
    return round(($kelvin - 273.15) * 9 / 5 + 32);
  }
}
