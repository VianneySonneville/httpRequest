<?php
namespace HttpRequest\OAuth;

interface StrategyInterface {
  public function refreshToken(): void;
  public function getHeaders(): array;
}