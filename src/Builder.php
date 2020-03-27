<?php

namespace ETL;

use ETL\Extractor\ExtractorInterface;
use ETL\Loader\LoaderInterface;
use ETL\Processor\ProcessorInterface;
use ETL\Transformer\TransformerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class Builder
{
    /**
     * @var LoaderInterface
     */
    protected LoaderInterface $loader;

    /**
     * @var Pipeline
     */
    protected Pipeline $transformers;

    /**
     * @var ExtractorInterface
     */
    protected ExtractorInterface $extractor;

    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $dispatcher;

    /**
     * Builder constructor.
     */
    public function __construct()
    {
        $this->transformers = new Pipeline();
        $this->dispatcher = new Event\Dispatcher;
    }

    /**
     * @param LoaderInterface $loader Loader instance for retrieving data
     * @return Builder
     */
    public function load(LoaderInterface $loader): self
    {
        $this->loader = $loader;
        return $this;
    }

    /**
     * @param TransformerInterface $transformer
     * @return Builder
     */
    public function transform(TransformerInterface $transformer): self
    {
        $this->transformers->pipe($transformer);
        return $this;
    }

    /**
     * @param ExtractorInterface $extractor
     * @return Builder
     */
    public function extract(ExtractorInterface $extractor): self
    {
        $this->extractor = $extractor;
        return $this;
    }

    /**
     * @param EventDispatcherInterface $dispatcher
     * @return Builder
     */
    public function dispatch(EventDispatcherInterface $dispatcher): self
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    /**
     * @param ProcessorInterface $processor
     * @return ProcessorInterface
     */
    public function build(ProcessorInterface $processor): ProcessorInterface
    {
        return $processor
            ->setExtractor($this->extractor)
            ->setTransformers($this->transformers)
            ->setLoader($this->loader)
            ->setDispatcher($this->dispatcher);
    }
}
