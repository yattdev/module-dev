<?php

declare(strict_types=1);

namespace Drupal\anytown;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;

interface ForecastClientInterface {

  public function __construct(ClientInterface $httpClient, LoggerChannelFactoryInterface $loggerFactory);

  public function getForecast(string $url): ?array;

  public function kelvinToFahrenheit(float $kelvin): float;
}
