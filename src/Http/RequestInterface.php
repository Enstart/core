<?php namespace Enstart\Http;

interface RequestInterface
{
    /**
     * Get a query value from the $_GET super global
     *
     * @param  string   $key
     * @param  mixed    $fallback
     * @return mixed
     */
    public function get($key = null, $fallback = null);

    /**
     * Get a parameter value from the $_POST super global
     *
     * @param  string   $key
     * @param  mixed    $fallback
     * @return mixed
     */
    public function post($key = null, $fallback = null);

    /**
     * Get a cookie value from the $_COOKIE super global
     *
     * @param  string   $key
     * @param  mixed    $fallback
     * @return mixed
     */
    public function cookies($key = null, $fallback = null);

    /**
     * Get a file value from the $_FILES super global
     *
     * @param  string   $key
     * @param  mixed    $fallback
     * @return mixed
     */
    public function files($key = null, $fallback = null);

    /**
     * Get a server value from the $_SERVER super global
     *
     * @param  string   $key
     * @param  mixed    $fallback
     * @return mixed
     */
    public function server($key = null, $fallback = null);

    /**
     * Get a request header value
     *
     * @param  string   $key
     * @param  mixed    $fallback
     * @return mixed
     */
    public function headers($key = null, $fallback = null);

    /**
     * Get the current path
     *
     * @return string
     */
    public function currentPath();
}
