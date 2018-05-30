<?php

namespace Drupal\qed42_activities;

use Drupal\Core\Database\Connection;

/**
 *
 */
class DICFormService
{
    protected $db_name;
    protected $connection;

    /**
   *
   */
    public function __construct(Connection $connection) 
    {
        $this->connection = $connection;
        $this->db_name = 'd8training';
    }

    /**
   *
   */
    public function insertFormValue($data) 
    {
        // Insert data in table.
        $status = $this->connection->insert('dic_form')
            ->fields($data)
            ->execute();
        return $status;
    }

    /**
   *
   */
    public function fetchData() 
    {
        $result = $this->connection->select('dic_form', 'dic_form')
            ->fields('dic_form', ['fname', 'lname'])
            ->orderBy('nid', 'DESC')
            ->range(0, 1)
            ->execute();

        $output = [];
        while ($row = $result->fetchAssoc()) {
            $output['fname'] = $row['fname'];
            $output['lname'] = $row['lname'];
        }
        return $output;
    }

}
