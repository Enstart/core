<?php namespace Enstart\ServiceProvider;

use Enstart\Container\ContainerInterface;
use Enstart\Controller\Controller;
use Enstart\View\View;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ContainerInterface $c)
    {
        // Register the container to itself
        $c->singleton('Enstart\Container\ContainerInterface', function ($c) {
            return $c;
        });
        $c->alias('Enstart\Container\ContainerInterface', 'container');

        // Router
        $c->singleton('Enstart\Router\RouterInterface', function ($c) {
            $router = $c->make('Enstart\Router\Router');
            // Set default not found and method not allowed handlers
            $router->notFound(function () use ($c) {
                return $c->response->make('404 - Page not found', 404);
            });
            $router->methodNotAllowed(function () use ($c) {
                return $c->response->make('405 - Method not allowed', 405);
            });
            return $router;
        });
        $c->alias('Enstart\Router\RouterInterface', 'router');

        // Http
        $c->singleton('Enstart\Http\RequestInterface', function () {
            return new \Enstart\Http\Request(
                \Symfony\Component\HttpFoundation\Request::createFromGlobals()
            );
        });
        $c->alias('Enstart\Http\RequestInterface', 'request');

        $c->singleton('Enstart\Http\ResponseInterface', 'Enstart\Http\Response');
        $c->alias('Enstart\Http\ResponseInterface', 'response');

        $c->singleton('Enstart\Http\SessionInterface', 'Enstart\Http\Session');
        $c->alias('Enstart\Http\SessionInterface', 'session');

        // Libraries
        $c->singleton('Enstart\Security\CsrfInterface', 'Enstart\Security\Csrf');
        $c->alias('Enstart\Security\CsrfInterface', 'csrf');

        // Templates
        $c->singleton('Enstart\View\ViewInterface', function ($c) {
            $config = $c->make('Enstart\Config\ConfigInterface');
            $view = new View(
                $config->get('views.path'),
                $config->get('views.extension', 'php')
            );
            $view->loadExtension($c->make('Enstart\View\ViewExtension'));

            $extensions = $c->config->get('views.extensions', []);

            if (is_array($extensions) && $extensions) {
                foreach ($extensions as $ext) {
                    $view->loadExtension($c->make($ext));
                }
            }

            return $view;
        });
        $c->alias('Enstart\View\ViewInterface', 'views');

        $this->setupLogging($c);

        $config = $c->make('Enstart\Config\ConfigInterface');

        if ($config->get('debug', false) === true) {
            $this->setupWhoops($c);
        }

        // Controller
        Controller::setContainer($c);
    }

    /**
     * Set up Monolog
     *
     * @param  ContainerInterface $c
     */
    protected function setupLogging(ContainerInterface $c)
    {
        $config = $c->make('Enstart\Config\ConfigInterface');

        $logLevel = $config->get('logging.level', \Monolog\Logger::ERROR);
        $logLevel = \Monolog\Logger::toMonologLevel($logLevel);
        $filename = $config->get('logging.file', 'app.log');

        // create a log channel
        $log = new \Monolog\Logger($config->get('logging.name', 'enstart'));

        if ($filename) {
            $log->pushHandler(new \Monolog\Handler\StreamHandler($filename, $logLevel));
        }

        if ($config->get('debug', false) !== true) {
            // Log all exceptions etc.
            $handler = new \Monolog\ErrorHandler($log);
            $handler->registerErrorHandler([], false);
            $handler->registerExceptionHandler();
            $handler->registerFatalHandler();
        }

        $c->singleton('Psr\Log\LoggerInterface', function ($c) use ($log) {
            return $log;
        });
        $c->alias('Psr\Log\LoggerInterface', 'log');
    }

    /**
     * Set up Whoops
     *
     * @param  ContainerInterface $c
     */
    protected function setupWhoops(ContainerInterface $c)
    {
        $whoops = new \Whoops\Run;
        $logger = $c->make('Psr\Log\LoggerInterface');

        $whoops->pushHandler(new \Whoops\Handler\PlainTextHandler($logger));
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler($logger));

        $whoops->register();

        $c->singleton('Whoops\Run', function () use ($whoops) {
            return $whoops;
        });
    }
}
