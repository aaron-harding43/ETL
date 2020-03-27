<?php

namespace ETL\Extractor;

use ETL\Context;

class ArrayExtractor extends AbstractExtractor
{
    /**
     * @param mixed $source The iterator source
     * @param array $options The options for the extractor
     * @return iterable
     */
    public function getIterator($source, array $options = []): iterable
    {
        return array_map([Context::class, 'fromState'], $source);
    }
}
