<?php

declare(strict_types=1);

namespace Drupal\anytown;


interface ForecastClientInterface {

  public function getForecast(string $url): ?array;

  public function kelvinToFahrenheit(float $kelvin): float;
}
