<?php
require_once 'class_sql.php';

class phdfunctions
{

    private $sqlObj;

    public function __construct()
    {
    $sqlObj=new sqlfunctions();
    }

    public function isphd($regno)
    {
        $sqlObj->sql="select * from stu_per_rec where regno=\"$regno\"";
        $sqlObj->query=$sqlObj->process_query($connection,"phd",$reg);
        if(mysql_num_rows($sqlObj->query)==0)
            return false;
        else
            return true;
    }
  }
?>
