<?php

namespace PhpSpreadsheet\Collection;

use PhpSpreadsheet\Settings;
use PhpSpreadsheet\Worksheet\Worksheet;

abstract class CellsFactory
{
    /**
     * Initialise the cache storage.
     *
     * @param Worksheet $parent Enable cell caching for this worksheet
     *
     * @return Cells
     * */
    public static function getInstance(Worksheet $parent)
    {
        return new Cells($parent, Settings::getCache());
    }
}
