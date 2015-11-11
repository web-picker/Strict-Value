<?php 

define("STRICT_VALUE_DEBUG", FALSE);

require_once("strict_value.php");

class Test{

	public function bool( Bool $value )
	{
		$this->debug( $value );
	}

	public function int( Int $value )
	{
		$this->debug( $value );
	}

	public function float( Float $value )
	{
		$this->debug( $value );
	}

	public function string( String $value )
	{
		$this->debug( $value );
	}

	private function debug( Strict_Value $value ){
		echo '<tr><th>' . var_export( $value->original_value, TRUE ) . '</th><td>' . var_export( $value->is_valid(), TRUE ) . '</td></tr>';
	}

}

$test_obj 	= new Test();
$bool_obj 	= new Bool();
$int_obj 	= new Int();
$float_obj 	= new Float();
$string_obj = new String();

$test_data = array(
	// Boolean
	"false", "true", "False", "FALSE", "TRUE", TRUE, FALSE,
	// INT
	"1", "0", 1, 0,
	// Float
	"1.2", "0.1", 1.2, "3.0",
	// String
	"sample",
	// Other
	array("a", "b"), new stdClass
);

?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Strict value Test page</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<body>
		
		<div class="container">
			
			<h3>Boolean 型</h3>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="width:30%">入力値</th>
						<th>結果</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach( $test_data as $value )
					{
						$bool_obj->set( $value );
						$test_obj->bool( $bool_obj );
					} ?>
				</tbody>
			</table>

			<h3>Int 型</h3>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="width:30%">入力値</th>
						<th>結果</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach( $test_data as $value )
					{
						$int_obj->set( $value );
						$test_obj->int( $int_obj );
					} ?>
				</tbody>
			</table>

			<h3>Float 型</h3>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="width:30%">入力値</th>
						<th>結果</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach( $test_data as $value )
					{
						$float_obj->set( $value );
						$test_obj->float( $float_obj );
					} ?>
				</tbody>
			</table>

			<h3>String 型</h3>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th style="width:30%">入力値</th>
						<th>結果</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach( $test_data as $value )
					{
						$string_obj->set( $value );
						$test_obj->string( $string_obj );
					} ?>
				</tbody>
			</table>

		</div>

	</body>
</html>

