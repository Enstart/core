<?php namespace Enstart\Controller;

use Enstart\Container\ContainerInterface;
use Enstart\Exception\UnknownPropertyException;

class Controller
{
    protected static $container = [];

    public static function setContainer(ContainerInterface $container)
    {
        static::$container = $container;
    }

    public function __get($property)
    {
        if (!static::$container->isAlias($property)) {
            throw new UnknownPropertyException("Unknown property '$property'");
        }

        return static::$container->make($property);
    }

    public function __call($method, array $args)
    {
        $app = static::$container->make('Enstart\App');
        return call_user_func_array([$app, $method], $args);
    }
}
