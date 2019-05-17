<?php

namespace Drupal\lei_core\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Defines the Thing entity.
 *
 * @ingroup lei_core
 *
 * @ContentEntityType(
 *   id = "thing",
 *   label = @Translation("Thing"),
 *   label_plural = @Translation("Things"),
 *   handlers = {
 *     "storage" = "Drupal\lei_core\ThingStorage",
 *     "list_builder" = "Drupal\lei_core\ThingListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\lei_core\ThingHtmlRouteProvider"
 *     },
 *     "form" = {
 *       "edit" = "Drupal\lei_core\Form\ThingForm"
 *     }
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name"
 *   },
 *   links = {
 *     "canonical" = "/thing/{thing}",
 *     "collection" = "/admin/content/thing",
 *     "edit-form" = "/thing/{thing}/edit"
 *   },
 *   admin_permission = "administer thing entities",
 *   field_ui_base_route = "thing.settings",
 *   show_path_ui = TRUE
 * )
 */
class Thing extends ContentEntityBase implements ThingInterface
{
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
  {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(new TranslatableMarkup('ID'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Name'))
      ->setDescription(new TranslatableMarkup('The name of the thing.'))
      ->setReadOnly(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['rating'] = BaseFieldDefinition::create('decimal')
      ->setLabel(new TranslatableMarkup('Rating'))
      ->setDescription(new TranslatableMarkup('The rating of the thing.'))
      ->setReadOnly(TRUE)
      ->setDefaultValue(0)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_decimal',
      ])
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->get('name')->value;
  }

  /**
   * @return float
   */
  public function getRating()
  {
    return $this->get('rating')->value;
  }
}
