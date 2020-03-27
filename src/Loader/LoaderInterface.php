<?php

namespace ETL\Loader;

use ETL\Collection;

interface LoaderInterface
{
    /**
     * Loads the data into the storage (database, array..)
     *
     * @param Collection $context The data context to load
     * @return mixed
     *
     * @todo Update load method to return an iterator for the data. It must
     * return an array for each row
     */
    public function load(Collection $context);
}
