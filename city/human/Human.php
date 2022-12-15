<?php

namespace city\human;

use city\human\body\Body;
use city\human\body\Sex;
use city\place\Place;
use Closure;
use core\CheckFunction;
use core\FieldMetadata;
use core\Simulation;
use core\SimulationDataClass;

# todo: add capital and ownership
# todo: add the generation of the human: boomer, x, y, z, alpha, beta, gamma, delta, epsilon, zeta, eta, theta, iota, kappa, lambda, mu, nu, xi, omicron, pi, rho, sigma, tau, upsilon, phi, chi, psi, omega
class Human extends SimulationDataClass {
  /** @var array[static] */
  protected static array $instances = [];
  protected static int $counter = 0;
  
  #[CheckFunction("age_Y")]
  public static function checkFunctionAge(): Closure {
    return function (
      $value
    ) {
    };
  }
  
  #[FieldMetadata(
    "Age",
    "The number of years this person is alive.",
    "Age",
  )]
  private float $age_Y = 0;
  private bool $dead = false;
  private Place $place;
  private ?Human $father;
  private ?Human $mother;
  private Body $body;
  
  public function getAge(): float { return $this->age_Y; }
  
  public function __construct(
    float $age = 0,
    Place $place = null,
    Human $father = null,
    Human $mother = null,
    Sex   $sex = Sex::Female,
  ) {
    static::register($this);
    $this->log("new Human");
    $this->age_Y = $age;
    if ($place === null) {
      // it is okay to have no place if you are not born yet
      assert(
        $age < 0,
        "Place is null, but age is not negative:"
        . "Only unborn humans can have no place"
      );
    }
    if ($father === null) {
      assert(
        $this->age_Y > 0,
        "Father is null, but age is not positive"
        . " Unborn humans need a father"
      );
    }
    if ($mother === null) {
      assert(
        $this->age_Y > 0,
        "Mother is null, but age is not positive"
        . " Unborn humans need a mother"
      );
    }
    
    $this->place = $place;
    $this->father = $father;
    $this->mother = $mother;
    $this->body = new Body($this, $sex);
  }
  
  public function humanDied(): void {
    $this->dead = true;
  }
  
  public function getBody(): Body {
    return $this->body;
  }
  
  public function getPlace(): Place {
    return $this->place;
  }
  
  public function setPlace(Place $place): void {
    $this->place = $place;
  }
  
  public function progress(Simulation $simulation): void {
    include "city/human/_progression/Age.php";
  }
}
