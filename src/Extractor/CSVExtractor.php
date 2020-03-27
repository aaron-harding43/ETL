<?php

namespace ETL\Extractor;

class CSVExtractor extends AbstractExtractor
{
    /**
     * @param mixed $source The iterator source
     * @param array $options The options for the extractor
     * @return iterable
     */
    public function getIterator($source, array $options = []): iterable
    {
        // Determine the source type
        if (is_string($source) && file_exists($source)) {
            return new Iterator\CSVFileIterator($source);
        }

        if (is_string($source)) {
            return new Iterator\CSVStringIterator($source);
        }

        return [];
    }
}
