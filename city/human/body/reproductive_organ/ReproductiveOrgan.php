<?php

namespace city\human\body\reproductive_organ;

use city\human\body\Body;
use city\human\body\BodyEffectSubstance;
use city\human\body\Sex;
use city\human\Human;
use core\checks\TransformRequest;
use core\ReadRequest;
use core\Simulation;
use core\SimulationDataClass;

class ReproductiveOrgan extends SimulationDataClass {
  
  /** @var array<static> */
  protected static array $instances = [];
  protected static int   $counter   = 0;
  
  const AlkoholDamageModifier = 0.5;
  
  private ?Human                 $pregnantWith = null;
  private Body                   $parent;
  private ReproductionOrganState $state        = ReproductionOrganState::Healthy;
  private float $damage = 0;
  // todo: add modifiers for the pregnancy health modifiers
  
  public function __construct(
    Body $parent
  ) {
    static::register($this);
    $this->parent = $parent;
  }
  
  function progress(Simulation $simulation): void {
    include __DIR__ . "/_progression/pregnancy.php";
  }
  
  private function endPregnancy(): void {
    assert($this->pregnantWith !== null);
    $baby = $this->pregnantWith;
    $this->pregnantWith = null;
    $baby->setPlace($this->parent->getParent()->getPlace());
  }
  
  #[ReadRequest]
  public function canStartPregnancy(): bool {
    if (
      $this->pregnantWith === null
      and $this->state !== ReproductionOrganState::NonFunctional
          and $this->parent->getSex() === Sex::Female
    ) {
      return true;
    } else {
      return false;
    }
  }
  
  #[TransformRequest]
  public function startPregnancy(Human $father): void {
    assert($this->canStartPregnancy());
    // todo: add the health of the reproductive organ of the father
    
    // create baby
    $baby = new Human(
      age:    -0.75,
      place:  null,
      father: $father,
      mother: $this->parent->getParent()
    );
    // baby is created, now add baby to mother
    $this->pregnantWith = $baby;
  }
  
  #[ReadRequest]
  public function isPregnant(): bool {
    return $this->pregnantWith !== null;
  }
  
  #[TransformRequest]
  public function setOrganState(ReproductionOrganState $state) {
    $this->state = $state;
    // if pregnancy is started, but the organ is not healthy apply changes
  }
  
  #[ReadRequest]
  public function getOrganState(): ReproductionOrganState {
    return $this->state;
  }
  
  #[TransformRequest]
  public function receiveBodyEffectSubstance(
    BodyEffectSubstance $substance,
    float $amount
  ): void {
    switch ($substance){
      case BodyEffectSubstance::Alcohol:
        if ($this->isPregnant()){
          echo "You increase the chance of a disabled child\n";
        }
        $this->damage += $amount * self::AlkoholDamageModifier;
        break;
      // todo
    }
  }
  
}