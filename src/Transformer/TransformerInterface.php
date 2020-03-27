<?php

namespace ETL\Transformer;

use ETL\Context;

interface TransformerInterface
{
    /**
     * @param Context $context The context for the transformer
     * @return Context
     */
    public function transform(Context $context): Context;

    /**
     * @param $context Context
     * @return Context
     */
    public function __invoke(Context $context): Context;
}
