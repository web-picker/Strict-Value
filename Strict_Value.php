<?php 

if( !defined("STRICT_VALUE_DEBUG") )
	define("STRICT_VALUE_DEBUG", TRUE);

interface Strict_Value_Interface {

	public function get();

	public function _set( $value );

	public function is_valid();

}

abstract class Strict_Value {

	protected $value;

	public $original_value;

	protected $is_valid = FALSE;

	public function __call( $method, $args )
	{
		if( $method == "set" )
		{
			$this->original_value = $args[0];

			$result = call_user_func_array( array(&$this, "_set"), $args );

			$this->is_valid = $result;

			return $result;
		}
		else
		{
			trigger_error("{$method} not found.", E_USER_ERROR);
		}
	}

	/**
	* Get the value
	*
	* @return mixed
	*/
	public function get()
	{
		if( STRICT_VALUE_DEBUG === TRUE && $this->is_valid() === FALSE )
		{
			trigger_error("Strict value is wrong.", E_USER_ERROR);
		}

		return $this->value;
	}

	/**
	* Check value status
	*
	* @return 	boolean
	*/
	public function is_valid()
	{
		return $this->is_valid;
	}

}

class Bool extends Strict_Value  implements Strict_Value_Interface {

	/**
	* Set the value
	*
	* @param 	boolean|string|int 	$value
	*
	* @return 	boolean
	*/
	public function _set( $value )
	{
		if( is_numeric( $value ) )
		{
			$_value = intval($value);

			if( in_array( $_value, array(1, 0) ) )
			{
				$value = (bool) $_value;
			}
		}

		if( is_string( $value ) )
		{
			$_value = strtoupper( trim( $value ) );

			if( in_array( $_value, array("TRUE", "FALSE") ) )
			{
				$value = filter_var($_value, FILTER_VALIDATE_BOOLEAN);
			}
		}

		if( is_bool( $value ) )
		{
			$this->value = $value;

			return TRUE;
		}

		return FALSE;
	}

}

class Int extends Strict_Value  implements Strict_Value_Interface {

	/**
	* Set the value
	*
	* @param 	string|int 	$value
	*
	* @return 	boolean
	*/
	public function _set( $value )
	{
		if( is_string($value) || is_numeric($value) )
		{
			$value = trim( $value );
		}

		if( preg_match("/^[0-9]+$/", $value) )
		{
			$value = $value = filter_var($value, FILTER_VALIDATE_INT);

			if( $value === 0 || $value !== FALSE )
			{
				$this->value = $value;

				return TRUE;
			}
		}

		return FALSE;
	}

}

class Float extends Strict_Value  implements Strict_Value_Interface {

	/**
	* Set the value
	*
	* @param 	string|int 	$value
	*
	* @return 	boolean
	*/
	public function _set( $value )
	{
		if( $value = filter_var($value, FILTER_VALIDATE_FLOAT) )
		{
			$this->value = $value;

			return TRUE;
		}

		return FALSE;
	}
	
}

class String extends Strict_Value  implements Strict_Value_Interface {

	/**
	* Set the value
	*
	* @param 	string 	$value
	*
	* @return 	boolean
	*/
	public function _set( $value )
	{
		if( is_string( $value ) )
		{
			$this->value = $value;

			return TRUE;
		}

		return FALSE;
	}
	
}


