# Perfect Oblivion - ActionServiceResponder
### An Actions/Service/Responder implementation for Laravel.

[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Latest Stable Version](https://poser.pugx.org/perfect-oblivion/action-service-responder/v/stable)](https://github.com/perfect-oblivion/action-service-responder)
[![Unit Tests](https://github.com/perfect-oblivion/action-service-responder/workflows/Tests%20(PHP)/badge.svg)](https://github.com/perfect-oblivion/action-service-responder)
[![composer.lock](https://poser.pugx.org/perfect-oblivion/action-service-responder/composerlock)](https://github.com/perfect-oblivion/action-service-responder)

![Perfect Oblivion](https://res.cloudinary.com/phpstage/image/upload/v1554128207/img/Oblivion.png "Perfect Oblivion")

### Disclaimer
The packages under the PerfectOblivion namespace are basically a way for me to avoid copy/pasting simple functionality that I like in all of my projects. There's nothing groundbreaking here, just a little extra functionality for form requests, controllers, custom rules, services, etc.

The general idea for this package is based on [ADR - Action Domain Responder](http://paul-m-jones.com/archives/5970), by [Paul M. Jones](https://twitter.com/pmjones).

There are 3 basic components of this pattern.
- Actions: more commonly called Controllers throughout the PHP ecosystem
- Services: handle calculation and logic specific to your domain
- Responders: responsible for handing data back to the consumer

## Installation
You can install the package via composer. From your project directory, in your terminal, enter:
```bash
composer require perfect-oblivion/action-service-responder
```

The ServiceProvider will be automtically detected and registered.
If you have this functionality disabled, you may manually add the package service provider to your config/app.php file, in the 'providers' array:
```php
'providers' => [
    //...
    PerfectOblivion\ActionServiceResponder\ActionServiceResponderProvider::class,
    //...
];
```

## Configuration
The package comes with some default settings configured. If you would like to tweak these settings, such as namespaces, command names, etc., run the command below in your terminal.

```bash
php artisan vendor:publish --provider="PerfectOblivion\ActionServiceResponder\ActionServiceResponderProvider"
```

This will copy the ```asr.php``` configuration file to your app's config folder.

## Usage
In my opinion, the benefits of ASR has over traditional MVC, is clarity, narrow class responsibility, fewer dependencies, and overall organization.

In my example-case below, I'll use all three components(Action, Service and Responder) along with the service validator. If you prefer, you can choose to mix and match, using only the components you need.

 ### CASE: USER SUBMITS A COMMENT TO A MESSAGE BOARD
 

 ### Routes

 ```php
 <?php
// web.php

Route::post('comment', Comment\StoreComment::class)->name('comment.store');
 ```
 > Inside my RouteServiceProvider, I have set my route namespace to 'App\Http\Actions'.
 

 ### Actions

 To generate an action, you may use the provided artisan command:

```sh
php artisan asr:action Comment\\StoreComment
```
An Action will be generated at *App\Http\Actions\Comment\StoreComment*.

I've edited the action to show how I would set this it up for our Comment example.

```php
<?php

namespace App\Http\Actions;

use App\Http\ActionServiceResponder\Actions\Action;
use App\Http\Responders\Comment\StoreCommentResponder;
use App\Models\Post;
use App\Services\Comment\StoreCommentService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class StoreComment extends Action
{
    /**
     * The Responder.
     *
     * @var \App\Http\Responders\Comment\StoreCommentResponder
     */
    private $responder;

    /**
     * Construct a new StoreComment action.
     *
     * @param  \App\Http\Responders\Comment\StoreCommentResponder  $responder
     */
    public function __construct(StoreCommentResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Store a new comment from the request for the given post.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request): Response
    {
        $data = StoreCommentService::call($request->only(['body']));

        return $this->responder->withPayload($data)->respond();
    }
}
```

Very often, this is as complex as your actions (controllers) will need to be. 

1. The action receives the request.
2. The data from the request is passed to the appropriate service.
3. The return value of the Service call is given to the responder to handle as it sees fit.

> Validation can be handled within the service's validator, which we will show in a moment([see Service Validators](#service-validators)). If you prefer not to use the service's validation, there's nothing stopping you from validating in your controller or using Laravel's form requests.


### Services

 To generate a service, you may use the provided artisan command:

```sh
php artisan asr:service Comment\\StoreCommentService
```
A Service will be generated at *App\Services\Comment\StoreCommentService*.

I've edited the service to show how I would set this it up for our Comment example.

```php
<?php

namespace App\Services\Comment;

use PerfectOblivion\ActionServiceResponder\Services\Contracts\Service;
use PerfectOblivion\ActionServiceResponder\Services\Traits\SelfCallingService;

class StoreCommentService extends Service
{
    use SelfCallingService;

    public $validator;

    /**
     * Construct a new StoreCommentService.
     */
    public function __construct(StoreCommentValidationService $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function run(array $parameters)
    {
        return $this->doSomeWork($this->data); // see notes below
    }
}
```

1. A validator is injected via the service's constructor. The validator will run automatically, and the validated data will be available via the service's ```data``` property. 

> If you need to manually run the validator, you'll need to instantiate your service and call the ```run``` method directly. See [Alternative ways to call services](#alternative-ways-to-call-services)
> If validation fails, it will perform as Laravel's form requests do and throw an exception, which by default will redirect and inject the validation errors in the $errors object that is available in the view. In the case of an ajax request, a 422 will be returned along with the validation errors in a json object. This functionality can be customized in the same manner as form requests.

2. Any dependencies required by the Service may be injected via the Service constructor.
3. The parameters from the Service call are passed to the ```run``` method. Within this method, you may work with those passed parameters or, if validation is used, you'll have access to the validated data via the Service's ```$data``` property.


### Service Validators

```sh
php artisan asr:validation Comment\\StoreCommentValidationService
```
> The default suffix for validators is "ValidationService". If you prefer another suffix or no suffix at all, a suffix configuration is available.

**Responder**

Finally, the responder will handle sending the response. If data needs to be sent to the responder, you may use the ```withPayload``` method.  Responders implement Laravel's Responsable interface, so you may return the Responder directly without calling ```respond``` if you prefer. Also, the Responder has access to the current request through the $request property. If you need to pass a custom request to the Responder, eg. a custom FormRequest class, you may use the ```withRequest``` method.
```php
// StoreComment.php
public function __invoke(MyCustomRequest $request)
{
    $data = StoreCommentService::call($request->all());

    return $this->responder->withPayload($data)->withRequest($request)->respond();
}
```

```php
\\App\Http\Responders\Comment\StoreCommentResponder

<?php

namespace App\Http\Responders;

use PerfectOblivion\ActionServiceResponder\Responders\Responder;

class StoreCommentResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return response()->json(['comment' => $this->payload], 201);
    }
}
```

### Queued Services
Services may also be queued. In order to do this, you have a couple of options:
- The service may implement the ShouldQueueService interface.
- Instead of using the ```call``` method from your controller, you may use the ```queue``` method.

|Note on queued services|
|-----------------------|
|(1) Data will not be returned to the controller form a queued service<br>(2) If you need to customize the queue name, connection name, or delay, use public properties on the Service class


## Taking it further with automation
> Automatic services are still experimental.

### When to use automatically run services
- If you are in the context of an http request
- If your service is expecting the current request's parameters
- If there is a result returned from your service.

> If the service has a validator defined, the data will be validated before running the service logic.

> If you use the autorun functionality and do not use the action's service parameter inside the action(eg. when queueing your service), your IDE will likely yell at you (see example below). I would only use 'autorun' if you are expecting a return value from the service. Also, If you choose to use autorun when queueing your service, be sure the service implements the ShouldQueueService interface.

> When running the asr:action command, add the --auto-service option to have the Service added to your scaffolded Action class.

```php
// StoreComment.php
public function __invoke(StoreCommentService $service, Request $request)
{
    return view('comments.index'); //because we're not using the $service parameter in the method body, your IDE will notify you that $service is unused.
}
```

### How To
  - In your package configuration, set 'service_autorun' to true (default).
  - Typehint the service on your controller method.
  - If the service has a return value, it can be accessed via the $result property of the service.

```php
// StorePost.php

//...

public function __invoke(StorePostService $service, Request $request)
{
    // the result of the service is available as $service->result.
    dump($service->result);

    //If using Responders and an autorun Service, you may pass the $service object to the responder via the 'withPayloadFrom' method. The responder knows to retrieve the $result property.
    return $this->responder->withPayloadFrom($service)->respond();
}
```

### Alternative ways to call services
In addition to the methods discussed above, you may call services by:
1. Using the "CallsServices" trait in your controller:
  ```$this->call(MyService::class, $params);```
2. Inject the ServiceCaller in your controller:
  ```$this->caller->call(MyService::class, $params);```
3. Inject the service via constructor injection, then call the "run" method directly:
  ```$this->service->run($params);```

> If you choose to inject the service via constructor injection, you will need to set a public property($autorunIfEnabled = false) on your service.
> If you don't plan to use 'autorun' for any of your services, you may set the package configuration option 'service_autorun' to false.

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email clay@phpstage.com instead of using the issue tracker.

## Credits

- [Clayton Stone](https://github.com/devcircus)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
