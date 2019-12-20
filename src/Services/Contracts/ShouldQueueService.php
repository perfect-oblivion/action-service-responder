<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Contracts;

interface ShouldQueueService
{
    /**
     * Automatically queue the service
     *
     * @param  array  $parameters
     */
    public function autoQueue(array $parameters): void;
}
