<?php namespace Enstart\Http;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

class Session implements SessionInterface
{
    /**
     * @var Symfony\Component\HttpFoundation\Session
     */
    protected $session;


    /**
     * @param Symfony\Component\HttpFoundation\Session $session
     */
    public function __construct(SymfonySession $session = null)
    {
        $this->session = $session ?: new SymfonySession;
        $this->session->start();
    }


    /**
     * Checks if an attribute is defined.
     *
     * @param string $name The attribute name
     *
     * @return bool true if the attribute is defined, false otherwise
     */
    public function has($name)
    {
        return $this->session->has($name);
    }


    /**
     * Returns an attribute.
     *
     * @param string $name    The attribute name
     * @param mixed  $default The default value if not found
     *
     * @return mixed
     */
    public function get($name, $fallback = null)
    {
        return $this->session->get($name, $fallback);
    }


    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $this->session->set($name, $value);
    }


    /**
     * Returns attributes.
     *
     * @return array Attributes
     */
    public function all()
    {
        return $this->session->all();
    }


    /**
     * Sets attributes.
     *
     * @param array $attributes Attributes
     */
    public function replace(array $attributes)
    {
        $this->session->replace($attributes);
    }


    /**
     * Removes an attribute.
     *
     * @param string $name
     *
     * @return mixed The removed value or null when it does not exist
     */
    public function remove($name)
    {
        return $this->session->remove();
    }


    /**
     * Clears all attributes.
     */
    public function clear()
    {
        $this->session->clear();
    }


    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return $this->session->isStarted();
    }


    /**
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     *
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                      will leave the system settings unchanged, 0 sets the cookie
     *                      to expire with browser session. Time is in seconds, and is
     *                      not a Unix timestamp.
     *
     * @return bool True if session invalidated, false if error
     */
    public function invalidate($lifetime = null)
    {
        return $this->session->invalidate($lifetime);
    }


    /**
     * Set a flash message
     *
     * @param string    $key
     * @param mixed     $value
     */
    public function setFlash($key, $value)
    {
        $this->session->getFlashBag()->set($key, $value);
        return $this;
    }


    /**
     * Add a flash message
     *
     * @param string    $key
     * @param mixed     $value
     */
    public function addFlash($key, $value)
    {
        $this->session->getFlashBag()->add($key, $value);
        return $this;
    }


    /**
     * Get a flash message
     *
     * @param  string   $key
     * @param  array    $fallback
     * @return mixed
     */
    public function getFlash($key, $fallback = [])
    {
        return $this->session->getFlashBag()->get($key, $fallback);
    }


    /**
     * Clear flash messages
     *
     * @param mixed     $value
     */
    public function clearFlash($key, $value)
    {
        $this->session->getFlashBag()->clear();
        return $this;
    }
}
