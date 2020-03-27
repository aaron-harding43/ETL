<?php

namespace ETL\Processor;

use ETL\Collection;
use ETL\Extractor\ExtractorInterface;
use ETL\Loader\LoaderInterface;
use ETL\Pipeline;
use Psr\EventDispatcher\EventDispatcherInterface;

interface ProcessorInterface
{
    /**
     * @param ExtractorInterface $extractor Extractor instance for retrieving data
     * @return $this
     */
    public function setExtractor(ExtractorInterface $extractor): self;

    /**
     * @param Pipeline $transformers Pipeline of transformers to apply to the context
     * @return $this
     */
    public function setTransformers(Pipeline $transformers): self;

    /**
     * @param LoaderInterface $loader Loader instance for storing data
     * @return $this
     */
    public function setLoader(LoaderInterface $loader): self;

    /**
     * @param EventDispatcherInterface $dispatcher Event dispatcher to trigger processor events
     * @return $this
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher): self;

    /**
     * Runs the ETL process
     *
     * @return mixed
     */
    public function run();

    /**
 * Stops the processor from progression further
 *
 * @return void
 */
    public function stop(): void;

    /**
     * Checks if the processor has been stopped
     *
     * @return bool
     */
    public function isStopped(): bool;

    /**
     * Skips the current iteration the processor is on
     *
     * @return void;
     */
    public function skip(): void;

    /**
     * Checks if the processor has been skipped for the current iteration
     *
     * @return bool
     */
    public function isSkipped(): bool;

    /**
     * Resets the skipped flag
     *
     * @return void;
     */
    public function resetSkipped(): void;

    /**
     * Returns the collection of data for the current process
     *
     * @return Collection
     */
    public function getCollection(): Collection;
}
