<?php

function sql_connect_m()
{
		$host="localhost";
		$user="root";
		$password="";
		
		$connection = mysql_connect($host,$user,$password,TRUE) or die("Server Sleeping.");
		return 	$connection;
}
function sql_connect_u()
{
		$host="localhost";
		$user="root";
		$password="";
		
		$connection = mysql_connect($host,$user,$password,TRUE) or die("Server Sleeping.");
		return 	$connection;
}
function get_val($connection, $db, $column , $table, $var,$value, $query = 0)
{
   $get_map_query = "SELECT $column  from $table WHERE $var = \"$value\"";
   
   //if($query == 1)
   //echo $get_map_query."<br>";
   
   $get_map_res = query_process($connection,$get_map_query, $db ,1);
   $got_value = fetch_field($get_map_res);
   return $got_value[0];
   
}


function connection_close($connection)
{
	return mysql_close($connection);
}	


function num_rows($result)
{
	return mysql_num_rows($result);
}
	
	

function query_process( $connection , $query_string , $dbase , $query_type)
{
		switch ( $query_type )
		{
			case 1 :  //*********** SELECT QUERY ******************** //
					
					mysql_select_db($dbase,$connection) or die(mysql_error());
//echo $query_string;	
					$result = mysql_query( $query_string , $connection);

//if(!$result)
	//echo "?dfbjdfdhbfj";

					return $result;
					break;
					
			case 2:  //*********** DELETE QUERY ******************** //
					mysql_select_db($dbase,$connection) or die(mysql_error());
					$result = mysql_query( $query_string , $connection);
					return $result;
					break;
			case 3:  //*********** INSERT QUERY ******************** //
					mysql_select_db($dbase,$connection) or die(mysql_error());
					$result = mysql_query( $query_string , $connection);
					return $result;
					break;
			case 4:  //*********** UPDATE QUERY ******************** //
					mysql_select_db($dbase,$connection) or die(mysql_error());
					$result = mysql_query( $query_string , $connection);
					return $result;
					break;
		
		}	
}


function process_query ( $connection, $dbase, $query_string)
{	//echo $dbase; echo $connection;
	//echo $query_string;
	mysql_select_db($dbase,$connection) or die("Error Code:97");
	$result = mysql_query( $query_string , $connection) or die(mysql_error());
	return $result;
}		

function fetch_rows ( $result )
{
	return mysql_fetch_array($result);
}


function get_value ( $connection, $dbase, $column , $table, $variable, $value )
{
   $get_map_query = "SELECT $column from $table WHERE $variable = '$value'";
  	
	$get_map_res = process_query($connection, $dbase, $get_map_query);
   
    $got_value = fetch_rows($get_map_res);
   return $got_value[0];
}
function get_values ( $connection, $dbase, $column , $table, $variable, $value, $variable1, $value1 )
{
   $get_map_query = "SELECT $column from $table WHERE $variable = '$value' and $variable1 = '$value1'";
  	
	$get_map_res = process_query($connection, $dbase, $get_map_query);
   
    $got_value = fetch_rows($get_map_res);
   return $got_value[0];
}

function close_con($connection)
{
	return mysql_close($connection);
}	


function fetch_field ( $result)
{
	return mysql_fetch_array($result);
}


?>
