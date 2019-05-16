<?php

namespace Drupal\lei_core;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Provides routes for entities.
 *
 * @see \Drupal\Core\Entity\Routing\AdminHtmlRouteProvider
 * @see \Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider
 */
class ThingHtmlRouteProvider extends DefaultHtmlRouteProvider
{

  /**
   * {@inheritdoc}
   */
  public function getRoutes(EntityTypeInterface $entity_type)
  {
    $collection = new RouteCollection();

    if ($canonical_route = $this->getCanonicalRoute($entity_type)) {
      $collection->add("entity.thing.canonical", $canonical_route);
    }

    if ($collection_route = $this->getCollectionRoute($entity_type)) {
      $collection->add('entity.thing.collection', $collection_route);
    }

    if ($settings_form_route = $this->getSettingsFormRoute($entity_type)) {
      $collection->add('thing.settings', $settings_form_route);
    }

    if ($edit_form_route = $this->getEditFormRoute($entity_type)) {
      $collection->add("entity.thing.edit_form", $edit_form_route);
    }

    return $collection;
  }

  /**
   * Gets the settings form route.
   *
   * @param EntityTypeInterface $entity_type
   *   The entity type.
   *
   * @return Route|null
   *   The generated route, if available.
   */
  protected function getSettingsFormRoute(EntityTypeInterface $entity_type)
  {
    $entity_type_id = $entity_type->id();
    $route = new Route("/admin/structure/thing/settings");

    $route
      ->setDefaults([
        '_form' => '\Drupal\lei_core\Form\ThingSettingsForm',
        '_title' => "Thing settings",
        'entity_type_id' => 'thing'
      ])
      ->setRequirement('_permission', $entity_type->getAdminPermission())
      ->setOption('_admin_route', TRUE)
      ->setOption('parameters', [
        $entity_type_id => [
          'type' => 'entity:thing'
        ],
      ]);

    return $route;
  }
}
