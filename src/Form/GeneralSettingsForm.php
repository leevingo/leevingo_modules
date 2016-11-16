<?php
/**
 * @file
 * Contains \Drupal\leevingo_modules\Form\GeneralSettingsForm.
 */

namespace Drupal\leevingo_modules\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

/**
 * Class GeneralSettingsForm
 * @package Drupal\leevingo_modules\Form
 */
class GeneralSettingsForm extends ConfigFormBase {

  /**
   * Constructor for GeneralSettingsForm.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * Returns a unique string identifying the form.
   * @return string
   */
  public function getFormId() {
    return 'leevingo_modules_general_settings_form';
  }

  /**
   * Gets the configuration names that will be editable.
   * @return array
   */
  protected function getEditableConfigNames() {
    return ['leevingo_modules.settings'];
  }

  /**
   * Form constructor.
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $leevingo_modules_config = $this->config('leevingo_modules.settings');

    // Privacy policy.
    $form['privacy_policy'] = [
      '#type' => 'details',
      '#title' => $this->t('Privacy policy'),
      '#open' => FALSE,
    ];
    $form['privacy_policy']['privacy_policy_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Privacy policy url'),
      '#maxlength' => 255,
      '#default_value' => $leevingo_modules_config->get('privacy_policy_url') ? $leevingo_modules_config->get('privacy_policy_url') : '',
      '#description' => $this->t('Set the url to the privacy policy page.')
    ];

    return parent::buildForm($form, $form_state);

  }

  /**
   * Form submission handler.
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('leevingo_modules.settings')
      // Set privacy policy.
      ->set('privacy_policy_url', $form_state->getValue(array('privacy_policy_url')))
      ->save();

    parent::submitForm($form, $form_state);

  }
}