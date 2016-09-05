<?php

function redirect( $url ) 
{
		echo '<script language="javascript">';	
		echo	"window.location.href= \"$url\"  ";
       	echo	'</script>';
		
}		

function userlog( $username,  $local_add, $global_add, $log_date, $for_what, $agent )
{
		$connection1 = sql_connect_m();
		$query_insert = " INSERT INTO userlog values ( \"$username\" , \"$local_add\" ,\"$global_add\",  \"$log_date\" , \"$for_what\", \"$agent\") " ; 
		process_query( $connection1 , "after_test" , $query_insert );
		close_con($connection1);
}

function palert($message,$tourl)
{
      echo "<script>
      alert( \"$message\" );
      </script>";
         redirect($tourl);
}

function check_logged()
{
	if( !(session_is_registered('regno') )  )
		return 0;
	else 
		return 1;
}

function isphd($regno,$connection)
{
$reg="select * from stu_per_rec where regno=\"$regno\"";
$reg_q=process_query($connection,"phd",$reg);
if(mysql_num_rows($reg_q)==0)
return false;
else 
return true;
}

function get_current_table()
{
	$connection = sql_connect_m();
	$sql="select cur_reg from current_reg";
	//echo $sql;
	$q=process_query($connection,"tab",$sql);
	$arr=mysql_fetch_array($q);
	return $arr['cur_reg'];
}
function getfee($regno)
{
$connection = sql_connect_m();
$connection1 = sql_connect_u();
$mysql_query1= "select * from stu_acad_rec where regno like \"$regno\" ";
$query_mysql1 = process_query ($connection,"reg_o_11",$mysql_query1);
$results1 = mysql_fetch_array ($query_mysql1);
$course1 = $results1['prog'];
$bra = $results1['bra'];
$sem = $results1['sem_adm_to'];
$fee_q = "select * from fees where prog like \"$course1\" and bra like \"$bra\" and sem like \"$sem\" ";
//echo $fee_q;
$fee_p = process_query ($connection,"semesterfees",$fee_q);
$fee_f = mysql_fetch_array ($fee_p);
$instfee = $fee_f['inst_fee'];
$messfee = $fee_f['mess_fee'];
//if ($bra == "conpt" || $bra == "pept" || $bra == "sofpt") {$instfee = $instfee + 1575;}
// 
//echo $regno;
/*
if ($regno == "2008CC16") {$instfee = $instfee + 6000;}
if ($regno == "2009CS25" || $regno == "2009CS26" || $regno == "2009CS28"  || $regno == "2009CS29"
||$regno == "2009EL16" ||$regno == "2009EL17" ||$regno == "2009EL16" ||$regno == "2009BM09"
||$regno == "2009BM08" ||$regno == "2009BM10" ||$regno == "2009AM15" )
{$instfee = "23225";}// ****** CAD CAM Sponsored candidate
//***** Only one candiadte so i made it hard coded
//********* Dasa Locha Start
/*$dasaconcession = get_value ( $connection, "semesterfees", "amt" , "spclinstifee", "regno", $regno );
if ($dasaconcession == "full") {$instfee = "0";}
else if ($dasaconcession == "block"){$instfee = "block";}
else if ($dasaconcession == "0"){$instfee = $instfee - 0;}
else if ($dasaconcession == "4500"){$instfee = $instfee - 4500;}
else if ($dasaconcession == "17500"){$instfee = $instfee - 17500;}

//******** DASA Locha Ends*/


$instfee1 = get_value ( $connection, "semesterfees", "instfee" , "spclinstifee", "regno", $regno );
if($instfee1!="")
{
 $instfee=$instfee1;
}
$due_q = "select * from dues where regno like \"$regno\" ";
$due_p = process_query ($connection,"semesterfees",$due_q);
$accod = get_value ( $connection, "reg_o_11", "accomodation" , "reg_type_accod", "regno", $regno );
if ($accod == "daysch"){$instfee = $instfee -1575 ; $messfee = "0"; }

if ($instfee < 0){$instfee = 0;}

$due_f = mysql_fetch_array ($due_p);
$instdue = $due_f['inst_due'];
$messdue = $due_f['mess_due'];
if ($instdue == "") {$instdue = 0;}
if ($messdue == "") {$messdue = 0;}
$total = $instfee+$messfee+$instdue+$messdue;

if ($instfee === "Registration for Even Sem Not Permitted"){ $total ="Registration for Even Sem Not Permitted";}

//echo "<br>$instfee .... $fee_q .. $total<br>";
return $total;
}








function getphdfee($regno)
{
$connection = sql_connect_m();
$connection1 = sql_connect_u();
$first="select * from special where regno=\"$regno\"";
$first_q=process_query($connection,"semesterfees",$first);
$mysql_query1= "select * from stu_acad_rec where regno like \"$regno\" ";
$query_mysql1 = process_query ($connection,"phd",$mysql_query1);
$num = mysql_num_rows ($query_mysql1);
$results1 = mysql_fetch_array ($query_mysql1);



$sem = $results1['sem_adm_to'];
$prog_type=$results1['prog_type'];
 
 $type=get_value($connection,"phd","type","stud_type","regno",$regno);
if(mysql_num_rows($first_q)!=0)  // special fees for the  student
{	$arr=mysql_fetch_array($first_q);
	$instfee=$arr['instfee'];
	$messfee=$arr['messfee'];
	
}

else {

if($sem==1)
	$fee_q = "select * from phd_fees where type=\"$type\" and sem like \"$sem\" ";
else
{
	$final_sql="select * from phd_final where regno=\"$regno\"";
	$final_q=process_query($connection,"phd",$final_sql);
	if(mysql_num_rows($final_q)==0)  // he is not in his final sem
		$fee_q = "select * from phd_fees where type=\"$type\" and sem like \"all\" ";
	else
		$fee_q = "select * from phd_fees where type=\"$type\" and sem like \"final\"";
}
//echo $fee_q;
$fee_p = process_query ($connection,"phd",$fee_q);
$fee_f = mysql_fetch_array ($fee_p);

$instfee = $fee_f['inst_fees'];
$messfee = $fee_f['mess_fees'];


 $deductions=get_val($connection,"phd","deduction","fee_deductions","type",$prog_type);
$instfee=$instfee-$deductions;

}

if ($type == "pt"){$instfee = $instfee+1575;}
$acc_type=get_value($connection,"reg_o_11","accomodation","reg_type_accod","regno",$regno);
if ($acc_type == "daysch"){$deduction = '1575'; $instfee = $instfee - $deduction; $messfee = "0"; } else {$deduction = '0';}


if($prog_type=='Teacher Candidate'||$prog_type=='Teacher Candidate (PT)'||$prog_type=='Teacher Canditate')
	$instfee=0;

$due_q = "select * from dues where regno like \"$regno\" ";
$due_p = process_query ($connection,"semesterfees",$due_q);
$due_f = mysql_fetch_array ($due_p);
$instdue = $due_f['inst_due'];
$messdue = $due_f['mess_due'];
if ($instdue == "") {$instdue = 0;}
if ($messdue == "") {$messdue = 0;}


if ($instfee < 0){$instfee = 0;}
$total = $instfee+$messfee+$instdue+$messdue;
return $total;
}
$curr_reg_db = "reg_e_11";
$prev_reg_db = "reg_o_11";
?>
