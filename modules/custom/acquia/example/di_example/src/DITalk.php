<?php
/**
 * Created by PhpStorm.
 * User: sonvir
 * Date: 27/12/17
 * Time: 3:45 PM
 */

namespace Drupal\di_example;

use Drupal\Core\Session\AccountProxy;

/**
 * A service that provides a system for getting response message.
 */
class DITalk {
  protected $responsesToMood = [
    'Very Sad' => 'I hope you feel better.',
    'Sad' => 'are you ok?',
    'So-so' => 'good morning.',
    'Happy' => 'what\'s Up?',
    'Very Happy' => 'you seem happy today!',
  ];

  /**
   * @var \Drupal\di_example\DIMoodRing
   */
  protected $dIMoodRing;

  /**
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * We will inject our two services and store them for use in our service methods.
   *
   * @param \Drupal\Core\Session\AccountProxy $CurrentUser
   * @param \Drupal\di_example\DIMoodRing $DIMoodRing
   */
  public function __construct(AccountProxy $CurrentUser, DIMoodRing $DIMoodRing) {
    $this->currentUser = $CurrentUser;
    $this->dIMoodRing = $DIMoodRing;
  }

  /**
   * Returns a string that is a message to a user.
   *
   * @return string
   */
  public function getResponseToMood() {
    // We can use our services and their defined methods.
    $username = $this->currentUser->getUsername();
    $mood = $this->dIMoodRing->getMood();

    // We build a message to return.
    return $username . ', ' . $this->responsesToMood[$mood];
  }
}