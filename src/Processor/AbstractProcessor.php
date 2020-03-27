<?php

namespace ETL\Processor;

use ETL\Collection;
use ETL\Extractor\ExtractorInterface;
use ETL\Loader\LoaderInterface;
use ETL\Pipeline;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class AbstractProcessor implements ProcessorInterface
{
    /**
     * @var Collection Data for the current process
     */
    protected Collection $collection;

    /**
     * @var ExtractorInterface
     */
    protected ExtractorInterface $extractor;

    /**
     * @var Pipeline
     */
    protected Pipeline $transformers;

    /**
     * @var LoaderInterface
     */
    protected LoaderInterface $loader;

    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $dispatcher;

    /**
     * Flag if the processor has been stopped
     *
     * @var bool
     */
    protected bool $stopped = false;

    /**
     * Flag if the processor has skipped the current iteration
     *
     * @var bool
     */
    protected bool $skipped = false;

    /**
     * @param ExtractorInterface $extractor Extractor instance for retrieving data
     * @return $this
     */
    public function setExtractor(ExtractorInterface $extractor): self
    {
        $this->extractor = $extractor;
        return $this;
    }

    /**
     * @param Pipeline $transformers Pipeline of transformers to apply to the context
     * @return $this
     */
    public function setTransformers(Pipeline $transformers): self
    {
        $this->transformers = $transformers;
        return $this;
    }

    /**
     * @param LoaderInterface $loader Loader instance for storing data
     * @return $this
     */
    public function setLoader(LoaderInterface $loader): self
    {
        $this->loader = $loader;
        return $this;
    }

    /**
     * @param EventDispatcherInterface $dispatcher Event dispatcher to trigger processor events
     * @return $this
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): self
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    /**
     * Stops the processor from progression further
     *
     * @return void
     */
    public function stop(): void
    {
        $this->stopped = true;
    }

    /**
     * Checks if the processor has been stopped
     *
     * @return bool
     */
    public function isStopped(): bool
    {
        return $this->stopped;
    }

    /**
     * Skips the current iteration the processor is on
     *
     * @return void;
     */
    public function skip(): void
    {
        $this->skipped = true;
    }

    /**
     * Checks if the processor has been skipped for the current iteration
     *
     * @return bool
     */
    public function isSkipped(): bool
    {
        return $this->skipped;
    }

    /**
     * Resets the skipped flag
     *
     * @return void;
     */
    public function resetSkipped(): void
    {
        $this->skipped = false;
    }

    /**
     * Returns the collection of data for the current process
     *
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }
}
