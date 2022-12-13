<?php

declare(strict_types=1);

namespace city\human\connection;

use city\human\connection\_enums\ConnectionType;
use city\human\Human;
use city\human\HumanLiveLossEventType;
use core\checks\DictOf;
use core\checks\IsAlwaysValid;
use core\checks\ListOf;
use core\checks\ReadRequest;
use core\checks\TransformRequest;
use core\Simulation;
use core\SimulationDataClass;

class Connection extends SimulationDataClass {
  
  /** @var array<static> */
  #[DictOf(
    keyType: "int",
    valueType: Connection::class
  )]
  protected static array $instances = [];
  protected static int   $counter   = 0;
  
  /** @type array<int, array<Connection>> */
  #[DictOf(
    keyType: "int",
    valueType: new ListOf(Connection::class)
  )]
  static array  $connectionsMappedOnHuman = [];
  #[IsAlwaysValid]
  private Human $human1;
  #[IsAlwaysValid]
  private Human $human2;
  
  private ConnectionType $type;
  
  public function __construct(
    Human          $human1,
    Human          $human2,
    ConnectionType $type
  ) {
    static::register($this);
    $this->human1 = $human1;
    $this->human2 = $human2;
    $this->type = $type;
    static::$connectionsMappedOnHuman[$human1->id][] = $this;
    static::$connectionsMappedOnHuman[$human2->id][] = $this;
  }
  
  #[ReadRequest]
  public function hasConnectionWith(
    Human $h1,
    Human $h2
  ): Connection|false {
    foreach (static::$connectionsMappedOnHuman[$h1->id] as $connection) {
      if ($connection->human2->id === $h2->id) {
        return $connection;
      }
    }
    return false;
  }
  
  #[ReadRequest]
  public function getConnectionType(): ConnectionType {
    return $this->type;
  }
  
  public function __destruct() {
    unset(static::$connectionsMappedOnHuman[$this->human1->id]);
    unset(static::$connectionsMappedOnHuman[$this->human2->id]);
  }
  
  #[TransformRequest]
  public static function deleteAllConnectionsOfGivenHuman(
    Human                  $human,
    HumanLiveLossEventType $type
  ) {
    foreach (static::$connectionsMappedOnHuman[$human->id] as $connection) {
      unset(static::$connectionsMappedOnHuman[$connection->human1->id]);
      unset(static::$connectionsMappedOnHuman[$connection->human2->id]);
      unset(static::$instances[$connection->id]);
    }
  }
  
  public function progress(Simulation $simulation): void {
    print "Progressing " . $this . PHP_EOL;
    include "city/human/connection/_progression/DegradeOverTime.php";
  }
}