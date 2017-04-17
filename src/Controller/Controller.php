<?php namespace Enstart\Controller;

use Enstart\Container\ContainerInterface;
use Enstart\Exception\UnknownPropertyException;

class Controller
{
    /**
     * @var ContainerInterface
     */
    protected static $container = [];

    /**
     * @param ContainerInterface $container
     */
    public static function setContainer(ContainerInterface $container)
    {
        static::$container = $container;
    }

    /**
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (!static::$container->isAlias($property)) {
            throw new UnknownPropertyException("Unknown property '$property'");
        }

        return static::$container->make($property);
    }

    /**
     * Call a method on the main App instance
     *
     * @param  string $method
     * @param  array  $args
     * @return mixed
     */
    public function __call($method, array $args)
    {
        $app = static::$container->make('Enstart\App');
        return call_user_func_array([$app, $method], $args);
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
    protected function routeRedirect($name, array $args = [], $code = 302, array $headers = [])
    {
        return $this->response->redirect(
            $this->router->getRoute($name, $args),
            $code,
            $headers
        );
    }
}
