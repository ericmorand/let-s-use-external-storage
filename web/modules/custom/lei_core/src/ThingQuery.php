<?php


namespace Drupal\lei_core;


use Drupal;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Query\QueryBase;
use GuzzleHttp\Client;

class ThingQuery extends QueryBase
{
  /** @var ImmutableConfig $settings */
  protected $settings;

  public function __construct(EntityTypeInterface $entity_type, $conjunction, array $namespaces, ImmutableConfig $settings)
  {
    parent::__construct($entity_type, $conjunction, $namespaces);

    $this->settings = $settings;
  }

  /**
   * Execute the query.
   *
   * @return int|array
   *   Returns an integer for count queries or an array of ids. The values of
   *   the array are always entity ids. The keys will be revision ids if the
   *   entity supports revision and entity ids if not.
   */
  public function execute()
  {
    // todo: our storage endpoint doesn't support filtering so we always fetch everything
    $storage_endpoint = $this->settings->get('storage_endpoint');
    $results = [];

    if ($storage_endpoint) {
      /** @var Client $client */
      $client = Drupal::service('http_client');
      $response = $client->get($storage_endpoint);
      $body = $response->getBody();

      $results = json_decode($body->getContents(), TRUE);

      foreach ($results as $key => $result) {
        $results[$key] = $result['id'];
      }
    }

    if ($this->count) {
      return count($results);
    }
    
    return $results;
  }
}
