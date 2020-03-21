<?php

namespace PerfectOblivion\ActionServiceResponder\Actions;

use BadMethodCallException;
use PerfectOblivion\ActionServiceResponder\Actions\ActionMiddlewareOptions;
use Symfony\Component\HttpFoundation\Response;

class Action
{
    protected array $middleware = [];

    /**
     * Register middleware on the action.
     *
     * @param  array|string|\Closure  $middleware
     * @param  array   $options
     */
    public function middleware($middleware, array $options = []): ActionMiddlewareOptions
    {
        foreach ((array) $middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }

        return new ActionMiddlewareOptions($options);
    }

    /**
     * Get the middleware assigned to the action.
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * Execute an action on the action.
     *
     * @param  string  $method
     * @param  array  $parameters
     */
    public function callAction(string $method, array $parameters): Response
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the action.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
