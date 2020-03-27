<?php

namespace ETL\Transformer;

use ETL\Context;

abstract class AbstractTransformer implements TransformerInterface
{
    /**
     * @var array The attributes the transformer will apply to
     */
    protected $attributes = [];

    /**
     * AbstractTransformer constructor.
     *
     * @param array $attributes Attributes the transformer can apply to
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Invokable method for the transformer
     *
     * @param Context $context The context object to apply the transformations to
     *
     * @return Context
     */
    public function __invoke(Context $context): Context
    {
        return $this->transform($context);
    }
}
