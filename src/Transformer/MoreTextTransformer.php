<?php

namespace ETL\Transformer;

use ETL\Context;

class MoreTextTransformer extends AbstractTransformer
{
    public function transform(Context $context): Context
    {
        return $context->transform([$this, 'more'], $this->attributes);
    }

    public function more(string $value)
    {
        return $value.'...';
    }
}
