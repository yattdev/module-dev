<?php

declare(strict_types=1);

namespace Drupal\anytown\Controller;

use Drupal\anytown\ForecastClientInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\AutowireTrait;

class WeatherPage extends ControllerBase {

  use AutowireTrait;

  protected $forecastClient;

  # Constructor
  public function __construct(ForecastClientInterface $forecastClientInterface) {
    $this->forecastClient = $forecastClientInterface;
  }

  public function build($style): array {

    # Check if the style is short or extended
    $style = in_array($style, ['short', 'extended']) ? $style : 'short';

    $url = 'https://raw.githubusercontent.com/DrupalizeMe/module-developer-guide-demo-site/main/backups/weather_forecast.json';

    $forecast_data = $this->forecastClient->getForecast($url);
    if ($forecast_data) {
      $forecast = '<ul>';
      foreach ($forecast_data as $item) {
        [
          'weekday' => $weekday,
          'description' => $description,
          'high' => $high,
          'low' => $low,
        ] = $item;
        $forecast .= "<li>$weekday will be <em>$description</em> with a high of $high and a low of $low.</li>";
      }
      $forecast .= '</ul>';
    }
    else {
      $forecast = '<p>Could not get the weather forecast. Dress for anything.</p>';
    }

    $output = "<p>Check out this weekend's weather forecast and come prepared. The market is mostly outside, and takes place rain or shine.</p>";
    $output .= $forecast;
    $output .= '<h3>Weather related closures</h3></h3><ul><li>Ice rink closed until winter - please stay off while we prepare it.</li><li>Parking behind Apple Lane is still closed from all the rain last week.</li></ul>';

    return [
      '#markup' => $output,
    ];
  }
}
