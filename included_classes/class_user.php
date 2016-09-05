<?php
session_start();
require_once ("../include/class_sql.php");
require_once ("../include/class_misc.php");
class userfunctions
{
	public static $sql,$misc;
	public $regNo;
	private $username,$password, $login,$database,$type;
	public function __construct($regno=false)
	{
		$this->database="phd_fresh";
		$this->regNo=$regno;
	}
	public  function logging($username,$password)
	{
                
                $misc=new miscfunctions();
                //$mac=$misc->getMacAddress();
               // $ip=$_SERVER['REMOTE_ADDR'];
                if(!ctype_alnum($username)){
             
                  // mysql_query("insert into injection(`ip`,`mac`) values(\"$ip\",\"$mac\")"); 
                   $misc->palert("Before you even begin With that SQL Injection thing The back door has been closed Right on your nose Name's not down so you're NOT coming in.",'./index.php');
                   exit(0);
                }
                $sql=new sqlfunctions();
		$sql->connect_db("login");
		$dummy=$sql->get_value("pass","login","regno",$username);
		// $sql->get_value("pass","login","regno=",$username);
		 //$this->login->sql="select * from login where regno=\"$username\" and pass=\"$password\" and regno not in (select regno from reg_e_11.track)";
     	 //.$this->login->process_query($this->login->sql);
		 if($sql->num_rows()==1 && !strcmp($password,$dummy))
			return 1;
                else
			return 0;
	}
	public function is_blocked($regno)
	{
		
			$sql=new sqlfunctions();
			$sql->database=$sql->get_curr_reg();
			$dummy=$sql->get_value("*","track","regno",$regno);
			if($sql->num_rows())
			return 1;
			else 
			return 0;
	}
	
	public function is_logged()
	{
		if(session_is_registered('regno'))
			return true;
		else
			return false;
	}
	public function checkUser($regno)
	{
		
		$sql=new sqlfunctions();
		$sql->connect_db("phd");
		$dummy=$sql->get_value("*", "stu_per_rec","regno",$regno);
		if($sql->num_rows())
			$this->type="y";
		else if($sql->num_rows()==0 && $regno!="admin")
			$this->type="n";
		else
			$this->type="admin"; 
		//	echo $sql->num_rows();//$this->type;  
			$sql->connect_db($sql->get_curr_reg());             //edited for admin page
		$name=$sql->get_value("name","student","regno",$regno);
		$_SESSION['name']=$name;
		
		$_SESSION['regno']=$regno;
		$_SESSION['type']=$this->type;
	}
	public function logout()
	{
		session_destroy();
		$misc=new miscfunctions();
		$misc->redirect("home.php");
	}
	
	public function setPhotoPath()
   {
   		$sql=new sqlfunctions();
		$sql->connect_db("icard");
		$photo_id=$sql->get_value("photoid","registeration","regisno",$this->regNo);
		$photo_id= trim ($photo_id);
		
		if($photo_id)
		{
				//exec("chmod 400 ./photos/".$photo_id.".JPG"); 
				$photoPath="./photos/".$photo_id.".JPG";
		}
		return $photoPath;
	}
	public function unsetPhotoId()
   {
   		$sql=new sqlfunctions();
		$sql->connect_db("icard");
		$photo_id=$sql->get_value("photoid","registeration","regisno",$this->regNo);
		$photo_id= trim ($photo_id);
		if($photo_id)
		{
				exec("chmod 000 ./photos/".$photo_id.".JPG"); 
		}
	}
	
}
?>
