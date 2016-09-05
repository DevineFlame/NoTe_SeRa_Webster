<?php
require_once 'class_sql.php';
require_once 'class_misc.php';
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_fee
 *
 * @author DeanAA
 */
class fee 
{
 private $sqlObj;

        public function  __construct()
        {
            $sqlObj=new sqlfunctions();
        }
  

  function getfee($regno)
    {   $database="reg_e_13";
	$database1="semesterfees";
        $this->sqlobj->sql= "select * from stu_acad_rec where regno like \"$regno\" ";
        $this->sqlobj->process_query($database);
        $results1 = mysql_fetch_array ($this->sqlobj->query);
        $course1 = $results1['prog'];
        $bra = $results1['bra'];
        $sem = $results1['sem_adm_to'];
        $this->sqlobj->sql ="select * from fees where prog like \"$course1\" and bra like \"$bra\" and sem like \"$sem\" ";
        $this->sqlobj->process_query($database1);
        $fee_f = mysql_fetch_array ($this->sqlobj->query);
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
        $this->sqlobj->sql = "select * from dues where regno like \"$regno\" ";
        $this->sqlobj->process_query ($database1);
        $accod = get_value ( $connection, "reg_o_11", "accomodation" , "reg_type_accod", "regno", $regno );
        if ($accod == "daysch"){$instfee = $instfee -1575 ; $messfee = "0"; }

        if ($instfee < 0){$instfee = 0;}

        $due_f = mysql_fetch_array ($due_p);
        $instdue = $due_f['inst_due'];
        $messdue = $due_f['mess_due'];
            if ($instdue == "") {$instdue = 0;}
    if ($messdue  == "") {$messdue = 0;}
        $total = $instfee+$messfee+$instdue+$messdue;

        if ($instfee === "Registration for Even Sem Not Permitted"){ $total ="Registration for Even Sem Not Permitted";}

        //echo "<br>$instfee .... $fee_q .. $total<br>";
        return $total;
        }

        function getphdfee($regno)
        {
        $database="semesterfees";
        $this->sqlobj->sql="select * from special where regno=\"$regno\"";
        $this->sqlobj->process_query($database);
        $this->sqlobj->sql="select * from stu_acad_rec where regno like \"$regno\" ";
        $this->sqlobj->process_query ("phd");
        $num = mysql_num_rows ($this->sqlobj->query);
        $results1 = mysql_fetch_array ($this->sqlobj->query);



        $sem = $results1['sem_adm_to'];
        $prog_type=$results1['prog_type'];

        $type=get_value($connection,"phd","type","stud_type","regno",$regno);
        if(mysql_num_rows($this->sqlobj->query)!=0)  // special fees for the  student
        {	$arr=mysql_fetch_array($this->sqlobj->query);
        	$instfee=$arr['instfee'];
            	$messfee=$arr['messfee'];

        }

        else {

        if($sem==1)
        	$this->sqlobj->sql = "select * from phd_fees where type=\"$type\" and sem like \"$sem\" ";
        else
        {
        	$this->sqlobj->sql="select * from phd_final where regno=\"$regno\"";
        	$this->sqlobj->process_query("phd");
        	if(mysql_num_rows($this->sqlobj->query)==0)  // he is not in his final sem
        		$this->sqlobj->sql= "select * from phd_fees where type=\"$type\" and sem like \"all\" ";
            	else
        		$this->sqlobj->sql= "select * from phd_fees where type=\"$type\" and sem like \"final\"";
        }
        //echo $fee_q;
        $this->sqlobj->process_query ("phd");
        $fee_f = mysql_fetch_array($this->sqlobj->query);

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

        $this->sqlobj->sql = "select * from dues where regno like \"$regno\" ";
        $this->sqlobj->process_query($database);
        $due_f = mysql_fetch_array ($this->sqlobj->query);
        $instdue = $due_f['inst_due'];
        $messdue = $due_f['mess_due'];
        if ($instdue == "") {$instdue = 0;}
        if ($messdue == "") {$messdue = 0;}


        if ($instfee < 0){$instfee = 0;}
        $total = $instfee+$messfee+$instdue+$messdue;
        return $total;
        }
     
  function payment_status($regno)  //checking payment status
	{
	$database="semesterfees";
        $this->sqlobj->sql= "select * from  `bankrecords` where regno like \"$regno\"  ";
        $this->sqlobj->process_query($database);
        $fulfill_n1 = mysql_num_rows($this->sqlobj->query);
        if ($fulfill_n1 == 0)
        	{
                echo '<br /><span class="style18">Sorry, We have not yet received your payment.</span>';
                }
		else if ($fulfill_n1 == 1)
		{
		echo'<br /><span class="style17">Your payment has been received.</span>';
                } 
       }
  function draft_details($regno,$bank,$draftno,$date)  //inserting draft details in to current semester database
       {
       $database="reg_e_11";
       $this->sqlobj->sql="INSERT INTO addnl_dd where values('$regno','$draftno','$bank','','','$date')";
       $this->sqlobj->process_query($database);
       }    
 function payment_net_challan($regno,$transactionid,$date,$branchcode)
       {
       $database="semesterfees";
       $this->sqlobj->sql="INSERT INTO transactionids VALUES('$regno','$transactionid','$date','$branchcode')";
       $this->sqlobj->process_query($database);
       }       
       }
 ?>
