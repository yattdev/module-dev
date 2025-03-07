<?php

declare(strict_types=1);

namespace Drupal\anytown\Controller;

use Drupal\anytown\ForecastClientInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\AutowireTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;

class WeatherPage extends ControllerBase {

  use AutowireTrait;
  use StringTranslationTrait;

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
    $rows = [];
    if ($forecast_data) {
      // Create a table of the weather forecast as a render array. First loop
      // over the forecast data and create rows for the table.
      foreach ($forecast_data as $item) {
        [
          'weekday' => $weekday,
          'description' => $description,
          'high' => $high,
          'low' => $low,
          'icon' => $icon,
        ] = $item;

        $rows[] = [
          // Simple text for a cell can be added directly to the array.
          $weekday,
          // Complex data for a cell, like HTML, can be represented as a nested
          // render array.
          [
            'data' => [
              '#markup' => $this->t('<img alt="@description" src="@icon" width="200" height="200" />', [
                '@description' => $description,
                '@icon' => $icon,
              ]),
            ],
          ],
          [
            'data' => [
              '#markup' => $this->t('<em>@description</em> with a high of @high and a low of @low', [
                '@description' => $description,
                '@high' => $high,
                '@low' => $low,
              ]),
            ],
          ],
        ];

        // Initialize the highest and lowest temperatures.
        if (!isset($highest)) {
          $highest = $high;
          $lowest = $low;
        }
        // Get hihgest and lowest temperature
        $highest = max($high, $highest);
        $lowest = min($low, $lowest);
      }

      $weather_forecast = [
        '#type' => 'table',
        '#header' => [
          $this->t('Day'),
          '',
          $this->t('Forecast'),
        ],
        '#rows' => $rows,
        '#attributes' => [
          'class' => ['weather_page--forecast-table'],
        ],
      ];

      // Summary forecast.
      $short_forecast = [
        '#type' => 'markup',
        '#markup' => $this->t("The high for the weekend is {$highest} and the low is {$lowest}."),
      ];

    }
    else {
      // Or, display a message if we can't get the current forecast.
      $weather_forecast = ['#markup' => $this->t('<p>Could not get the weather forecast. Dress for anything.</p>')];
      $short_forecast = NULL;
    }

    $build = [
      '#theme' => 'weather_page',
      '#attached' => [
        'library' => [
          'anytown/forecast',
        ],
      ],
      '#weather_intro' => [
        '#markup' => $this->t("<p>Check out this weekend's weather forecast and come prepared. The market is mostly outside, and takes place rain or shine.</p>"),
      ],
      '#short_forecast' => $short_forecast,
      '#weather_forecast' => $weather_forecast,
      '#weather_closures' => [
        '#theme' => 'item_list',
        '#title' => $this->t('Weather related closures'),
        '#items' => [
          $this->t('Ice rink closed until winter - please stay off while we prepare it.'),
          $this->t('Parking behind Apple Lane is still closed from all the rain last weekend.'),
        ],
      ],
    ];
    // dd($build);

    return $build;
  }
}
