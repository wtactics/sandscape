<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');



class rpd_sess_helper {


  public static function get_persistence()
  {
	$self = rpd_url_helper::remove_all();
    $session  = @$_SESSION['rapyd'];

    if ($session===FALSE)
      return array();
    return (isset($session[$self])) ? $session[$self] : array();

  }

	// --------------------------------------------------------------------

  public static function save_persistence()
  {
	$self = rpd_url_helper::remove_all();
	$page = self::get_persistence();

	if (count($_POST)<1)
	{
	  if ( isset($page["back_post"]) )
	  {
		if (rpd_url_helper::get_url() != $page["back_url"] && rpd::$params == array())
			header('Location: '.$page["back_url"]);
		$_POST = $page["back_post"];
	  }
	} else {
	  $page["back_post"]= $_POST;
	}

	$page["back_url"]= rawurldecode(rpd_url_helper::get_url());
	$_SESSION['rapyd'][$self] = $page;
  }

	// --------------------------------------------------------------------

  public static function clear_persistence()
  {
	$self = rpd_url_helper::remove_all();
    unset($_SESSION['rapyd'][$self]);
  }



}
