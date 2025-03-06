<?php

  declare(strict_types=1);

  namespace Drupal\anytown\Plugin\Block;

  use Drupal\Core\Block\Attribute\Block;
  use Drupal\Core\Block\BlockBase;
  use Drupal\Core\StringTranslation\TranslatableMarkup;

  /**
   * Provide hello world Block
   */
  #[Block(
    id: 'anytown_hello_world',
    admin_label: new TranslatableMarkup(string: 'Hello World'),
    category: new TranslatableMarkup(string: 'Custom')
  )]
  class HelloWorldBlock extends BlockBase {

    public function build(){
      $build['content'] = [
        "#markup" => $this->t('Hello, world !'),
      ];

      return $build;
    }
  }
