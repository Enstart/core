<?php namespace Enstart\ServiceProvider;

use Enstart\Container\ContainerInterface;

interface ServiceProviderInterface
{
    /**
     * Register classes to the container
     *
     * @param  ContainerInterface $container
     * @return $this
     */
    public function register(ContainerInterface $container);
}
