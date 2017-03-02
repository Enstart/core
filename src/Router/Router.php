<?php namespace Enstart\Router;

use Enstart\Container\ContainerInterface;
use Maer\Router\Router as MaerRouter;

class Router extends MaerRouter implements RouterInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->resolver(function ($callback) use ($container) {
            $callback[0] = $container->make($callback[0]);
            return $callback;
        });
    }


    /**
     * Add a GET route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function get($pattern, $callback, array $params = [])
    {
        return $this->add('GET', $pattern, $callback, $params);
    }

    /**
     * Add a POST route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function post($pattern, $callback, array $params = [])
    {
        return $this->add('POST', $pattern, $callback, $params);
    }

    /**
     * Add a PUT route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function put($pattern, $callback, array $params = [])
    {
        return $this->add('PUT', $pattern, $callback, $params);
    }

    /**
     * Add a DELETE route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function delete($pattern, $callback, array $params = [])
    {
        return $this->add('DELETE', $pattern, $callback, $params);
    }

    /**
     * Add a PATCH route
     *
     * @param  string $pattern
     * @param  mixed  $callback
     * @param  array  $params
     *
     * @return $this
     */
    public function patch($pattern, $callback, array $params = [])
    {
        return $this->add('PATCH', $pattern, $callback, $params);
    }
}
