<?php namespace Enstart;

use Enstart\Container\Container;
use Enstart\Container\ContainerInterface;
use Enstart\serviceProvider\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Response;

class App
{
    /**
     * @var Enstart\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var Enstart\Router\RouterInterface
     */
    protected $router;

    /**
     * @var array
     */
    protected $providers;

    /**
     * Registered app paths
     *
     * @var array
     */
    protected $paths = [];

    /**
     * @param ContainerInterface|null $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        if (is_null($container)) {
            $this->container = new Container;
        }

        // Register the container to itself
        $this->container->singleton('Enstart\Container\ContainerInterface', function ($c) {
            return $c;
        });
        $this->container->alias('Enstart\Container\ContainerInterface', 'container');

        // Register the app to the container
        $this->container->singleton('Enstart\App', function () {
            return $this;
        });

        // Create the config class
        $this->container->singleton('Enstart\Config\ConfigInterface', 'Enstart\Config\Config');
        $this->container->alias('Enstart\Config\ConfigInterface', 'config');
    }

    /**
     * Add one or more paths
     *
     * @param string|array $name
     * @param string       $value
     */
    public function addPath($name, $value = null)
    {
        if (is_array($name)) {
            $this->paths = array_merge($this->paths, $name);
            return $this;
        }

        $this->paths[$name] = $value;
        return $this;
    }

    /**
     * Get a path
     *
     * @param  string $name
     * @param  mixed  $fallback
     *
     * @return $this
     */
    public function path($name, $fallback = null)
    {
        return array_key_exists($name, $this->paths)
            ? $this->paths[$name]
            : $fallback;
    }

    /**
     * Register a service provider
     *
     * @param  string $provider Full qualified class name
     *
     * @return $this
     */
    public function serviceProvider($provider)
    {
        $class = $this->container->make($provider);
        if (!$class instanceof ServiceProviderInterface) {
            throw new \Exception("Service providers must implement Enstart\ServiceProvider\ServiceProviderInterface");
        }

        $class->register($this->container);
        $this->providers[trim($provider, '\\')] = $class;

        return $this;
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
        return $this->getRouter()->add('GET', $pattern, $callback, $params);
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
        return $this->getRouter()->add('POST', $pattern, $callback, $params);
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
        return $this->getRouter()->add('PUT', $pattern, $callback, $params);
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
        return $this->getRouter()->add('DELETE', $pattern, $callback, $params);
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
        return $this->getRouter()->add('PATCH', $pattern, $callback, $params);
    }

    /**
     * Create a new JsonResponseEntity instance
     *
     * @param boolean $success
     * @param mixed   $data
     * @param integer $code
     * @param array   $errors
     * @param string  $message
     *
     * @return Enstart\Entity\JsonResponseEntity
     */
    public function makeJsonEntity($success = true, $data = null, $code = 200, array $errors = [], $message = null)
    {
        return new Entity\JsonResponseEntity($success, $data, $code, $errors, $message);
    }

    /**
     * Redirect to a named route
     *
     * @param  string  $name
     * @param  string  $args  Route arguments
     * @param  integer $code
     * @param  array   $headers
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function routeRedirect($name, array $args = [], $code = 302, array $headers = [])
    {
        $response = $this->container->make('Enstart\Http\ResponseInterface');
        $router   = $this->container->make('Enstart\Router\RouterInterface');

        return $response->redirect(
            $router->getRoute($name, $args),
            $code,
            $headers
        );
    }

    /**
     * Start the app and dispatch the router
     *
     * @param  string $method
     * @param  string $uri
     */
    public function start($method = null, $uri = null)
    {
        $response = $this->getRouter()->dispatch($method, $uri);

        if (!$response instanceof Response) {
            $response = new Response($response);
        }

        $response->send();
    }

    /**
     * Get an alias from the container
     *
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        if ('container' == $property) {
            return $this->container;
        }

        return $this->container->make($property);
    }

    /**
     * Get the router instance
     *
     * @return Enstart\Router\RouterInterface
     */
    protected function getRouter()
    {
        if (!$this->router) {
            $this->router = $this->container->make('Enstart\Router\RouterInterface');
        }

        return $this->router;
    }
}
