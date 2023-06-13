<?php

namespace Drupal\mbgna_resource;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a resource entity type.
 */
interface ResourceInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
