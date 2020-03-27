<?php

namespace ETL;

use ArrayAccess;

class Context implements ArrayAccess
{
    protected array $data = [];

    /**
     * Creates the context from an array
     *
     * @param array $data The data for the context
     * @return Context
     */
    public static function fromState(array $data): self
    {
        return new self($data);
    }

    /**
     * Context constructor.
     * @param array $data The raw row data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Setter for key and value pair
     *
     * @param string $key  The attribute name
     * @param mixed $value The value of the attribute
     */
    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Applies the callable to each attribute in the context
     *
     * @param callable $callback The callback value to apply to the value
     * @param array $attributes The attributes to apply the transformation to
     * @return $this
     */
    public function transform(callable $callback, array $attributes = [])
    {
        // If null skip transform
        if ((count($attributes) == 1) && is_null($attributes[0])) {
            return $this;
        }

        if (empty($attributes)) {
            $attributes = array_keys($this->data);
        }

        foreach ($attributes as $attr) {
            $this->set($attr, $callback($this->data[$attr]));
        }

        return $this;
    }

    /**
     * Getter
     *
     * @param string $key The attribute name to retrieve the value from
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->data[$key];
    }

    /**
     * Magic method for setting attributes
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Magic method for retrieving attributes
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Converts the instance into an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
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
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
