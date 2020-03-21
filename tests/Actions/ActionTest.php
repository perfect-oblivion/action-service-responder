<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Actions;

use Orchestra\Testbench\Http\Middleware\VerifyCsrfToken;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class ActionTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware([VerifyCsrfToken::class]);
    }

    /** @test */
    public function an_action_returns_a_response()
    {
        $response = $this->withExceptionHandling()
                        ->get('/simple-action');

        $response->assertStatus(200);
        $response->assertSee('hello');
    }

    /** @test */
    public function can_run_service_via_service_caller()
    {
        $response = $this->withExceptionHandling()
                        ->json('post', '/simple-service-action-service-caller', ['name' => 'Clayton Stone']);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'Clayton Stone']);
    }

    /** @test */
    public function can_run_service_via_static_call_helper()
    {
        $response = $this->withExceptionHandling()
                        ->json('post', '/simple-service-action', ['name' => 'Clayton Stone']);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'Clayton Stone']);
    }

    /** @test */
    public function can_autorun_a_service_from_an_action()
    {
        $response = $this->withExceptionHandling()
                        ->json('post', '/autorun-service-action', ['name' => 'Clayton Stone']);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'Clayton Stone']);
    }

    /** @test */
    public function can_resolve_and_run_a_service_that_does_not_autorun()
    {
        $response = $this->withExceptionHandling()
                        ->json('post', '/no-autorun-service-action', ['name' => 'Clayton Stone']);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'Clayton Stone']);
    }
}
