<?php

namespace Drupal\qed42_activities\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 *
 */
class NodeInsert extends Event
{
    const INSERT = 'node.insert';
    protected $referenceNode;

    /**
   * Constructs a new Node Instance.
   *
   * @param $node
   *   Node object.
   */
    public function __construct($node) 
    {
        $this->referenceNode = $node;
    }

    /**
   * Getter for the getReferenceNode.
   *
   * @return Instance
   *   Node object.
   */
    public function getReferenceNode() 
    {
        return $this->referenceNode;
    }

}
