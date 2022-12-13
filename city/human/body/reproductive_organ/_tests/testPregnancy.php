<?php

// init a test simulation

use city\human\body\Body;
use city\human\connection\Connection;
use city\human\Human;
use core\Utils;

$simulation = new \core\Simulation(
  endStep:  100,
  stepSize: 1,
);

$p = new \city\place\Place();
new Human(age: 12, place: $p);

$human = Human::getInstanceById(1);

// todo: more stuff for the test

unset($simulation);
Connection::freeAllInstances();
Body::freeAllInstances();
Human::freeAllInstances();

// echo in green
Utils::echoGreen(
  "  TEST: Test the pregnancy of a human (" . __FILE__ . "): SUCCESSFUL \n"
);

// free all instances

