<?php

namespace city\human\body\reproductive_organ;

enum ReproductionOrganState {
  case Immature;
  case Healthy;
  case Compromised;
  case Infected;
  case Injured;
  case NonFunctional;
  case Missing;
}
