<?php

namespace ETL\Event\Traits;

trait StoppableTrait
{
    /**
     * @var bool Indicates if the event should continue
     */
    protected $propagate = true;

    /**
     * Stops the event from propagating to the next listeners
     */
    public function stopPropagation() : void
    {
        $this->propagate = false;
    }

    /**
     * @return bool Returns true if the event should stop propagation
     */
    public function isPropagationStopped(): bool
    {
        return !$this->propagate;
    }
}
