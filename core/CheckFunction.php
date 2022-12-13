<?php

namespace core;

use Attribute;

#[Attribute]
class CheckFunction {
  public function __construct(
    public string $field_name,
  ){}
  
}