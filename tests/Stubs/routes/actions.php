<?php

use Illuminate\Support\Facades\Route;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\AutorunServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\NoAutorunServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\ServiceObjectResponderPayloadAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleResponderAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleResponderWithCustomRequestAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleResponsableResponderAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleResponsableResponderWithPayloadAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Stubs\Actions\SimpleServiceActionServiceCaller;

Route::get('/simple-action', SimpleAction::class);
Route::post('/simple-service-action', SimpleServiceAction::class);
Route::post('/simple-service-action-service-caller', SimpleServiceActionServiceCaller::class);
Route::post('/autorun-service-action', AutorunServiceAction::class);
Route::post('/no-autorun-service-action', NoAutorunServiceAction::class);
Route::get('/simple-action-with-responder-via-respond', SimpleResponderAction::class);
Route::get('/simple-action-with-responder-via-responsable', SimpleResponsableResponderAction::class);
Route::get('/simple-action-with-responder-payload', SimpleResponsableResponderWithPayloadAction::class);
Route::get('/simple-action-with-responder-custom-request', SimpleResponderWithCustomRequestAction::class);
Route::post('/action-with-service-object-responder-payload', ServiceObjectResponderPayloadAction::class);
