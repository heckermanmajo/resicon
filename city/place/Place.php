<?php

namespace city\place;

use core\Simulation;

class Place extends \core\SimulationDataClass {
  /** @var array[static] */
  protected static array $instances = [];
  protected static int   $counter   = 0;
  
  function progress(Simulation $simulation): void {
    // TODO: Implement progress() method.
  }
}