<?php

namespace Drupal\lei_core;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\lei_core\Entity\ThingInterface;

/**
 * Defines a class to build a listing of Things.
 *
 * @ingroup lei_core
 */
class ThingListBuilder extends EntityListBuilder
{
  /**
   * {@inheritdoc}
   */
  public function buildHeader()
  {
    $header['name'] = $this->t('Name');
    $header['rating'] = $this->t('Rating');

    return $header;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {
    /** @var ThingInterface $entity */
    $row['name'] = $entity->toLink($entity->label());
    $row['rating'] = $entity->getRating();

    return $row;
  }
}
