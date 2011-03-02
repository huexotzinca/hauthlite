<?php  defined('SYSPATH') or die('No direct script access.');

/**
  * HauthLite library by Neftali Bautista for lite user authenticathion
  * for mini sites like Blogs, small sites and/or for small proyects.
  * This library was designed for Kohana Framework 3.0 > 
  *
  * @package		Hauthlite
  * @author		  Neftali Bautista <http://lab.huexotzinca.com/hauthlite/>
  * @copyright  (c) 2010-2011 Huexotzinca
  * @license		http://lab.huexotzinca.com/license
  * @since		  0.1.0
  */

abstract class Kohana_Hauthlite 
{
/**
  * @var  string  default instance name
  */
  public static $default = 'default';

/**
  * @var array instances of hauthlite
  */
  public static $instances = array();
  
/**
 * @var Kohana_Session Object for the scope session 
 */
  protected $session;
  
/**
 * @var string The session key
 */
  protected $session_key;
 
/**
  * @var array hauthlite configuration
  */ 
  protected $config;

/** 
  * make protected for Factory pattern 
  */
  protected function __clone(){ }
  
  protected function __construct(){ }
  
/**
  * Get a singleton hauthlite instance. If configuration is not specified,
  * it will be loaded from the database configuration file using the same
  * group as the name.
  *
  * @access public
  * @param string Name of the hauthlite instance
  * @param array Configuration of the new instance
  * @return Hauthlite  New instance of hauthlite object or default instance
  */
  public static function instance($name = NULL, array $config = NULL)
  {
    if ($name === NULL)
    {
      // Use the default instance name
      $name = Hauthlite::$default;
    }
    if ( ! isset(Hauthlite::$instances[$name]) || ! (Hauthlite::$instances[$name] instanceof Hauthlite))
    {
      Hauthlite::$instances[$name] = Hauthlite::factory($name, $config);
    }

    return Hauthlite::$instances[$name];
  }
	
/**  factory : Create a new instance of hauthlite
  *  
  * @access public
  * @param string Name of the hauthlite instance
  * @param array Configuration of the new instance
  * @return Hauthlite  New instance of hauthlite object
  */
  public static function factory($name = 'default', array $config = NULL)
  {
    if ($config === NULL)
    {
      // Load the configuration for this database
      $config = Kohana::config('hauthlite')->$name;
    }
    $driver = $config['driver'];
    $driver = strtoupper(trim((!$driver ? "ORM" : $driver)));
    if ( $driver !== 'ORM' && $driver !== 'FILE' )
    {
      $driver = 'ORM';
    }
    $class = 'Hauthlite_'.$driver;
    return new $class($name, $config);
  }
  
/**
  * Init the user object
  *
  * @param   string  user name
  * @param   string  user password
  * @return object FILE or ORM object
  */
  abstract public function login($username, $password);
  
/**
  * Init the user object
  *
  * @param   string  user name
  * @param   string  user password
  * @param   boolean  remember
  * @return object FILE or ORM object
  */
  abstract public function logged_in();
  
/**
  * Close the current session
  *
  * @return boolean If the session has been closed successfully
  */
  abstract public function logout();
  
/**
  * Get the instaced current user
  *
  * @return object FILE or ORM object
  */
  public function getUser()
  {
    return $this->logged_in();
  }
  
/**
  * Apply hash method type defined in the config file('hash_method') to string
  *
  * @return string Hash method type applied
  */
  public function hash($str)
  {
    return hash($this->config['hash_method'], $str);
  }
  
}// End Kohana_Hauthlite
