<?php

namespace core;

use Exception;

abstract class SimulationDataClass {
  /** @var array<static> */
  protected static array $instances = [];
  protected static int $counter = 0;
  private static array $files = [];
  
  /**
   * @var array<string>
   */
  public static array $tests = [];
  
  readonly int $id;
  protected bool $___deleted = false;
  
  public static function register(SimulationDataClass $instance): void {
    static::$counter++;
    static::$instances[static::$counter] = $instance;
    $instance->id = static::$counter;
    //echo "Constructing " . get_class($instance) . " with id " . static::$counter . PHP_EOL;
  }
  
  public static function progressAllInstances(Simulation $simulation): void {
    foreach(static::$instances as $instance){
      $instance->progress($simulation);
    }
  }
  
  public function __tostring(): string {
    return "" . get_class($this) . " with id " . $this->id . PHP_EOL;
  }
  
  abstract function progress(Simulation $simulation): void;
  
  public static function freeAllInstances(): void {
    //print "Freeing all instances of " . static::class . PHP_EOL;
    foreach(static::$instances as $instance){
      unset($instance);
    }
    static::$instances = [];
    static::$counter = 0;
  }
  
  /**
   * This function can be used to check the state of an object
   * during a test case.
   *
   * @param array $expectedValues
   * @return void
   * @throws Exception
   */
  public function expect(array $expectedValues): void {
    foreach($expectedValues as $key => $value){
      if ($this->$key !== $value){
        throw new Exception("Expected " . $key . " to be " . $value . " but it is " . $this->$key);
      }
    }
  }
  
  public static function getInstanceById(int $id): static {
    return static::$instances[$id];
  }
  
  public static function runAllTests(): void {
    echo "Running all tests for " . static::class . PHP_EOL;
    // get path from class name space
    $path = str_replace("\\", "/", static::class);
    // remove the classname
    $path = substr($path, 0, strrpos($path, "/"));
    $testDir = __DIR__ . "/../" . $path . "/_tests";
    // loop through all files in testdir and include them
    $files = scandir($testDir);
    foreach($files as $file){
      if (str_ends_with($file, ".php")){
        include $testDir . "/" . $file;
      }
    }
  }
  
  /**
   * Write Message into logfile.
   *
   * @param string $message
   * @param int $currentStep
   * @return void
   */
  public function log(string $message, int $currentStep = -1): void {
    $className = static::class;
    $className = str_replace("\\", "_", $className);
    if (!isset(static::$files[$className])){
      static::$files[$className] = fopen(__DIR__ . "/../logs/" .$className . ".log", "w");
    }
    $message = $this->id . " at $currentStep: " . $message;
    fwrite(static::$files[$className], $message . PHP_EOL);
  }
  

}