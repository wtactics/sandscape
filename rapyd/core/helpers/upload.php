<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');

/**
 * upload helper
 * widely inspired by kohana http://kohanaphp.com
 **/

class rpd_upload_helper {

	/**
	 * @param   mixed    name of $_FILE input or array of upload data
	 * @param   string   new directory
	 * @param   string   new filename
	 * @param   integer  chmod mask
	 * @return  string   full path to new file
	 */
	public static function save($file, $directory, $filename = NULL, $chmod = 0644)
	{
		// Load file data from FILES if not passed as array
		$file = is_array($file) ? $file : $_FILES[$file];

		if ($filename === NULL)
		{
			$filename = $file['name'];
		}

		$directory = rtrim($directory, '/').'/';
		if (!is_dir($directory))
		{
			return FALSE;
		}

		$filename = preg_replace('/\s+/', '_', $filename);
		$filename = preg_replace('/[^a-zA-Z0-9\._-]/', '', $filename);

		$extension = strtolower(substr(strrchr($filename, '.'), 1));
		$name = rtrim($filename, strrchr($filename, '.'));

		$i = 0;
		$finalname = $name;
		while (file_exists($directory . $finalname. '.'.$extension))
		{
			$i++;
			$finalname = $name . (string)$i;
		}

		$filename = $finalname. '.'.$extension;

		if (is_uploaded_file($file['tmp_name']) AND move_uploaded_file($file['tmp_name'], $directory.$filename))
		{
			if ($chmod !== FALSE)
			{
				// Set permissions on filename
				chmod($directory.$filename, $chmod);
			}

			// Return new filename
			return $filename;
		}

		return FALSE;
	}


	// --------------------------------------------------------------------

	public static function type(array $file, array $allowed_types)
	{
		if ((int) $file['error'] !== UPLOAD_ERR_OK)
			return TRUE;

		$extension = strtolower(substr(strrchr($file['name'], '.'), 1));
		return ( ! empty($extension) AND in_array($extension, $allowed_types) );
	}

	// --------------------------------------------------------------------

	/**
	 * Validation rule to test if an uploaded file is allowed by file size.
	 * File sizes are defined as: SB, where S is the size (1, 15, 300, etc) and
	 * B is the byte modifier: (B)ytes, (K)ilobytes, (M)egabytes, (G)igabytes.
	 * Eg: to limit the size to 1MB or less, you would use "1M".
	 *
	 * @param   array    $_FILES item
	 * @param   string   size string (IE: 1M, 200K, 100B)
	 * @return  bool
	 */
	public static function size(array $file, $size)
	{
		if ((int) $file['error'] !== UPLOAD_ERR_OK)
			return TRUE;

		// Only one size is allowed
		$size = strtoupper($size);

		if ( ! preg_match('/[0-9]++[BKMG]/', $size))
			return FALSE;

		// Make the size into a power of 1024
		switch (substr($size, -1))
		{
			case 'G': $size = intval($size) * pow(1024, 3); break;
			case 'M': $size = intval($size) * pow(1024, 2); break;
			case 'K': $size = intval($size) * pow(1024, 1); break;
			default:  $size = intval($size);                break;
		}

		// Test that the file is under or equal to the max size
		return ($file['size'] <= $size);
	}
	
	
	
	
	public static function fullperm($path)
	{
		if (!is_file($path) && !is_dir($path))
			return '-';

		$perms = fileperms($path);
		
		if (($perms & 0xC000) == 0xC000) {
			// Socket
			$info = 's';
		} elseif (($perms & 0xA000) == 0xA000) {
			// Symbolic Link
			$info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) {
			// Regular
			$info = '-';
		} elseif (($perms & 0x6000) == 0x6000) {
			// Block special
			$info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) {
			// Directory
			$info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) {
			// Character special
			$info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) {
			// FIFO pipe
			$info = 'p';
		} else {
			// Unknown
			$info = 'u';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
					(($perms & 0x0800) ? 's' : 'x' ) :
					(($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
					(($perms & 0x0400) ? 's' : 'x' ) :
					(($perms & 0x0400) ? 'S' : '-'));

		// World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
					(($perms & 0x0200) ? 't' : 'x' ) :
					(($perms & 0x0200) ? 'T' : '-'));

		return $info;
	
	}
	
	
	
}
