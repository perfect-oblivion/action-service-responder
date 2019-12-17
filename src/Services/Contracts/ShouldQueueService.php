<?php

namespace PerfectOblivion\ActionServiceResponder\Services\Contracts;

interface ShouldQueueService
{
    /**
     * Automatically queue the service
     */
    public function autoQueue(): void;
}
