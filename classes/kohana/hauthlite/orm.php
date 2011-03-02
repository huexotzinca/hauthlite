<?php defined('SYSPATH') or die('No direct access allowed.');

/**
  * ORM Driver
  * @package		Hauthlite
  * @category   Drivers
  * @author		  Neftali Bautista <http://lab.huexotzinca.com/hauthlite/>
  * @copyright  (c) 2010-2011 Huexotzinca
  * @license		http://lab.huexotzinca.com/license
  */
  
class Kohana_Hauthlite_ORM extends Kohana_Hauthlite
{
  
/**
  * @var array instances of hauthlite
  */
  private $ORM_config = array();
  
  function __construct($name = "default", array $config = NULL )
  {
    $this->session = Session::instance(); // init the session object
    $this->config = $config;
    $this->ORM_config = $config['ORM_config'];
    $ORM_prefix = $config['ORM_config']['prefix'];
    $this->ORM_config['pk'] = $ORM_prefix.$config['ORM_config']['pk'];
    $this->ORM_config['user_password'] = $ORM_prefix.$config['ORM_config']['user_password'];
    $this->ORM_config['user_name'] = $ORM_prefix.$config['ORM_config']['user_name'];
    $this->ORM_config['user_mail'] = $ORM_prefix.$config['ORM_config']['user_mail'];
    $this->ORM_config['user_session'] = $ORM_prefix.$config['ORM_config']['user_session'];
    $this->session_key = $config['session_key']; 
  }
  
/**
  * @param   string  user name
  * @param   string  user password
  * @param   boolean remember this save the token session in DB
  * @return Kohana_ORM Object
  */
  public function login($username, $password, $remember = false)
  {
    if (empty($password))
    {
      return false;
    }
    $user = ORM::factory($this->ORM_config['table'])->where($this->ORM_config['user_name'], '=', $username)->where($this->ORM_config['user_password'], '=', $this->hash($password))->find();
    
    if ((int)$user->pk() > 0)
    {
      $token = $this->session->regenerate();
      $this->session->set($this->session_key, $user);
      if ($remember == true)
      {
        $user->{$this->ORM_config['user_session']} = $token;
        $user->save();
        $user->reload();
        Cookie::set("hauthlite_{$this->session_key}_remember", $token, $this->config['lifetime']);
      }
      return $user;
    }
    else
    {
      return false;
    }
  }
  
/**
  * @return Kohana_ORM Object
  */
  public function logged_in()
  {
    $user = $this->session->get($this->session_key); // get the user from the Kohana_Session object
    $token = Cookie::get("hauthlite_{$this->session_key}_remember");
    if ($user && (int)$user->pk() > 0)
    {
      return $user;
    }
    elseif(is_string($token))
    {
      $user = ORM::factory($this->ORM_config['table'])->where($this->ORM_config['user_session'], '=', $token)->find();
      if ($user && (int)$user->pk() > 0)
      {
        $this->session->set($this->session_key, $user);
        Cookie::set("hauthlite_{$this->session_key}_remember", $token, $this->config['lifetime']);
        return $user;
      }
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
}// End Kohana_Hauthlite_ORM
