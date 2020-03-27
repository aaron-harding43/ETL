<?php

namespace ETL\Extractor\Iterator;

use IteratorAggregate;
use ETL\Context;

class CSVFileIterator implements IteratorAggregate
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
        if (!file_exists($csv)) {
            throw new \RuntimeException('CSV file not found.');
        }

        $this->csv = fopen($csv, 'r');
    }

    /**
     * Parses the CSV string for iteration
     *
     * @param resource $csv The CSV string to break down
     * @param string $delimiter The delimeter character for each column
     * @param string $enclosure The enclosure character
     * @param string $escape The escape character
     *
     * @return \Generator
     */
    public function parse($csv, string $delimiter = ',', string $enclosure = '"', string $escape = '\\')
    {
        while ($row = fgetcsv($csv, 2048, $delimiter, $enclosure, $escape)) {
            yield new Context($row);
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

    /**
     * Closes the file handler when we are done
     */
    public function __destruct()
    {
        fclose($this->csv);
    }
}
