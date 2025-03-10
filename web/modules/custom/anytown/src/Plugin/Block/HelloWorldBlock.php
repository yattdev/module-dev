<?php

declare(strict_types=1);

namespace Drupal\anytown\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide hello world Block
 */
#[Block(
    id: 'anytown_hello_world',
    admin_label: new TranslatableMarkup(string: 'Hello World'),
    category: new TranslatableMarkup(string: 'Custom')
)]
class HelloWorldBlock extends BlockBase implements ContainerFactoryPluginInterface
{
  private $currentUser;

  /**
   * Constructor
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountProxyInterface $currentUser)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $currentUser;
  }

  /**
   * Current user service
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(){
    if ($this->currentUser->isAuthenticated()) {
      $build['content'] = [
        '#markup' => $this->t('Hello, @name !', ['@name' => $this->currentUser->getDisplayName()]),
      ];
    } else {
      $build['content'] = [
        '#markup' => $this->t('Hello, world !'),
      ];
    }

    // This block contains content that is different depending on the user so
    // we don't want it to get cached.
    $build['content']['#cache'] = [
      'max-age' => 0,
    ];

    return $build;
  }
}
