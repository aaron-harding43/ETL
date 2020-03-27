<?php

namespace ETL\Processor;

use ETL\Event;
use ETL\Collection;

class SimpleProcessor extends AbstractProcessor
{
    public function run()
    {
        $this->collection = new Collection;

        // Dispatch event before the process starts
        $this->dispatcher->dispatch(new Event\ProcessStart($this));

        // Transform any items in collection
        foreach ($this->collection as $key => $context) {
            $this->collection[$key] = $this->transformers->process($context);
        }

        // Extractor each row and apply through transformers
        foreach ($this->extractor->extract() as $context) {
            $this->collection->add($this->transformers->process($context));
        }

        $data = $this->loader->load($this->collection);

        // Dispatch event before the process finishes
        $this->dispatcher->dispatch(new Event\ProcessEnd($this));

        return $data;
    }
}
