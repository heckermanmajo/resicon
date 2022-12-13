<?php

namespace core;

use Attribute;

#[Attribute]
class FieldMetadata {
  public function __construct(
    string $name,
    string $short,
    string $description,
  ){}
}