<?php

namespace core\checks;

use Attribute;

/**
 * This attribute adds a runtime-check each iteration
 * that this object is not deleted.
 * It is the more easy method thea place
 * assert($field->isNotDeleted()) in each method
 * and strategy.
 */
#[Attribute]
class IsAlwaysValid{

}