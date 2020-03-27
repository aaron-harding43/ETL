<?php

namespace ETL\Extractor;

use Iterator;

/**
 * Interface ExtractorInterface
 *
 * @package ETL\Extractor
 */
interface ExtractorInterface
{
    /**
     * Filters data from a source
     *
     * @return iterable The extracted data
     */
    public function extract(): iterable;
}