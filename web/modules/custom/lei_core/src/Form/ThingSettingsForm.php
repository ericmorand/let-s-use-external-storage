<?php

namespace Drupal\lei_core\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Class ThingSettingsForm.
 *
 * @ingroup lei_core
 */
class ThingSettingsForm extends ConfigFormBase
{

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames()
  {
    return [
      'thing.settings'
    ];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId()
  {
    return 'thing_settings';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::buildForm($form, $form_state);

    $form['storage_endpoint'] = [
      '#type' => 'textfield',
      '#title' => t('Persistent storage endpoint'),
      '#description' => new TranslatableMarkup('The URL of the persistent storage endpoint'),
      '#default_value' => $this->config('thing.settings')->get('storage_endpoint'),
      '#required' => TRUE
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->config('thing.settings')
      ->set('storage_endpoint', $form_state->getValue('storage_endpoint'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
