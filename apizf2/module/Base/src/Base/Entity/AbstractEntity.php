<?php

namespace Base\Entity;

use Zend\Hydrator\ClassMethods;

class AbstractEntity
{
    /**
     * @return array
     */
    public function toArray()
    {
        $hydrator = new ClassMethods();
        return $hydrator->extract($this);
    }

    /**
     * @param $options
     */
    public function populate($options)
    {
        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);
    }
}