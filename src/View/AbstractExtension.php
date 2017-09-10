<?php namespace Enstart\View;

use Enstart\App;
use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

abstract class AbstractExtension implements ExtensionInterface
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var RouterInterface
     */
    protected $app;

    /**
     * Functions to register
     * @var array
     */
    protected $functions = [];

    /**
     * @param Enstart\App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Register the extension
     *
     * @param  Engine $engine
     */
    public function register(Engine $engine)
    {
        $this->engine = $engine;

        foreach ($this->functions as $func) {
            $engine->registerFunction($func, [$this, $func]);
        }
    }
}
