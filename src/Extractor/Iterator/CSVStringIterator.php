<?php

namespace ETL\Extractor\Iterator;

use IteratorAggregate;
use ETL\Context;

class CSVStringIterator implements IteratorAggregate
{
    /**
     * @var string The CSV contents
     */
    protected $csv;

    /**
     * CSVStringIterator constructor.
     *
     * @param string $csv
     */
    public function __construct(string $csv)
    {
        $this->csv = $csv;
    }

    /**
     * Parses the CSV string for iteration
     *
     * @param string $csv The CSV string to break down
     * @param string $delimiter The delimeter character for each column
     * @param string $enclosure The enclosure character
     * @param string $escape The escape character
     *
     * @return \Generator
     */
    public function parse(string $csv, string $delimiter = ',', string $enclosure = '"', string $escape = '\\')
    {
        $row = strtok($csv, "\n");
        $context = str_getcsv($row, $delimiter, $enclosure, $escape);
        yield new Context($context);

        while ($row = strtok("\n")) {
            $context = str_getcsv($row, $delimiter, $enclosure, $escape);
            yield new Context($context);
        }
    }

    /**
     *
     * Returns the Generator instance for iteration
     *
     * @return \Generator
     */
    public function getIterator()
    {
        return $this->parse($this->csv);
    }
}
