<?php

use Illuminate\Support\Facades\Route;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\AutorunServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\NoAutorunServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\ServiceObjectResponderPayloadAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\ServiceWithSupplementalParametersAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleResponderAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleResponderWithCustomRequestAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleResponsableResponderAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleResponsableResponderWithPayloadAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleServiceAction;
use PerfectOblivion\ActionServiceResponder\Tests\Foundation\Actions\SimpleServiceActionServiceCaller;

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
Route::post('/service-with-supplemental-parameters/user/{user}', ServiceWithSupplementalParametersAction::class);
