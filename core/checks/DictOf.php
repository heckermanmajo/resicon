<?php

namespace core\checks;

use Attribute;

#[Attribute]
class DictOf {
  public function __construct(
    public string|ListOf|DictOf $keyType,
    public string|ListOf|DictOf $valueType
  ) {}
}