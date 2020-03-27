<?php

namespace ETL\Extractor;

abstract class AbstractExtractor implements ExtractorInterface
{
    /**
     * @var mixed The data source to extract from
     */
    protected $source;

    /**
     * @var array
     */
    protected array $options;

    /**
     * AbstractExtractor constructor.
     * @param mixed $source
     * @param array $options
     */
    public function __construct($source, array $options = [])
    {
        $this->source = $source;
        $this->options = $options;
    }

    /**
     * Filters data from a source
     *
     * @return iterable The extracted data
     */
    public function extract(): iterable
    {
        return $this->getIterator($this->source, $this->options);
    }

    /**
     * @param mixed $source The source for the extractor
     * @param array $options The options for the extractor
     * @return iterable
     */
    abstract public function getIterator($source, array $options = []): iterable;
}
