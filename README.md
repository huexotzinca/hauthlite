# User Authentication Lite Module for Kohana
[hauthlite](http://lab.huexotzinca.com/hauthlite "hauthlite site")  is an Lite User Authentication Module for session user managment. This module is for [Kohana](http://www.kohanaphp.com "Kohana PHP Framework") 3.1 or later.


## Requeriments
For database config: 

1. database module [and ORM module].

For file coonfig:

1. User structure

> array("user" => "username", "pass" => "password", "session" => "")


## Usage
1. Add to bootstrap.php

	`Kohana::modules(array(
    ...
    'hauthlite'  => MODPATH.'hauthlite',  // Configurable user authentication
    ...
	));`

1. Init in yours modules for instances
>` private function tryLogin()
>  {
>    $response = array();
>    $user = Hauthlite::instance()->login($username, $password);
>    if ($user)
>    {
>      Request::instance()->redirect('/my/correct/controller');
>    }
>    else
>    {
>      $response[] = "Invalid user name or password.";
>    }
>    return $response;
>  }
>  
>  public function before()
>  {
>    // Run anything that need ot run before this.
>    parent::before();
>    $user = Hauthlite::instance()->logged_in();
>    if ($user)
>    {
>      Request::instance()->redirect('/user/logged/in');
>    }
>  }
>`
1. Init the module in where do you  need!
> //
> $user = Hauthlite::instance()->logged_in();
> 

## Contribute
Visit [huexotzinca lab](http://lab.huexotzinca.com/hAuthlite/contribute "Huexotzinca lab site")

## License
Read the [license](http://lab.huexotzinca.com/license "Huexotzinca lab license")
