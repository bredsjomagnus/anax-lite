<?php
namespace Maaa16\Session;

class Session
{
    private $name;

    /**
     * Constructor
     * @param string $name (optional) The name of the session
     * @return void
     */
    public function __construct($name = "Maaa16SESSION")
    {
        $this->name = $name;
    }

    /**
     * Starts the session if not exists
     * @return void
     */
    public function start()
    {
        session_name($this->name);

        if (!empty(session_id())) {
            session_destroy();
        }
        session_start();
    }

    /**
    * Set a value to a key in Session if key not already exists
    * @param string $key
    * @param $value
    */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Check if key exists in session
     * @param $key string The key to check for in session
     * @return bool true if $key exists, otherwise false
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * Retrieve value if exists in session
     * @param $key string The key to get from session
     * @param $default optional The return value if not found
     * @return string The session variable if present, else $default
     */
    public function get($key, $default = false)
    {
        return (self::has($key)) ? $_SESSION[$key] : $default;
    }

    /**
     * Destroys the session and sets cookie
     * @return void
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * Deletes variable from session if exists
     * @param $key string The key variable to unset from session
     * @return void
     */
    public function delete($key)
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Dumps the session
     * Good for debugging
     * @return void
     */
    public function dump()
    {
        var_dump($_SESSION);
    }

    public function status()
    {
        $data = [
            "Status"            => session_status(),
            "Save Path"         => session_save_path(),
            "Name"              => session_name(),
            "Cookie params"     => session_get_cookie_params(),
            "ID"                => session_id()
        ];
        return $data;
    }
}
