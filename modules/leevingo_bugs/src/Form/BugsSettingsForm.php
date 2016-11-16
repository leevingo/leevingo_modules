<?php
/**
 * @file
 * Contains \Drupal\leevingo_bugs\Form\BugsSettingsForm.
 */

namespace Drupal\leevingo_bugs\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

/**
 * Class BugsSettingsForm
 * @package Drupal\leevingo_bugs\Form
 */
class BugsSettingsForm extends ConfigFormBase {

  /**
   * Constructor for BugsSettingsForm.
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
    return 'leevingo_bugs_bugs_settings_form';
  }

  /**
   * Gets the configuration names that will be editable.
   * @return array
   */
  protected function getEditableConfigNames() {
    return ['leevingo_bugs.settings'];
  }

  /**
   * Form constructor.
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $leevingo_bugs_config = $this->config('leevingo_bugs.settings');

    // General settings
    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General settings'),
      '#open' => TRUE,
      '#tree' => TRUE,
    ];
    $form['general']['enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable bugs'),
      '#description' => $this->t('Check this box to activate the bugs functionality'),
      '#default_value' => $leevingo_bugs_config->get('general_enable') ? $leevingo_bugs_config->get('general_enable') : '',
    ];
    $form['general']['visibility'] = [
      '#type' => 'details',
      '#title' => $this->t('Visibility'),
      '#open' => TRUE,
      '#tree' => TRUE,
      '#states' => [
        'visible' => [
          'input[name="general[enable]"]' => ['checked' => TRUE]
        ]
      ]
    ];
    $form['general']['visibility']['pages'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pages'),
      '#default_value' => $leevingo_bugs_config->get('general_visibility_pages') ? $leevingo_bugs_config->get('general_visibility_pages') : '',
      '#description' => $this->t("Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. An example path is %user-wildcard for every user page. %front is the front page.", ['%user-wildcard' => "/user/*", '%front' => "<front>"]),
    ];
    $form['general']['visibility']['negate'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Negate the condition'),
      '#default_value' => $leevingo_bugs_config->get('general_visibility_negate') ? $leevingo_bugs_config->get('general_visibility_negate') : '',
    ];

    // Bugs settings
    $form['bugs'] = [
      '#type' => 'details',
      '#title' => $this->t('Bugs'),
      '#open' => TRUE,
      '#tree' => TRUE,
      '#states' => [
        'visible' => [
          'input[name="general[enable]"]' => ['checked' => TRUE]
        ]
      ]
    ];

    // Fly settings.
    $form['bugs']['fly_enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable flies'),
      '#description' => $this->t('Check this box to release some flies on you screen'),
      '#default_value' => $leevingo_bugs_config->get('bugs_fly_enable') ? $leevingo_bugs_config->get('bugs_fly_enable') : '',
    ];
    $form['bugs']['fly_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Fly settings'),
      '#open' => TRUE,
      '#states' => [
        'visible' => [
          'input[name="bugs[fly_enable]"]' => ['checked' => TRUE]
        ]
      ]
    ];
    $form['bugs']['fly_settings']['min'] = [
      '#type' => 'number',
      '#title' => $this->t('Minimum amount'),
      '#default_value' => $leevingo_bugs_config->get('bugs_fly_settings_min') ? $leevingo_bugs_config->get('bugs_fly_settings_min') : 1,
      '#min' => 0,
      '#max' => 99
    ];
    $form['bugs']['fly_settings']['max'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximun amount'),
      '#default_value' => $leevingo_bugs_config->get('bugs_fly_settings_max') ? $leevingo_bugs_config->get('bugs_fly_settings_max') : 2,
      '#min' => 0,
      '#max' => 99
    ];

    // Spider settings.
    $form['bugs']['spider_enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable spiders'),
      '#description' => $this->t('Check this box to release some spiders on you screen'),
      '#default_value' => $leevingo_bugs_config->get('bugs_spider_enable') ? $leevingo_bugs_config->get('bugs_spider_enable') : '',
    ];
    $form['bugs']['spider_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Spider settings'),
      '#open' => TRUE,
      '#states' => [
        'visible' => [
          'input[name="bugs[spider_enable]"]' => ['checked' => TRUE]
        ]
      ]
    ];
    $form['bugs']['spider_settings']['min'] = [
      '#type' => 'number',
      '#title' => $this->t('Minimum amount'),
      '#default_value' => $leevingo_bugs_config->get('bugs_spider_settings_min') ? $leevingo_bugs_config->get('bugs_spider_settings_min') : 1,
      '#min' => 0,
      '#max' => 99
    ];
    $form['bugs']['spider_settings']['max'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximun amount'),
      '#default_value' => $leevingo_bugs_config->get('bugs_spider_settings_max') ? $leevingo_bugs_config->get('bugs_spider_settings_max') : 2,
      '#min' => 0,
      '#max' => 99
    ];

    return parent::buildForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('leevingo_bugs.settings')
      ->set('general_enable', $form_state->getValue(['general', 'enable']))
      ->set('general_visibility_pages', $form_state->getValue(['general', 'visibility', 'pages']))
      ->set('general_visibility_negate', $form_state->getValue(['general', 'visibility', 'negate']))
      ->set('bugs_fly_enable', $form_state->getValue(['bugs', 'fly_enable']))
      ->set('bugs_fly_settings_min', $form_state->getValue(['bugs', 'fly_settings', 'min']))
      ->set('bugs_fly_settings_max', $form_state->getValue(['bugs', 'fly_settings', 'max']))
      ->set('bugs_spider_settings_min', $form_state->getValue(['bugs', 'spider_settings', 'min']))
      ->set('bugs_spider_settings_max', $form_state->getValue(['bugs', 'spider_settings', 'max']))
      ->set('bugs_spider_enable', $form_state->getValue(['bugs', 'spider_enable']))
      ->save();

    parent::submitForm($form, $form_state);

  }
}