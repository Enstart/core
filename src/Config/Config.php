<?php namespace Enstart\Config;

use Maer\Config\Config as MaerConfig;

class Config extends MaerConfig implements ConfigInterface
{
    /**
     * Merge an array to the config
     *
     * @param  array    $values
     * @return void
     */
    public function add(array $values)
    {
        $this->override($values);
    }
}