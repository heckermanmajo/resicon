<?php

/**
 * Pregnancy.
 * If the Child reached the age of 0 years, it is born.
 *
 * @var $this city\human\body\reproductive_organ\ReproductiveOrgan
 * @var $simulation core\Simulation
 */

if ($this->pregnantWith !== null) {
    if ($this->pregnantWith->getAge() >= 0){
      $this->endPregnancy();
    }
}