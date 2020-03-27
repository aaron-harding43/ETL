<?php

namespace ETL\Event;

use ETL\Processor\ProcessorInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use ETL\Event\Traits\StoppableTrait;

abstract class AbstractEvent implements StoppableEventInterface
{
    use StoppableTrait;

    /**
     * @var ProcessorInterface Processor for the ETL pipeline
     */
    public ProcessorInterface $processor;

    /**
     * AbstractEvent constructor.
     *
     * @param ProcessorInterface $processor The processor instance
     */
    public function __construct(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }
}
