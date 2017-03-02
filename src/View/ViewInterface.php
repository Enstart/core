<?php namespace Enstart\View;

interface ViewInterface
{
   /**
     * Set path to templates directory.
     *
     * @param  string|null $directory Pass null to disable the default directory.
     * @return Engine
     */
    public function setDirectory($directory);

    /**
     * Get path to templates directory.
     * @return string
     */
    public function getDirectory();

    /**
     * Set the template file extension.
     *
     * @param  string|null $fileExtension Pass null to manually set it.
     * @return Engine
     */
    public function setFileExtension($fileExtension);

    /**
     * Add a new template folder for grouping templates under different namespaces.
     *
     * @param  string  $name
     * @param  string  $directory
     * @param  boolean $fallback
     * @return Engine
     */
    public function addFolder($name, $directory, $fallback = false);

    /**
     * Remove a template folder.
     *
     * @param  string $name
     * @return Engine
     */
    public function removeFolder($name);

    /**
     * Get collection of all template folders.
     *
     * @return Folders
     */
    public function getFolders();

    /**
     * Add preassigned template data.
     *
     * @param  array             $data;
     * @param  null|string|array $templates;
     * @return Engine
     */
    public function addData(array $data, $templates = null);

    /**
     * Get all preassigned template data.
     *
     * @param  null|string $template;
     * @return array
     */
    public function getData($template = null);

    /**
     * Register a new template function.
     *
     * @param  string   $name;
     * @param  callback $callback;
     * @return Engine
     */
    public function registerFunction($name, $callback);

    /**
     * Check if a template function exists.
     *
     * @param  string  $name
     * @return boolean
     */
    public function doesFunctionExist($name);

    /**
     * Load an extension.
     *
     * @param  ExtensionInterface $extension
     * @return Engine
     */
    public function loadExtension($extension);

    /**
     * Load multiple extensions.
     *
     * @param  array  $extensions
     * @return Engine
     */
    public function loadExtensions(array $extensions = array());

    /**
     * Get a template path.
     *
     * @param  string $name
     * @return string
     */
    public function path($name);

    /**
     * Check if a template exists.
     *
     * @param  string  $name
     * @return boolean
     */
    public function exists($name);

    /**
     * Create a new template.
     *
     * @param  string   $name
     * @return Template
     */
    public function make($name);

    /**
     * Create a new template and render it.
     *
     * @param  string $name
     * @param  array  $data
     * @return string
     */
    public function render($name, array $data = array());

    /**
     * Get the main template engine instance
     *
     * @return Engine
     */
    public function getInstance();
}
