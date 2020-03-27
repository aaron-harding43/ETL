<?php

namespace ETL\Transformer;

use ETL\Context;

class UppercaseTransformer extends AbstractTransformer
{
    public function transform(Context $context): Context
    {
        return $context->transform('strtoupper', $this->attributes);
    }
}
