<?php namespace Enstart\View;

use Enstart\Router\RouterInterface;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use League\Plates\Extension\URI;

class ViewExtension implements ExtensionInterface
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Register the extension
     *
     * @param  Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;

        $this->engine->loadExtension(new URI($this->router->getRequestPath()));
        $engine->registerFunction('route', [$this, 'route']);
    }

    /**
     * Resolve a route
     *
     * @param  string $name
     * @param  array  $args
     * @return string
     */
    public function route($name, array $args = [])
    {
        return $this->router->getRoute($name, $args);
    }
}