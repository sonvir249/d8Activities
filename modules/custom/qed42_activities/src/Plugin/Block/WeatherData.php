<?php

namespace Drupal\qed42_activities\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\qed42_activities\FetchWeatherData;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'ExampleEmptyBlock' block.
 *
 * Drupal\block\BlockBase gives us a very useful set of basic functionality for
 * this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "weather_data",
 *   admin_label = @Translation("Weather Data Block"),
 *   category = @Translation("Custom Block")
 * )
 */
class WeatherData extends BlockBase implements ContainerFactoryPluginInterface
{
  protected $siteUrl;
  protected $fetchWeatherData;

  use StringTranslationTrait;

  public function __construct( array $configuration, $plugin_id, $plugin_definition, FetchWeatherData $fetchWeatherData) {
    // If you're extending a core plugin class, call its constructor.
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->fetchWeatherData = $fetchWeatherData;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('qed42_activities.weather')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return [
    'weather_data_block' => $this->t('Custom block to display weather data using data from http://api.openweathermap.org/'),
    ];
  }

    /**
   * {@inheritdoc}
   */
    public function blockForm($form, FormStateInterface $form_state) 
    {
        $form['city'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Enter City'),
        '#size' => 60,
        '#description' => $this->t('City name to get weather data.'),
        '#default_value' => $this->configuration['weather_data_block'],
        ];
        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function blockSubmit($form, FormStateInterface $form_state) 
    {
        $this->configuration['weather_data_block'] = $form_state->getValue('city');
    }

    /**
    * {@inheritdoc}
    */
    protected function blockAccess(AccountInterface $account) 
    {
        return AccessResult::allowedIfHasPermission($account, 'access content');
    }

    /**
    * {@inheritdoc}
    */
    public function build() 
    {
      $weather_data = $this->fetchWeatherData->weatherData($this->configuration['weather_data_block']);
      if (!empty($weather_data)) {
        $weather_data_obj = json_decode($weather_data);
        $weather_data = (array) $weather_data_obj->main;
        $weather_data['wind_speed'] = $weather_data_obj->wind->speed;
        return [
        '#theme' => 'weather_block',
        '#city' => $weather_data_obj->name,
        '#temp' => $weather_data_obj->main->temp,
        '#pressure' => $weather_data_obj->main->pressure,
        '#humidity' => $weather_data_obj->main->humidity,
        '#temp_min' => $weather_data_obj->main->temp_min,
        '#temp_max' => $weather_data_obj->main->temp_max,
        '#wind_speed' => $weather_data_obj->wind->speed,
        '#attached' => [
            'library' => ['qed42_activities/weather_block']
          ]
        ];
      }
    }

}
