<?php

namespace ETL;

use ArrayIterator;
use IteratorAggregate;
use ArrayAccess;

class Collection implements IteratorAggregate, ArrayAccess
{
    protected array $data = [];

    /**
     * Adds the context to the end of the collection
     *
     * @param Context $context
     */
    public function add(Context $context)
    {
        $this->data[] = $context;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
