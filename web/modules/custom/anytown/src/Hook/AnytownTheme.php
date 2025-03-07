<?php

declare(strict_types=1);

namespace Drupal\anytown\Hook;

use Drupal\Core\Hook\Attribute\Hook;

class AnytownTheme {

  #[Hook('theme')]
  public function theme(): array {
    return [
      'weather_page' => [
        'variables' => [
          'weather_intro' => '',
          'weather_forecast' => '',
          'short_forecast' => '',
          'weather_closures' => '',
        ],
      ],
    ];
  }
}
