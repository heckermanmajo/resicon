<?php

namespace city\human\mind;

use core\Simulation;
use core\SimulationDataClass;

# todo: memes
# todo: Perception of desire of other humans

class Mind  extends SimulationDataClass {
  /** @var array<static> */
  protected static array $instances = [];
  protected static int   $counter   = 0;
  
  
  function progress(Simulation $simulation): void {
    // TODO: Implement progress() method.
  }
}