<?php defined('SYSPATH') OR die('No direct access allowed.');
	 
return array(
  'default' => array
  (
    'driver'      => 'ORM',  // ORM, FILE
    'hash_method' => 'sha1',
    'lifetime'    => 1209600,
    'session_key' => 'hauthlite_user',
    // ORM config
    'ORM_config'   => array(
                      'table'         => 'model_name',          // User model name
                      'prefix'        => 'prefix',
                      'pk'            => 'pkname',
                      'user_name'     => 'user_field_name',     // User name column
                      'user_password' => 'password_field_name', // Userpassword column
                      'user_session'  => 'session_field_name',  // Session column
    ),
	  //// Username/password combinations for the Auth File driver
	  //'users' => array(
		//               'admin' => 'd033e22ae348aeb5660fc2140aec35850c4da997',
	  //),
  ),
  'alternate' => array(
    'driver'      => 'FILE',  // ORM, FILE
    'hash_method' => 'sha1',
    'lifetime'    => 1209600,
    'session_key' => 'hauthlite_user',
	  // Username/password combinations for the Auth File driver
	  'users' => array(
		               'admin'       => 'd033e22ae348aeb5660fc2140aec35850c4da997', // admin
		               'huexotzinca' => '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', // password
	  ),
  ),
);
