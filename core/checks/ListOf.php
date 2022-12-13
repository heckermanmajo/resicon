<?php

namespace core\checks;

use Attribute;

#[Attribute]
class ListOf {
  public function __construct(
    public string|ListOf|DictOf $type
  ) {}
}