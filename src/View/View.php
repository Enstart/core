<?php namespace Enstart\View;

use League\Plates\Engine;

class View implements ViewInterface
{
    protected $engine;

    /**
     * Create new Engine instance.
     *
     * @param string $directory
     * @param string $fileExtension
     */
    public function __construct($directory = null, $fileExtension = 'php')
    {
        $this->engine = new Engine($directory, $fileExtension);
    }

   /**
     * Set path to templates directory.
     *
     * @param  string|null $directory Pass null to disable the default directory.
     * @return Engine
     */
    public function setDirectory($directory)
    {
        $this->engine->setDirectory($directory);
        return $this;
    }

    /**
     * Get path to templates directory.
     * @return string
     */
    public function getDirectory()
    {
        return $this->engine->getDirectory();
    }

    /**
     * Set the template file extension.
     *
     * @param  string|null $fileExtension Pass null to manually set it.
     * @return Engine
     */
    public function setFileExtension($fileExtension)
    {
        $this->engine->setFileExtension($fileExtension);
        return $this;
    }

    /**
     * Add a new template folder for grouping templates under different namespaces.
     *
     * @param  string  $name
     * @param  string  $directory
     * @param  boolean $fallback
     * @return Engine
     */
    public function addFolder($name, $directory, $fallback = false)
    {
        $this->engine->addFolder($name, $directory, $fallback);
        return $this;
    }

    /**
     * Remove a template folder.
     *
     * @param  string $name
     * @return Engine
     */
    public function removeFolder($name)
    {
        $this->engine->removeFolder($name);
        return $this;
    }

    /**
     * Get collection of all template folders.
     *
     * @return Folders
     */
    public function getFolders()
    {
        return $this->engine->getFolders();
    }

    /**
     * Add preassigned template data.
     *
     * @param  array             $data;
     * @param  null|string|array $templates;
     * @return Engine
     */
    public function addData(array $data, $templates = null)
    {
        $this->engine->addData($data, $template);
        return $this;
    }

    /**
     * Get all preassigned template data.
     *
     * @param  null|string $template;
     * @return array
     */
    public function getData($template = null)
    {
        return $this->engine->getData($template);
    }

    /**
     * Register a new template function.
     *
     * @param  string   $name;
     * @param  callback $callback;
     * @return Engine
     */
    public function registerFunction($name, $callback)
    {
        $this->engine->registerFunction($name, $callback);
        return $this;
    }

    /**
     * Check if a template function exists.
     *
     * @param  string  $name
     * @return boolean
     */
    public function doesFunctionExist($name)
    {
        return $this->engine->doesFunctionExist();
    }

    /**
     * Load an extension.
     *
     * @param  ExtensionInterface $extension
     * @return Engine
     */
    public function loadExtension($extension)
    {
        $this->engine->loadExtension($extension);
        return $this;
    }

    /**
     * Load multiple extensions.
     *
     * @param  array  $extensions
     * @return Engine
     */
    public function loadExtensions(array $extensions = array())
    {
        $this->engine->loadExtensions($extensions);
        return $this;
    }

    /**
     * Get a template path.
     *
     * @param  string $name
     * @return string
     */
    public function path($name)
    {
        return $this->engine->path($name);
    }

    /**
     * Check if a template exists.
     *
     * @param  string  $name
     * @return boolean
     */
    public function exists($name)
    {
        return $this->engine->exists($name);
    }

    /**
     * Create a new template.
     *
     * @param  string   $name
     * @return Template
     */
    public function make($name)
    {
        return $this->engine->make($name);
    }

    /**
     * Create a new template and render it.
     *
     * @param  string $name
     * @param  array  $data
     * @return string
     */
    public function render($name, array $data = array())
    {
        return $this->engine->render($name, $data);
    }

    /**
     * Get the main template engine instance
     *
     * @return Engine
     */
    public function getInstance()
    {
        return $this->engine;
    }
}
