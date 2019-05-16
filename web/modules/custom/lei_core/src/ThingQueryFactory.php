<?php

namespace Drupal\lei_core;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Query\QueryFactoryInterface;

class ThingQueryFactory implements QueryFactoryInterface
{
  /**
   * The namespace of this class, the parent class etc.
   *
   * @var array
   */
  protected $namespaces;

  /** @var ConfigFactoryInterface $configFactory */
  protected $configFactory;

  /**
   * Constructs a QueryFactory object.
   *
   * @param ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->namespaces = ThingQuery::getNamespaces($this);

    $this->configFactory = $config_factory;
  }

  /**
   * Instantiates an aggregation query object for a given entity type.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param string $conjunction
   *   - AND: all of the conditions on the query need to match.
   *   - OR: at least one of the conditions on the query need to match.
   *
   * @return \Drupal\Core\Entity\Query\QueryAggregateInterface
   *   The query object that can query the given entity type.
   *
   * @throws \Drupal\Core\Entity\Query\QueryException
   */
  public function getAggregate(EntityTypeInterface $entity_type, $conjunction)
  {
    // TODO: Implement getAggregate() method.
  }

  /**
   * Instantiates an entity query for a given entity type.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param string $conjunction
   *   The operator to use to combine conditions: 'AND' or 'OR'.
   *
   * @return \Drupal\Core\Entity\Query\QueryInterface
   *   An entity query for a specific configuration entity type.
   */
  public function get(EntityTypeInterface $entity_type, $conjunction)
  {
    return new ThingQuery($entity_type, $conjunction, $this->namespaces, $this->configFactory->get('thing.settings'));
  }
}
