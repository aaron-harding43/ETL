<?php

namespace ETL\Transformer;

use ETL\Context;

class AttributeMapperTransformer extends AbstractTransformer
{
    public function transform(Context $context): Context
    {
        // Skip transform if attributes are empty
        if (empty($this->attributes)) {
            // @todo Add some proper error handling
            return $context;
        }

        $data = $context->toArray();
        $result = new Context;

        foreach ($data as $key => $value) {
            $attr = $this->getMappedKey($key);

            if (!empty($attr)) {
                $result[$attr] = $value;
            }
        }

        // Return the new context
        return $result;
    }

    /**
     * Remaps a key to a new attribute
     *
     * @param string $key The key to remap
     * @return mixed|null
     */
    protected function getMappedKey(string $key)
    {
        return $this->attributes[$key] ?? null;
    }
}
