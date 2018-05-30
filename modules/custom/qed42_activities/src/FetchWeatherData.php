<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 29/01/18
 * Time: 1:32 PM
 */

namespace Drupal\qed42_activities;

class FetchWeatherData
{
  public function weatherData($city)
  {
    $config = \Drupal::config('qed42_activities.settings');
    $client = \Drupal::httpClient();

     $client->request('GET', 'http://api.openweathermap.org/data/2.5/weather?q=mumbai&appid=2ae6e13f8875b87d47454e897e6da198');
    try {
      $request = $client->get('http://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $config->get('app_id'));
      return $request->getBody();
    }
    catch (RequestException $e) {
      watchdog_exception('qed42_activities', $e->getMessage());
      return($this->t('Error'));
    }
  }
}