<?php

use city\human\body\Body;
use city\human\body\reproductive_organ\ReproductiveOrgan;
use city\human\body\Sex;
use city\human\connection\_enums\ConnectionType;
use city\human\connection\Connection;
use city\human\Human;
use city\human\mind\Mind;
use core\Simulation;

const __debug__ = true;

/*
 * You can enable and disable complexes that you don't need.
 *
 * If your disable-settings can compromise the logic of the simulation,
 * a warning will be displayed.
 */
const __human_reproduction__ = true;


spl_autoload_register(function ($class_name) {
  // use namespaces to get the path of the file
  $path = str_replace('\\', '/', $class_name);
  include "$path.php";
});

Human::runAllTests();
Connection::runAllTests();
Mind::runAllTests();
Body::runAllTests();
ReproductiveOrgan::runAllTests();

// load all classes

$place = new city\place\Place();

$human = new Human(
  age:   30,
  place: $place,
  sex:   Sex::Male
);
$human2 = new Human(
  age:   30,
  place: $place,
  sex:   Sex::Female
);
$conn = new Connection($human, $human2, ConnectionType::FRIENDSHIP);


$sim = new Simulation(
  endStep:  100,
  stepSize: 1,
);

$sim->registerClass(Human::class);
$sim->registerClass(Connection::class);


$sim->iterate();