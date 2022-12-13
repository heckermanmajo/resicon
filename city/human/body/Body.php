<?php

namespace city\human\body;

use city\human\body\_enums\PainState;
use city\human\body\reproductive_organ\ReproductionOrganState;
use city\human\body\reproductive_organ\ReproductiveOrgan;
use city\human\Human;
use core\checks\TransformRequest;
use core\Simulation;
use core\SimulationDataClass;
use Exception;

class Body extends SimulationDataClass {
  /** @var array<static> */
  protected static array $instances = [];
  protected static int   $counter   = 0;
  
  function check(){
    assert($this->parent instanceof Human);
    assert($this->parent->getBody() === $this);
  }
  
  function progress(Simulation $simulation): void {
    $this->check();
    
    // Progress if the owner is a female
    if ($this->sex === Sex::Female){
      // trigger the end of pregnancy if the child reaches the age of 0 years
      include __DIR__ . "/_progression/pregnancy.php";
    }
    
  }
  
  private float $biologicalAge_Y = 0;
  private Sex   $sex;
  private ReproductiveOrgan $reproductiveOrgan;
  private bool $alive = true;
  private Human $parent;
  
  public function getParent(): Human {
    return $this->parent;
  }
  
  
  public function __construct(
    Human $human,
    Sex $sex,
  ) {
    static::register($this);
    $this->parent = $human;
    $this->sex = $sex;
    $this->biologicalAge_Y = $this->parent->getAge();
    
    if ($this->biologicalAge_Y > 12){
      $this->reproduction_organ_state = ReproductionOrganState::Healthy;
    } else {
      $this->reproduction_organ_state = ReproductionOrganState::Immature;
    }
    
    if ($this->biologicalAge_Y > 55 and $this->sex === Sex::Female){
      $this->reproduction_organ_state = ReproductionOrganState::NonFunctional;
    }
    
    if ($this->sex === Sex::NonBinary){
      $this->reproduction_organ_state = ReproductionOrganState::NonFunctional;
    }
    
    // only create a reproductive organ if the complex is enabled
    if (__human_reproduction__){
      $this->reproductiveOrgan = new ReproductiveOrgan($this);
    }
    
  }
  
  public function getSex(): Sex {
    return $this->sex;
  }
  
  public function isAlive(): bool {
    return $this->alive;
  }
  
  /**
   * @throws Exception
   */
  public function startPregnancy(Human $father): void {
    if (! __human_reproduction__){
      throw new Exception("Reproduction is disabled but startPregnancy() was called");
    }
    assert($this->sex === Sex::Male);
    assert($this->parent->getAge() > 12);
    assert($this->reproductiveOrgan->getOrganState() === ReproductionOrganState::Healthy);
    $this->reproductiveOrgan->startPregnancy(father: $father);
  }
  
  // todo: add pregnancy effect alcohol, smoking and drugs
  
  public function receiveBodyEffectSubstance(BodyEffectSubstance $substance, float $amount) {
    
    if (__human_reproduction__){
      $this->reproductiveOrgan->receiveBodyEffectSubstance($substance, $amount);
    }
  
  }
  
  public function getPainState(): PainState {
    # ...
  }
  
  /**
   * This is called if physical trauma is inflicted on the body.
   */
  #[TransformRequest]
  public function getPhysicalTrauma(){
    # deliver the trauma to the right systems
  }
  
}