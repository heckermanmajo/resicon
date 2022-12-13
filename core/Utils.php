<?php

namespace core;

class Utils {
  public static function echoGreen(string $text): void {
    echo "\033[0;32m" . $text . "\033[0m";
  }
}