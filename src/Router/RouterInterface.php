<?php namespace Enstart\Router;

interface RouterInterface
{
    /**
     * Add a GET route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function get($pattern, $callback, array $params = []);

    /**
     * Add a POST route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function post($pattern, $callback, array $params = []);

    /**
     * Add a PUT route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function put($pattern, $callback, array $params = []);

    /**
     * Add a DELETE route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function delete($pattern, $callback, array $params = []);

    /**
     * Add a PATCH route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function patch($pattern, $callback, array $params = []);

    /**
     * Add a new route
     *
     * @param  string $method
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function add($method, $pattern, $callback, array $params = []);

    /**
     * Create a new route group
     *
     * @param  array  $params
     * @param  mixed  $callback
     *
     * @return $this
     */
    public function group(array $params, $callback);

    /**
     * Get matching route
     *
     * @param  string $method
     * @param  string $path
     *
     * @throws Maer\Router\MethodNotAllowedException If the pattern was found,
     *         but with the wrong HTTP verb
     * @throws Maer\Router\NotFoudException If the pattern was not found
     *
     * @return object
     */
    public function getMatch($method = null, $path = null);

    /**
     * Add a new route filter
     *
     * @param  string $name
     * @param  mixed  $callback
     *
     * @return $this
     */
    public function filter($name, $callback);

    /**
     * Get matching route and dispatch all filters and callbacks
     *
     * @param  string $method
     * @param  string $path
     *
     * @throws Maer\Router\MethodNotAllowedException If the pattern was found,
     *         but with the wrong HTTP verb
     * @throws Maer\Router\NotFoudException If the pattern was not found
     *
     * @return mixed
     */
    public function dispatch($method = null, $path = null);

    /**
     * Get the requested HTTP method
     *
     * @return string
     */
    public function getRequestMethod();

    /**
     * Get the requested URL path
     *
     * @return string
     */
    public function getRequestPath();

    /**
     * Add a callback for not found
     *
     * @param  string|Closire|array $callback
     *
     * @return $this
     */
    public function notFound($callback);

    /**
     * Add a callback for method not allowed
     *
     * @param  string|Closire|array $callback
     *
     * @return $this
     */
    public function methodNotAllowed($callback);

    /**
     * Execute a callback
     *
     * @param  mixed   $cb
     * @param  array   $args
     * @param  boolean $filter Set if the callback is a filter or not
     *
     * @throws Exception If the filter is unknown
     * @throws Exception If the callback isn't in one of the accepted formats
     *
     * @return mixed
     */
    public function executeCallback($cb, array $args = [], $filter = false);

    /**
     * Add a resolver for callbacks of the type: ['Classname', 'method']
     * @param  callable $resolver
     * @return $this
     */
    public function resolver(callable $resolver);

    /**
     * Get the URL of a named route
     *
     * @param  string $name
     * @param  array  $args
     *
     * @throws Exception If there aren't enough arguments for all required parameters
     *
     * @return string
     */
    public function getRoute($name, array $args = []);
}
