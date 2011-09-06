<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');



class rpd_url_helper {


	//clause, and params expected   i.e.  for:  orderby/{field}/{direction}   ordeby need 2 params
	public static $semantic = array(
			'search'=>1,
			'reset'=>1,
			'pag'=>1,
			'orderby'=>2,
			'show'=>1,
			'create'=>1,
			'modify'=>1,
			'delete'=>1,
			'insert'=>1,
			'update'=>1,
			'do_delete'=>1);

	public static function get_url() {
		$url_string = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : @getenv('REQUEST_URI');
		return $url_string;
	}

	// --------------------------------------------------------------------

	public static function get_uri() {
		$uri_string = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
		return trim($uri_string,'/');
	}

	// --------------------------------------------------------------------

	public static function get_qs() {
		return $_SERVER['QUERY_STRING'];
	}


	// --------------------------------------------------------------------

	/**
	 * take an 'application' URI (ie. controller/method/param)
	 * and return a full URL  (ie. http://host/rapydpath/[index.php]/controller/method/param)
	 */
	public static function url($uri)
	{
		if (defined('CI_VERSION')) {
			$config = get_config();
			$base_url = $config['base_url'];
			$index_page = $config['index_page'];
		} else {
			$base_url = rpd::config('basename');
			$index_page = rpd::config('index_page');
		}
		if($base_url!='')
			$uri = preg_replace("#^".preg_quote(trim($base_url,'/').'/')."(.*)#",'\\1',$uri);
		if ($index_page!='')
			return rtrim($base_url,'/').'/'.$index_page.'/'.trim($uri,'/');
		else
			return rtrim($base_url,'/').'/'.trim($uri,'/');
	}


	/**
	 *reverse or url(), return an application uri removing [http://host/path/index.php/]uri
	 *
	 */
	public static function uri($url, $as_array=false)
	{
		if (defined('CI_VERSION')) {
			$config = get_config();
			$base_url = $config['base_url'];
			$index_page = $config['index_page'];
		} else {
			$base_url = rpd::config('basename');
			$index_page = rpd::config('index_page');
		}
		$base_arr = parse_url(rtrim($base_url,'/').'/'.$index_page.'/');
		$url_arr = parse_url($url);

		$uri = ($base_arr['path'] != '/') ? trim(str_replace($base_arr['path'], '', $url_arr['path']), '/') : '';
		return ($as_array) ? explode("/",$uri) : $uri;
	}

	// --------------------------------------------------------------------

	public static function get_self() {
		$url = self::get_url();
		if (strpos($url, '?') === false)  return $url;
		return substr($url, 0, strpos($url,'?'));
	}

	// --------------------------------------------------------------------

	//l'opposto di parse_str() in php non esiste come funziona nativa
	public static function unparse_str($array) {
		$query_string = '?';
		foreach($array as $key => $val) {
			if (is_array($val)) {
				foreach($val as $sub_key => $sub_val) {
					// Integer subkeys are numerically indexed arrays
					$sub_key = is_int($sub_key) ? '[]' : '['.$sub_key.']';
					$query_string .= $key.rawurlencode($sub_key).'='.rawurlencode($sub_val).'&';
				}
			}
			else {
				$query_string .= $key.'='.rawurlencode($val).'&';
			}
		}
		$query_string = rtrim($query_string, '&');
		return $query_string;
	}

	// --------------------------------------------------------------------

	public static function append($key, $value, $url=null) {
		return (rpd::config('url_method')=='uri') ? self::uri_append($key, $value, $url) :  self::qs_append($key, $value, $url);
	}

	public static function remove($keys, $url=null, $params=null) {
		return (rpd::config('url_method')=='uri') ? self::uri_remove($keys, $url, $params) :  self::qs_remove($keys, $url);
	}

	public static function remove_all($cid=null, $url=null) {
		return (rpd::config('url_method')=='uri') ? self::uri_remove_all($cid, $url) :  self::qs_remove_all($cid, $url);
	}

	public static function replace($key, $newkey, $url=null) {
		return (rpd::config('url_method')=='uri') ? self::uri_replace($key, $newkey, $url) :  self::qs_replace($key, $newkey, $url);
	}

	public static function value($key, $default=FALSE, $params=null) {
		return (rpd::config('url_method')=='uri') ? self::uri_value($key, $default, $params) :  self::qs_value($key, $default);
	}

	// --------------------------------------------------------------------

	//vedere se è il caso di usare le rwrules per ovviare ai problemi con i namespace
	public static function qs_append($key, $value, $url=null) {
		$qs_array = array();
		$url = (isset($url)) ? $url : self::get_url();
		if (strpos($url, '?') !== false) {
			$qs = substr($url, strpos($url,'?')+1);
			$url = substr($url, 0, strpos($url,'?'));
			parse_str($qs, $qs_array);
		}
		$qs_array[$key] = $value;

		$query_string = self::unparse_str($qs_array);

		return ($url . $query_string);
	}

	// --------------------------------------------------------------------

	public static function qs_remove($keys, $url=null) {
		$qs_array = array();
		$url = (isset($url)) ? $url : self::get_url();
		if (strpos($url, '?') === false)  return $url;

		$qs = substr($url, strpos($url,'?')+1);
		$url = substr($url, 0, strpos($url,'?'));
		parse_str($qs, $qs_array);

		if (!is_array($keys)) {
			if ($keys=='ALL')
				return $url;
			$keys = array($keys);
		}
		foreach ($keys as $key) {
			unset($qs_array[$key]);
		}
		$query_string = self::unparse_str($qs_array);

		return ($url . $query_string);
	}

	// --------------------------------------------------------------------

	public static function qs_remove_all($cid=null, $url=null) {
		$semantic = array(  'search', 'reset',   'checkbox',
				'pag',    'orderby', 'show',
				'create', 'modify',  'delete',
				'insert', 'update',  'do_delete' );

		if (isset($cid)) {
			foreach ($semantic as $key) {
				$keys[] = $key.$cid;
			}
			$semantic = $keys;
		}
		return self::remove($semantic, $url);
	}

	// --------------------------------------------------------------------

	public static function qs_replace($key, $newkey, $url=null) {
		$qs_array = array();
		$url = (isset($url)) ? $url : self::get_url();

		if (strpos($url, '?') !== false) {
			$qs = substr($url, strpos($url,'?')+1);
			$url = substr($url, 0, strpos($url,'?'));
			parse_str($qs, $qs_array);
		}
		if (isset($qs_array[$key])) {
			$qs_array[$newkey] = $qs_array[$key];
			unset($qs_array[$key]);
		}
		$query_string = self::unparse_str($qs_array);
		return ($url . $query_string);
	}

	// --------------------------------------------------------------------

	public static function qs_value($key, $default=FALSE) {
		if (strpos($key,'|')) {
			$keys = explode('|',$key);
			foreach ($keys as $k) {
				$v = self::value($k, $default);
				if ($v != $default) return $v;
			}
			return $default;
		}

		if (strpos($key,'.')) {
			list($namespace, $subkey) = explode('.',$key);
			return (isset($_GET[$namespace][$subkey])) ?  $_GET[$namespace][$subkey] : $default;
		}
		else {
			return (isset($_GET[$key])) ? $_GET[$key] : $default;
		}
	}

	// --------------------------------------------------------------------

	public static function uri_append($key, $value=null, $url=null) {

		$url = (isset($url)) ? $url : self::get_url();
		$seg_array = self::uri($url, true);

		$key_position = array_search($key,$seg_array);
		if ($key_position!==false) {

			array_splice($seg_array, $key_position,count((array)$value)+1, array_merge((array)$key, array_map('strval', (array)$value)));
		} else {
			$seg_array = array_merge($seg_array, array_merge((array)$key, array_map('strval', (array)$value)));
		}

		return self::url(implode('/',$seg_array));
	}

	// --------------------------------------------------------------------

	public static function uri_remove($keys, $url=null, $params=1) {
		$url = (isset($url)) ? $url : self::get_url();
		$seg_array = self::uri($url, true);

		if (!is_array($keys)) {
			//if ($keys=='ALL')
			//	return $uri;
			$keys = array($keys);
		}

		foreach ($keys as $key) {
			$key_position = array_search($key,$seg_array);
			if ($key_position!==false) {
				if (isset(self::$semantic[$key])) {
	
					array_splice($seg_array, $key_position,self::$semantic[$key]+1);
	
				} else {
					array_splice($seg_array, $key_position, $params+1);
				}
			}
		}
		return self::url(implode('/',$seg_array));
	}

	// --------------------------------------------------------------------

	public static function uri_remove_all($cid=null, $url=null) {
		$keys = array();
		if (isset($cid)) {
			foreach (self::$semantic as $key=>$params) {
				$keys[] = $key.$cid;
			}
			return self::uri_remove($keys, $url);

		} else {

			$url = (isset($url)) ? $url : self::get_url();
			foreach (self::$semantic as $key=>$params) {
				if (preg_match_all('@('.$key.'\d*)@', $url, $matches))
					foreach($matches[1] as $mkey)
					{
						$url = self::uri_remove($mkey, $url, self::$semantic[$key]+1);
					}
			}
			return $url;
		}

	}

	// --------------------------------------------------------------------

	public static function uri_replace($key, $newkey, $url=null) {
		$url = (isset($url)) ? $url : self::get_url();
		$seg_array = self::uri($url, true);

		$key_position = array_search($key,$seg_array);
		if ($key_position!==false) {
			array_splice($seg_array, $key_position,1, array($newkey));
		}
		return self::url(implode('/',$seg_array));
	}

	// --------------------------------------------------------------------

	public static function uri_value($key, $default=FALSE, $params=1) {

		$uri = self::get_uri();
		$seg_array = explode("/",trim($uri,'/'));

		if (strpos($key,'|')) {
			$keys = explode('|',$key);
			foreach ($keys as $k) {
				$v = self::uri_value($k, $default);
				if ($v != $default) return $v;
			}
			return $default;
		}

		//non mi ricordo l'utilità.. forse nelle chiavi multiple (es. tabelle con pk a due campi)?
		if (strpos($key,'.')) {
			//...
		}
		else {
			$key_position = array_search($key,$seg_array);
			if ($key_position!==false) {
				if (isset($seg_array[$key_position+1])) {
					//..
					$skey = preg_replace("@([a-z]+)\d@", "\\1", $key);

					if (isset(self::$semantic[$skey])) {
						if (self::$semantic[$skey] == 0)
							return true;
						elseif(self::$semantic[$skey] < 2)
							return $seg_array[$key_position+1];
						else
							return array_slice($seg_array, $key_position+1, self::$semantic[$skey]);

					} else {
						if ($params == 0)
							return true;
						elseif($params < 2)
							return $seg_array[$key_position+1];
						else
							return array_slice($seg_array, $key_position+1, $params);
					}
				} else {
					return true;
				}
			}

		}

		return $default;
	}
	
	
	public static function redirect($url, $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $url))
		{
			$url = self::url($url);
		}
		
		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$url);
				break;
			default			: header("Location: ".$url, TRUE, $http_response_code);
				break;
		}
		exit;
	}
	
	
	public static function current_page($page, $output=null)
	{
		$is_current_page = false;
		$pages = (array)$page;

		foreach ($pages as $page)
		{
			if ($page == '')
			{			
				$is_current_page = (self::get_uri()=='') ? true : false;
				break;
			} elseif (preg_match('#'.$page.'#',self::get_uri()))
			{
				$is_current_page = true;
				break;
			}
		}
		return (isset($output) && $is_current_page) ? $output : $is_current_page;
	}

}
