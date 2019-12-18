<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateActionTest extends TestCase
{
    /** @test */
    function the_action_command_creates_an_action()
    {
        $action = app_path($this->paths['action'].'/'.'User/StoreUser.php');

        if (File::exists($action)) {
            unlink($action);
        }

        $this->assertFalse(File::exists($action));

        Artisan::call('asr:action User\\\StoreUser');

        $this->assertTrue(File::exists($action));
    }
}