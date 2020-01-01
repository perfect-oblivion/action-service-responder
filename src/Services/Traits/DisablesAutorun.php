<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Traits;

use Illuminate\Container\Container;
use PerfectOblivion\ActionServiceResponder\Services\Service;

trait DisablesAutorun
{
    /**
     * Temporarily disable the service autorun.
     */
    private function disableAutorun(): void
    {
        Container::getInstance()->resolving(Service::class, function ($service, $app) {
            $service->autorunIfEnabled = false;
        });
    }
}
