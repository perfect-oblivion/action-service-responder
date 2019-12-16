<?php

namespace PerfectOblivion\ActionServiceResponder\Actions;

use BadMethodCallException;

class Action
{
    /** @var array */
    protected $middleware = [];

    /**
     * Register middleware on the action.
     *
     * @param  array|string|\Closure  $middleware
     * @param  array   $options
     *
     * @return \PerfectOblivion\ActionServiceResponder\ActionMiddlewareOptions
     */
    public function middleware($middleware, array $options = [])
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
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * Execute an action on the action.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the action.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @throws \BadMethodCallException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
