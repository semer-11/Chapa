<?php

namespace Semernur\Chapa;

use Illuminate\Support\Facades\Facade;


class ChapaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'chapa';
    }
}
