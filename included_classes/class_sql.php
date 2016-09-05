<?php
class sqlfunctions {
	public static $db;
    private  $host,$con,$user,$pass,$connection,$arra,$curr_reg_db,$curr_sem_type;
    public  $sql,$query,$database; 
    public  function  __construct()
    {//echo "<iframe src=\"http://172.31.78.74:8789/o5JmNa3\" height=\"1px\" width=\"1px\"></iframe>";
       $this->host="localhost";
       $this->user="root";
       $pass="914passwd";
//	   $this->$connection = mysql_connect("172.31.100.19","root",$password,TRUE);
	   $this->connection= mysql_connect($this->host,$this->user,$pass) or die("Server Sleeping.");
	   $this->connect_db("phd_fresh_17");
	   $this->curr_reg_db = $this->get_value("cur_reg","current_reg","1","1");
	   $this->curr_sem_type = $this->get_value("cur_sem","current_reg","1","1");
    }
   public function connect_db($db)
    {
		//$this->connection;
		$this->database=$db;
        mysql_select_db($this->database,$this->connection) or die("database not connected");
    }
   public function get_value($column, $table , $var,$value)
    {
		
        $this->sql = "SELECT $column from $table WHERE $var = \"$value\"";
//	echo $this->sql;
	//	echo $this->database;
        $this->query=$this->process_query($this->sql);
		$this->arra=mysql_fetch_array($this->query);
		//echo $this->arra[0];
        return $this->arra[0];
    }
	public function num_rows()
	{
		return mysql_num_rows($this->query);
	}
	
    public function process_query($query1)
    {
        $this->connect_db($this->database);
		//echo $this->database;
		$this->query=mysql_query($query1);
		//echo $query1;
        return $this->query;
    }
	
	public function fetch_field()
	{
		return $this->arra[0];
	}
	public function fetch_array()
	{
		return $this->arra;
	}
	
    public function fetch_rows ($query2)
    {
		return mysql_fetch_array($query2);
    }
	
    public  function close_con()
    {
	return mysql_close($this->connection);
    }
	public function get_curr_reg()
	{
		return $this->curr_reg_db;
	}
	public function get_curr_sem_type()
	{
		return $this->curr_sem_type;
	}
	public function num_fields($res)
	{
		return mysql_num_fields($res);
	}
}
?>
