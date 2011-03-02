<?php defined('SYSPATH') or die('No direct access allowed.');

/**
  * File Driver
  * @package		Hauthlite
  * @category   Drivers
  * @author		  Neftali Bautista <http://lab.huexotzinca.com/hauthlite/>
  * @copyright  (c) 2010-2011 Huexotzinca
  * @license		http://lab.huexotzinca.com/license
  */
  
class Kohana_Hauthlite_File extends Kohana_Hauthlite
{
/**
  * @var  array  users
  */
  protected static $users = array();
  
  function __construct($name = "default", array $config = NULL )
  {
    $this->config = $config;
    $this->session = Session::instance(); // init the session object
    Hauthlite_File::$users = $config['users'];
    $this->session_key = $config['session_key'];
  }
  
/**
  * @return boolean If can be logged
  */
  public function login($username, $password)
  {
    if (empty($password))
    {
      return false;
    }
    
    if (isset(Hauthlite_File::$users[$username]) && Hauthlite_File::$users[$username] === $this->hash($password))
    {
      $token = $this->session->regenerate();
      $this->session->set($this->session_key, true);
      return true;
    }
    else
    {
      return false;
    }
  }
  
/**
  * @return boolean If can be logged
  */
  public function logged_in()
  {
    $user = $this->session->get($this->session_key); // get the user from the Kohana_Session object
    if ($user)
    {
      return $user;
    }
    return false;
  }
  
  public function logout($destroy = false)
  {
    if ($destroy === true)
    {
    	$this->session->destroy();
    }
    else
    {
    	$this->session->delete($this->session_key);
    	$this->session->regenerate();
    }
    
    return !$this->logged_in();
  }
}// End Kohana_Hauthlite_File
