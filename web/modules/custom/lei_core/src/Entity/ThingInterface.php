<?php

namespace Drupal\lei_core\Entity;

use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Provides an interface for defining Thing entities.
 */
interface ThingInterface extends ContentEntityInterface
{
  /**
   * @return string
   */
  public function getName();

  /**
   * @return float
   */
  public function getRating();
}
