<?php

namespace core;

class Simulation {
  
  readonly public int $endStep;
  readonly public int $stepSize;
  private int         $currentStep = 0;
  public array        $classes     = [];
  
  public function __construct(
    int $endStep,
    int $stepSize,
  ) {
    $this->endStep = $endStep;
    $this->stepSize = $stepSize;
  }
  
  public function getCurrentStep(): int { return $this->currentStep; }
  
  public function registerClass(string $class): void {
    $this->classes[] = $class;
  }
  
  public function iterate(): void {
    $this->currentStep += $this->stepSize;
    if ($this->currentStep > $this->endStep) {
      $this->currentStep = $this->endStep;
    }
    foreach ($this->classes as $class) {
      $class::progressAllInstances($this);
    }
  }
  
}