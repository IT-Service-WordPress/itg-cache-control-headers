<?php

namespace ITG\WordPress\Plugin\CacheControl;

function is_http_headers_list ( $value ) {
	return
		preg_match( '/^\s*(?:(?<all>\*)|(?<header>[a-zA-Z]+(?:-[a-zA-Z0-9]+)*)(?:(?:\s*,\s*)(?P>header))*)\s*$/', $value )
		or ( '' === $value )
	;
};

function sanitize_http_headers_list ( $value ) {
	return preg_replace( '/\s*,\s*/', ', ', trim( $value ) );
	/*
	preg_match_all ( '/(?<header>(?:[a-zA-Z]+(?:-[a-zA-Z0-9]+)*|\*))/' , $value, $matches, PREG_OFFSET_CAPTURE );
	$headers = array();
	foreach( $matches['header'] as $header_info ) {
		$headers[] = $header_info[0];
	};
	return implode( ', ', $headers );
	*/
};

?>