<?php

namespace Drupal\lei_core\Form;

use Drupal;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for entity edit forms.
 *
 * @ingroup lei_entity
 */
class ThingForm extends ContentEntityForm
{

  /**
   * The Current User object.
   *
   * @var AccountInterface
   */
  protected $currentUser;

  /**
   * The date formatter service.
   *
   * @var DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a NodeForm object.
   *
   * @param EntityRepositoryInterface $entity_repository
   *   The entity repository.
   * @param EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param TimeInterface $time
   *   The time service.
   * @param AccountInterface $current_user
   *   The current user.
   * @param DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, AccountInterface $current_user = NULL, DateFormatterInterface $date_formatter = NULL)
  {
    parent::__construct($entity_repository, $entity_type_bundle_info, $time);

    $this->currentUser = $current_user;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('entity.repository'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('current_user'),
      $container->get('date.formatter')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state)
  {
    /** @var Drupal\lei_core\Entity\ThingInterface $entity */
    $entity = $this->entity;

    if ($this->operation == 'edit') {
      $form['#title'] = $this->t('Edit %type @title', [
        '%type' => strtolower($entity->getEntityType()->getLabel()),
        '@title' => $entity->label(),
      ]);
    }

    $form = parent::form($form, $form_state);

    $form['advanced']['#type'] = 'container';
    $form['advanced']['#attributes']['class'][] = 'entity-meta';

    $form['meta'] = [
      '#type' => 'container',
      '#group' => 'advanced',
      '#weight' => -10,
      '#title' => $this->t('Status'),
      '#attributes' => ['class' => ['entity-meta__header']],
      '#tree' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state)
  {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);
    $entity_type_label = strtolower($this->getEntity()->getEntityType()->getLabel());

    switch ($status) {
      case SAVED_NEW:
        $this
          ->messenger()
          ->addStatus($this->t('Created the %label @type.', [
            '%label' => $entity->label(),
            '@type' => $entity_type_label
          ]));
        break;

      default:
        $this
          ->messenger()
          ->addStatus($this->t('Saved the %label @type.', [
            '%label' => $entity->label(),
            '@type' => $entity_type_label
          ]));
    }

    $form_state->setRedirectUrl($entity->toUrl());
  }
}
