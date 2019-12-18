<?php

namespace PerfectOblivion\ActionServiceResponder\Tests\Responders;

use Orchestra\Testbench\Http\Middleware\VerifyCsrfToken;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Requests\CustomRequest;
use PerfectOblivion\ActionServiceResponder\Tests\TestCase;

class ResponderTest extends TestCase
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
    function a_responder_can_return_a_response_via_the_respond_method()
    {
        $response = $this->withExceptionHandling()
                        ->get('/simple-action-with-responder-via-respond');

        $response->assertStatus(200);
        $response->assertSee('hello');
    }

    /** @test */
    function a_responder_can_return_a_response_via_the_responsable_interface()
    {
        $response = $this->withExceptionHandling()
                        ->get('/simple-action-with-responder-via-responsable');

        $response->assertStatus(200);
        $response->assertSee('hello');
    }

    /** @test */
    function a_payload_can_be_passed_to_the_responder()
    {
        $response = $this->withExceptionHandling()
                        ->get('/simple-action-with-responder-payload');

        $response->assertStatus(200);
        $response->assertSee('hello');
    }

    /** @test */
    function a_custom_request_can_be_passed_to_the_responder()
    {
        $response = $this->withExceptionHandling()
                        ->get('/simple-action-with-responder-custom-request');

        $response->assertStatus(200);
        $response->assertSee(CustomRequest::class);
    }

    /** @test */
    function a_service_object_can_be_passed_as_a_payload_to_the_responder()
    {
        $response = $this->withExceptionHandling()
                        ->json('post', '/action-with-service-object-responder-payload', ['name' => 'Clayton Stone']);

        $response->assertStatus(200);
        $response->assertJson(['name' => 'Clayton Stone']);
    }
}
