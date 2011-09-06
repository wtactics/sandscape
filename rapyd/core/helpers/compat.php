<?php


//compatibility functions



// multibyte functions

if ( !function_exists('mb_substr') ):
function mb_substr( $str, $start, $length=null, $encoding=null ) {
		return _mb_substr($str, $start, $length, $encoding);
}
endif;
function _mb_substr( $str, $start, $length=null) {

   // use the regex unicode support to separate the UTF-8 characters into an array
   preg_match_all( '/./us', $str, $match );
  $chars = is_null( $length )? array_slice( $match[0], $start ) : array_slice( $match[0], $start, $length );
  return implode( '', $chars );
}