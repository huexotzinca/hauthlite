## Requeriments
For database config 

1. database module [and ORM module].

For file coonfig

1. User structure

	array("user" => "username", "pass" => "password", "session" => "")

## Usage
Add to bootstrap.php

	Kohana::modules(array(
		...
		'hauthlite' => MODPATH.'hauthlite',
		...
	));
	
Init in yours modules for instances

	private function tryLogin()
	{
		$response = array();
		$user = Hauthlite::instance()->login($username, $password);
		if ($user)
		{
			Request::instance()->redirect('/my/correct/controller');
		}
		else
		{
			$response[] = "Invalid user name or password.";
		}
		return $response;
	}
	
	public function before()
	{
		// Run anything that need ot run before this.
		parent::before();
		$user = Hauthlite::instance()->logged_in();
		if ($user)
		{
			Request::instance()->redirect('/user/logged/in');
		}
	}
	
Init the module in where do you  need!

	$user = Hauthlite::instance()->logged_in();

When you need close the session only run the logout() function

	Hauthlite::instance()->logout();


[!!] TODO: add more examples
