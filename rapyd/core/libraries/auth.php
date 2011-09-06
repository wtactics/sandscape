<?php



class rpd_auth_library {

  public $namespace = 'admin';
  public $cookie = true;
  public $table = 'users';
  public $username = 'user_name';
  public $password = 'password';
  private $key = 'QU3sTA-M1nkCH1@<=3';
  public $duration = 0; //0 : singola sessione, time()+60*60*24*30 : un mese


	public function __construct($config = array())
	{
		foreach($config as $property=>$value)
		{
			$this->$property = $value;
		}

	}


  // --------------------------------------------------------------------

	function encrypt($data) {
		$result = '';
		for($i=0; $i<strlen($data); $i++) {
			$char = substr($data, $i, 1);
			$keychar = substr($this->key, ($i % strlen($this->key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		return base64_encode($result);
	}

	function decrypt($data) {
		$result = '';
		$data = base64_decode($data);
		for($i=0; $i<strlen($data); $i++) {
			$char = substr($data, $i, 1);
			$keychar = substr($this->key, ($i % strlen($this->key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
	}

  /**
   * prova a validare un login con user/password,  setta una variabile di sessione, opzionalmete salva un cookie
   * da usare nella pagina di login.
   */
  function login($username, $password)
  {
    $password_hash = md5($password);
	rpd::connect();
    //rpd::$db->db_debug = true;
    rpd::$db->from($this->table);
    rpd::$db->where($this->username, $username);
    rpd::$db->where($this->password, $password_hash);
    rpd::$db->where('role_id<=2');
    rpd::$db->get();

    $user = rpd::$db->row_object();
	//var_dump($user);
    if ($user===false) return false;

    $user_session = array (
      'user_name'  =>  $username,
      'password'   =>  $password,
      'name'       =>  $user->name,
      'ip_address' =>  $_SERVER['REMOTE_ADDR'],
      'role_id'    =>  $user->role_id,
    );
    $_SESSION[$this->namespace] = $this->encrypt(serialize($user_session));

    if($this->cookie) setcookie($this->namespace, $this->encrypt(serialize($user_session)), $this->duration, '/', '', 0);
    return true;
  }

  /**
   * se il cookie esiste ed è valido, o comunque esiste una sessione utente, restituisce i dati.
   */
  function logged()
  {
    if ($this->cookie AND !isset($_SESSION[$this->namespace]))
    {
      if(!isset($_COOKIE[$this->namespace])) return false;
      $cookie = $_COOKIE[$this->namespace];
      $_SESSION[$this->namespace] = stripslashes($cookie);
    }
    $user = unserialize($this->decrypt($_SESSION[$this->namespace]));
    if(!isset($user['ip_address']) OR $user['ip_address']!=$_SERVER['REMOTE_ADDR']) return false;
    return $user;
  }

  /**
   * verifica che esista una sessione utente alrimenti ridireziona su una pagina di default
   */
  function logged_or($location='index.php')
  {
    if ($this->logged()) return true;

    session_write_close();
    header('Location: '.$location);
    exit;
  }


  /**
   * restituisce l'array o una sottochiave dei dati utente
   */
  function user($key=null)
  {
    $user = $this->logged();
    if (!isset($key))
    {
      return $user;
    }
    elseif(isset($user[$key]))
    {
      return $user[$key];
    }
    return false;
  }

  /**
   * rimuove cookie e sessione, da usare al logout
   */
  function logout()
  {
    setcookie($this->namespace, '', 0, '/', '', 0);
    session_destroy();
  }



}
