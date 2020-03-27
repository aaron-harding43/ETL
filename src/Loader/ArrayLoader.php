<?php

namespace ETL\Loader;

use ETL\Collection;

class ArrayLoader implements LoaderInterface
{
    /**
     * @param Collection $context Collection of context objects to load into storage
     *
     * @return \Iterator
     */
    public function load(Collection $data)
    {
        return $data->getIterator();
    }
}

