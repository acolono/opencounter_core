<?php

namespace OpenCounter\Application\Service\Counter;

/**
 * Interface ApplicationService
 */
interface ApplicationService
{
    /**
     * @param $request
     * @return mixed
     */
    public function execute($request = null);
}