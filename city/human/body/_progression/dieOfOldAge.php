<?php

/**
 * DieOfOldAge.
 * If the Human reached the age of 60 years, he dies with a probability of 0.1%.
 *
 * @var $this city\human\body\Body
 * @var $simulation core\Simulation
 */

if ($this->biologicalAge_Y >= 60) {
  // todo: make more realistic
  //       apply the health of various organs/body-systems
  $random = rand(0,1_000_000);
  if ($random < 10) {
    $this->alive = false;
  }
}