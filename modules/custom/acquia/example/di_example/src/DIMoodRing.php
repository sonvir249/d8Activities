<?php
/**
 * @file Contains \Drupal\di_example\DIMoodRing
 */

namespace Drupal\di_example;

/**
 * A Service for reading a mood from a mood ring.
 *
 * This service does not have any dependencies.
 */
class DIMoodRing {
  protected $moods = [
    0 => 'Very Sad',
    1 => 'Sad',
    2 => 'So-so',
    3 => 'Happy',
    4 => 'Very Happy',
  ];

  /**
   * Returns a string that tells the user's current mood.
   *
   * @return string
   */
  public function getMood() {
    return $this->moods[rand(0,4)];
  }
}