<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class GenerateActionTest extends TestCase
{
    /**
     * @test
     *
     * The asr:action command will generate a new action in the
     * configured namespace from the provided Action stub.
     */
    function the_action_command_creates_an_action_from_stub()
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
