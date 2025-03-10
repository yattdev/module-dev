<?php

//
// declare(strict_types=1);
//
// namespace Drupal\anytown\Hook;
//
// use Drupal\Core\Hook\Attribute\Hook;
// use Drupal\Core\Routing\RouteMatchInterface;
// use Drupal\Core\Session\AccountProxyInterface;
// use Drupal\Core\StringTranslation\StringTranslationTrait;
//
// class AnytownHelp
// {
// use StringTranslationTrait;
//
// private $currentUser;
//
// public function __construct(AccountProxyInterface $currentUser)
// {
// $this->currentUser = $currentUser;
// }
//
// *
// Implements help().
//
// Displays help and module information.
//
// @param  string  $route_name
// The current route name.
// @param  \Drupal\Core\Routing\RouteMatchInterface  $route_match
// The current route match.
// #[Hook('help')]
// public function help($route_name, RouteMatchInterface $route_match)
// {
// if ($route_name === 'help.page.anytown') {
// $name = $this->currentUser->getDisplayName();
//
// return '<p>'.$this->t('Hello @name, Help for anytown module',
// ['@name' => $name]).'</p>';
// }
// }
// }
//
