<?php

namespace ETL;

class Pipeline
{
    /**
     * @var array Stages in the pipeline
     */
    protected $stages = [];

    /**
     * Adds stages to a pipeline to run in sequential order
     *
     * @param callable $callback
     * @return $this
     */
    public function pipe(callable $callback) : Pipeline
    {
        $this->stages[] = $callback;
        return $this;
    }

    /**
     * Process the context through the stages of the pipeline
     *
     * @param $context mixed Data context being passed through the pipeline stages
     * @return mixed
     */
    public function process($context)
    {
        foreach ($this->stages as $stage) {
            $context = $stage($context);
        }

        return $context;
    }
}
