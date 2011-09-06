<?php if (!defined('RAPYD_PATH')) exit('No direct script access allowed');


class rpd_image_helper {


public function crop($name, $filename, $new_w, $new_h)
{
	$size = getimagesize($name);//$userfile['tmp_name']
	$width  = $size[0];
	$height = $size[1];
	$type   = $size[2];
		
	switch ($type)
	{
		case 1:
			$src_img=imagecreatefromgif($name);
		break;
		case 2:
			$src_img=imagecreatefromjpeg($name);
		break;

		case 3:
			$src_img=imagecreatefrompng($name);
		break;

		default:
			return false;
		break;
	}

	//$width = imagesx( $src_img );
	//$height = imagesy( $src_img );

	$src_x = $src_y = 0;
	$src_w = $width;
	$src_h = $height;

	$cmp_x = $width  / $new_w;
	$cmp_y = $height / $new_h;


	if ( $cmp_x > $cmp_y ) {

		$src_w = round( ( $width / $cmp_x * $cmp_y ) );
		$src_x = round( ( $width - ( $width / $cmp_x * $cmp_y ) ) / 2 );

	}
	elseif ( $cmp_y > $cmp_x ) {

		$src_h = round( ( $height / $cmp_y * $cmp_x ) );
		$src_y = round( ( $height - ( $height / $cmp_y * $cmp_x ) ) / 2 );

	}

	$dst_img=imagecreatetruecolor($new_w,$new_h);
	imagecopyresampled( $dst_img, $src_img, 0, 0, $src_x, $src_y, $new_w, $new_h, $src_w, $src_h );

	switch ($type)
	{
		case 1:
			$rs = imagegif($dst_img, $filename);
		break;
		case 2:
			$rs = imagejpeg($dst_img, $filename);
		break;
		case 3:
			$rs = imagepng($dst_img, $filename);
		break;
	}

	if (isset($rs) && $rs) {
		@chmod($filename, 0666);
	}

	imagedestroy($dst_img);
	imagedestroy($src_img);
}





}
