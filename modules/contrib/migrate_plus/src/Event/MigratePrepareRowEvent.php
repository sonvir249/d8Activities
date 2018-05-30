<?php

namespace Drupal\migrate_plus\Event;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Plugin\MigrateSourceInterface;
use Drupal\migrate\Row;
use Symfony\Component\EventDispatcher\Event;

/**
 * Wraps a prepare-row event for event listeners.
 */
class MigratePrepareRowEvent extends Event {

  /**
   * Row object.
   *
   * @var \Drupal\migrate\Row
   */
  protected $row;

  /**
   * migrate source plugin.
   *
   * @var \Drupal\migrate\Plugin\MigrateSourceInterface
   */
  protected $source;

  /**
   * migrate plugin.
   *
   * @var \Drupal\migrate\Plugin\MigrationInterface
   */
  protected $migration;

  /**
   * Constructs a prepare-row event object.
   *
   * @param \Drupal\migrate\Row $row
   *   Row of source data to be analyzed/manipulated.
   *
   * @param \Drupal\migrate\Plugin\MigrateSourceInterface $source
   *   Source plugin that is the source of the event.
   *
   * @param \Drupal\migrate\Plugin\MigrationInterface $migration
   *   migrate entity.
   */
  public function __construct(Row $row, MigrateSourceInterface $source, MigrationInterface $migration) {
    $this->row = $row;
    $this->source = $source;
    $this->migration = $migration;
  }

  /**
   * Gets the row object.
   *
   * @return \Drupal\migrate\Row
   *   The row object about to be imported.
   */
  public function getRow() {
    return $this->row;
  }

  /**
   * Gets the source plugin.
   *
   * @return \Drupal\migrate\Plugin\MigrateSourceInterface
   *   The source plugin firing the event.
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * Gets the migration plugin.
   *
   * @return \Drupal\migrate\Plugin\MigrationInterface
   *   The migration entity being imported.
   */
  public function getMigration() {
    return $this->migration;
  }

}