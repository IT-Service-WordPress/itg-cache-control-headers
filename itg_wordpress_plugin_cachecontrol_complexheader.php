<?php 

namespace ITG\WordPress\Plugin\CacheControl;

use \WPF\v1 as WPF;

WPF\Loader::_require_once( 'wpf_plugin_component_base.php' );

/*
Complex HTTP Headers parser.

@since 1.0.0

@package   ITG Cache-Control headers
@author    Sergey S. Betke <Sergey.S.Betke@yandex.ru>
@license   GPL-2.0+
@copyright 2014 ООО "Инженер-53"
*/
class ComplexHeader {

	public
	$params;

	public
	function __construct(
		$value = null
	) {
		$this->params = array();
		if ( $value ) {
			$this->parse( $value );
		};
	}

	public
	function parse(
		$value
	) {
	    $this->params = array();
		foreach(
			preg_split( '/,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY )
			as $param 
		) {
			preg_match( '/(?<id>[\w-]+)(?:(?:=(?<int_value>\d+))|(?:="(?<str_value>.*)?"))?/i', $param, $matches );
			if ( array_key_exists( 'str_value', $matches ) ) {
				$this->params[ $matches[ 'id' ] ] = $matches[ 'str_value' ];
			} elseif ( array_key_exists( 'int_value', $matches ) ) {
				$this->params[ $matches[ 'id' ] ] = intval( $matches[ 'int_value' ] );
			} else {
				$this->params[ $matches[ 'id' ] ] = true;
			};
		}; 
	}

	public
	function get_value() {
		$params = array();
		foreach( $this->params as $param_id => $param_value ) {
			if ( is_bool( $param_value ) ) {
				if ( $param_value ) {
					$params[] = $param_id;
				};
			} elseif ( is_int( $param_value ) ) {
				$params[] = $param_id . '=' . $param_value;
			} elseif ( is_string( $param_value ) ) {
				$params[] = $param_id . '="' . $param_value . '"';
			} elseif ( is_array( $param_value ) ) {
				$params[] = $param_id . '="' . implode( ',', $param_value ) . '"';
			};
		};
		return implode( ', ', $params );
	}

};

?>