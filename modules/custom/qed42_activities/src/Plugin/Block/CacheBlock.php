<?php

namespace Drupal\qed42_activities\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CacheBlock.
 *
 * @package Drupal\qed42_activities\Plugin\Block
 * @Block(
 *   id = "cache_block",
 *   admin_label = @Translation("Cache Block"),
 *   category = @Translation("Custom Block Cache Block")
 * )
 */
class CacheBlock extends BlockBase
{

    /**
   * {@inheritdoc}
   */
    public function defaultConfiguration() 
    {
        return [
        'cache_data_block' => $this->t('Custom block to cache'),
        ];
    }

    /**
   * {@inheritdoc}
   */
    public function blockSubmit($form, FormStateInterface $form_state) 
    {

    }

    /**
   * {@inheritdoc}
   */
    public function blockForm($form, FormStateInterface $form_state) 
    {
        $form = parent::blockForm($form, $form_state);
        return $form;
    }

    /**
   * {@inheritdoc}
   */
    public function build() 
    {
        $renderer = \Drupal::service('renderer');
        $config = \Drupal::config('system.site');
        $current_user = \Drupal::currentUser();

        $connection = Database::getConnection();
        $query = $connection->select('node_field_data', 'n')
            ->fields('n', ['nid', 'title'])
            ->condition('type', 'article', '=')
            ->orderBy('created', 'DESC')
            ->range(0, 5)
            ->execute();
        $values[] = '';
        foreach ($query as $key => $value) {
            $values[$key]['nid'] = $value->nid;
            $values[$key]['title'] = $value->title;
        }
        return [
        '#markup' =>
        $values[0]['nid'] . ': ' . $values[0]['title'] . '<br>' .
        $values[1]['nid'] . ': ' . $values[1]['title'] . '<br>' .
        $values[2]['nid'] . ': ' . $values[2]['title'] . '<br>' .
        'email : ' . \Drupal::currentUser()->getEmail(),

        '#cache' => [
          'keys' => ['cache_data_block'],
          'contexts' => ['url.path'],
          'tags' => ['node:' . $values[0]['nid'], 'node:' . $values[1]['nid'] . 'node:' . $values[2]['nid']],
          ],
        ];
    }

}
