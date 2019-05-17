<?php

namespace Drupal\lei_core;

use Drupal;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\ContentEntityStorageBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Language\LanguageInterface;
use GuzzleHttp\Client;

/**
 * Defines the storage handler class for Things.
 *
 * @ingroup lei_core
 */
class ThingStorage extends ContentEntityStorageBase implements ThingStorageInterface
{

  /**
   * Reads values to be purged for a single field.
   *
   * This method is called during field data purge, on fields for which
   * onFieldDefinitionDelete() has previously run.
   *
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The field definition.
   * @param $batch_size
   *   The maximum number of field data records to purge before returning.
   *
   * @return \Drupal\Core\Field\FieldItemListInterface[]
   *   An array of field item lists, keyed by entity revision id.
   */
  protected function readFieldItemsToPurge(FieldDefinitionInterface $field_definition, $batch_size)
  {
    // TODO: Implement readFieldItemsToPurge() method.
  }

  /**
   * Removes field items from storage per entity during purge.
   *
   * @param ContentEntityInterface $entity
   *   The entity revision, whose values are being purged.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The field whose values are bing purged.
   */
  protected function purgeFieldItems(ContentEntityInterface $entity, FieldDefinitionInterface $field_definition)
  {
    // TODO: Implement purgeFieldItems() method.
  }

  /**
   * Actually loads revision field item values from the storage.
   *
   * @param int|string $revision_id
   *   The revision identifier.
   *
   * @return \Drupal\Core\Entity\EntityInterface|null
   *   The specified entity revision or NULL if not found.
   *
   * @deprecated in Drupal 8.5.x and will be removed before Drupal 9.0.0.
   *   \Drupal\Core\Entity\ContentEntityStorageBase::doLoadMultipleRevisionsFieldItems()
   *   should be implemented instead.
   *
   * @see https://www.drupal.org/node/2924915
   */
  protected function doLoadRevisionFieldItems($revision_id)
  {
    // TODO: Implement doLoadRevisionFieldItems() method.
  }

  /**
   * Writes entity field values to the storage.
   *
   * This method is responsible for allocating entity and revision identifiers
   * and updating the entity object with their values.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity object.
   * @param string[] $names
   *   (optional) The name of the fields to be written to the storage. If an
   *   empty value is passed all field values are saved.
   */
  protected function doSaveFieldItems(ContentEntityInterface $entity, array $names = [])
  {
    // TODO: Implement doSaveFieldItems() method.
  }

  /**
   * Deletes entity field values from the storage.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface[] $entities
   *   An array of entity objects to be deleted.
   */
  protected function doDeleteFieldItems($entities)
  {
    // TODO: Implement doDeleteFieldItems() method.
  }

  /**
   * Deletes field values of an entity revision from the storage.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $revision
   *   An entity revision object to be deleted.
   */
  protected function doDeleteRevisionFieldItems(ContentEntityInterface $revision)
  {
    // TODO: Implement doDeleteRevisionFieldItems() method.
  }

  /**
   * Performs storage-specific loading of entities.
   *
   * Override this method to add custom functionality directly after loading.
   * This is always called, while self::postLoad() is only called when there are
   * actual results.
   *
   * @param array|null $ids
   *   (optional) An array of entity IDs, or NULL to load all entities.
   *
   * @return \Drupal\Core\Entity\EntityInterface[]
   *   Associative array of entities, keyed on the entity ID.
   */
  protected function doLoadMultiple(array $ids = NULL)
  {
    // todo: our storage endpoint doesn't support filtering so we always fetch everything
    $storage_endpoint = \Drupal::configFactory()->get('thing.settings')->get('storage_endpoint');
    $results = [];

    if ($storage_endpoint) {
      /** @var Client $client */
      $client = Drupal::service('http_client');
      $response = $client->get($storage_endpoint);
      $body = $response->getBody();
      $contents = json_decode($body->getContents(), TRUE);

      foreach ($contents as $key => $content) {
        $results[$key] = [
          'id' => [
            LanguageInterface::LANGCODE_DEFAULT => $content['id']
          ],
          'name' => [
            LanguageInterface::LANGCODE_DEFAULT => $content['name']
          ],
          'rating' => [
            LanguageInterface::LANGCODE_DEFAULT => $content['rating']
          ]
        ];
      }
    }

    return $this->mapFromStorageRecords($results);
  }

  /**
   * Determines if this entity already exists in storage.
   *
   * @param int|string $id
   *   The original entity ID.
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity being saved.
   *
   * @return bool
   */
  protected function has($id, EntityInterface $entity)
  {
    return TRUE;
  }

  /**
   * Gets the name of the service for the query for this entity storage.
   *
   * @return string
   *   The name of the service for the query for this entity storage.
   */
  protected function getQueryServiceName()
  {
    return 'entity.query.thing';
  }

  /**
   * Determines the number of entities with values for a given field.
   *
   * @param \Drupal\Core\Field\FieldStorageDefinitionInterface $storage_definition
   *   The field for which to count data records.
   * @param bool $as_bool
   *   (Optional) Optimises the query for checking whether there are any records
   *   or not. Defaults to FALSE.
   *
   * @return bool|int
   *   The number of entities. If $as_bool parameter is TRUE then the
   *   value will either be TRUE or FALSE.
   *
   * @see \Drupal\Core\Entity\FieldableEntityStorageInterface::purgeFieldData()
   */
  public function countFieldData($storage_definition, $as_bool = FALSE)
  {
    // TODO: Implement countFieldData() method.
  }
}
