<?php

/**
 * @var $this city\human\Human
 * @var $simulation core\Simulation
 */

$this->age_Y += $simulation->stepSize / (365.25 * 60 * 24);
print "Human age is " . $this->age_Y . PHP_EOL;
