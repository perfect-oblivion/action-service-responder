<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateActionTest extends TestCase
{
    /** @test */
    function the_action_command_creates_an_action_from_stub()
    {
        $testStub = str_replace("\r\n", "\n", File::get(__DIR__.'/../stubs/action.stub'));

        $action = app_path($this->paths['action'].'/'.'Sample/ActionSample.php');

        if (File::exists($action)) {
            unlink($action);
        }

        $this->assertFalse(File::exists($action));

        Artisan::call('asr:action Sample\\\ActionSample');

        $this->assertTrue(File::exists($action));
        $this->assertEquals($testStub, str_replace("\r\n", "\n", File::get($action)));
    }
}
