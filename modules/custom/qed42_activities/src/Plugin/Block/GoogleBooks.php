<?php

namespace Drupal\qed42_activities\Plugin\Block;

use Drupal\Core\block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Provides a 'GoogleBooks' block.
 *
 * Drupal\block\BlockBase gives us a very useful set of basic functionality for
 * this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "google_books",
 *   admin_label = @Translation("Google Books Block"),
 *   category = @Translation("Custom Block")
 * )
 */
class GoogleBooks extends BlockBase
{

    /**
   * {@inheritdoc}
   */
    public function defaultConfiguration() 
    {
        return [
        'google_books_block' => $this->t('Google Books'),
        ];
    }

    /**
   * {@inheritdoc}
   */
    public function blockForm($form, FormStateInterface $form_state) 
    {
        $config = $this->getConfiguration();
        $form['isbn'] = [
        '#type' => 'textfield',
        '#title' => $this->t('ISBN Number'),
        '#size' => 60,
        '#description' => $this->t('Enter ISBN number.'),
        '#default_value' => isset($config['google_books_block']) ? $config['google_books_block'] : '',
        ];
        return $form;
    }

    /**
   * {@inheritdoc}
   */
    public function blockSubmit($form, FormStateInterface $form_state) 
    {
        $this->configuration['google_books_block'] = $form_state->getValue('isbn');
    }

    /**
   * {@inheritdoc}
   */
    public function build() 
    {
        $config = $this->getConfiguration();
        $data = '';
        try {
            $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
            $fetcher = new Fetcher($client);
            $book = $fetcher->forISBN($config['google_books_block']);
            $title = !empty($book->title) ? $book->title : '';
            $subtitle = !empty($book->subtitle) ? $book->subtitle : '';
            $authors = is_array($book->authors) ? implode(', ', $book->authors) : '';
            $categories = is_array($book->categories) ? implode(',', $book->categories) : '';

            $data = 'Title: ' . $title . '<br>Subtitle: ' . $subtitle . '<br>Authors: ' . $authors . '<br>Language: ' . $book->language . '<br>Category: ' . $categories;
        }
        catch (RequestException $ex) {
            $data;
        }
        return [
        '#markup' => $data,
        ];
    }

}
