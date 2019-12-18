<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateServiceTest extends TestCase
{
    /** @test */
    function the_service_command_creates_an_service()
    {
        $service = app_path($this->paths['service'].'/'.'User/StoreUserService.php');

        if (File::exists($service)) {
            unlink($service);
        }

        $this->assertFalse(File::exists($service));

        Artisan::call('asr:service User\\\StoreUserService');

        $this->assertTrue(File::exists($service));
    }
}
