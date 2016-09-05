<?php

//SITE SPECIFIC FUNCTIONS , CONSTS, VARS SET HERE 

	const CONST_PATH_BASE='/var/www/html/academics/acadserver/academic_new/adm2016/admission2016';
	require_once(CONST_PATH_BASE.'/included/config.inc.php');
	require_once(CONST_PATH_INCLUDE.'/db.inc.php');
	require_once(CONST_PATH_INCLUDE.'/general.inc.php');
	require_once(CONST_PATH_INCLUDE.'/acads.inc.php');
	require_once(CONST_PATH_LAYOUTS.'/base.inc.php');
	require_once(CONST_PATH_LAYOUTS.'/forms.inc.php');
	require_once(CONST_PATH_LAYOUTS.'/login_dialog.inc.php');
	date_default_timezone_set('Asia/Calcutta');


//_________________________Map from display ids to table fieldnames lists_______________________________

$stu_acad_rec_map=array(
	'__table_name'=>'stu_acad_rec',
	'registration_no'=>'regno',
	'name'=>'name',
	'program'=>'prog',
	'branch'=>'bra',
	'department'=>'dept',
	'semester'=>'sem_adm_to',
	'session'=>'session',
	'nationality'=>'nationality'	
);	
$stu_acad_det_map=array(
	'__table_name'=>'stu_acad_det',
	'registration_no'=>'regno',
	'branch'=>'bra',
	'department'=>'dept',
	'semester'=>'sem_adm_to',
);	
$stu_per_rec_map=array(
	'__table_name'=>'stu_per_rec',
	'registration_no'=>'regno',
	'fathers_name'=>'father_name',
	'date_of_birth'=>'dob',
	'phone_no'=>'phone',
	'mobile_no'=>'mobile',
	'email'=>'email',
	'address'=>'address',
	'blood_group'=>'blood_grp',
	'sex'=>'sex',
	'state'=>'state',
	'category'=>'category'
);	

$phd_stu_acad_rec_map=array(
	'__table_name'=>'phd.stu_acad_rec',
	'registration_no'=>'regno',
	'program'=>'prog',
	'stream'=>'stream',
	'program type'=>'prog_type',
	'semester'=>'sem_adm_to',
	'session'=>'session',
	'nationality'=>'nationality'
);	

$phd_stu_per_rec_map=array(
	'__table_name'=>'phd.stu_per_rec',
	'registration_no'=>'regno',
	'name'=>'name',
	'fathers_name'=>'father_name',
	'date_of_birth'=>'dob',
	'phone_no'=>'phone',
	'mobile_no'=>'mobile',
	'email'=>'email',
	'address'=>'address',
	'blood_group'=>'blood_grp',
	'sex'=>'sex',
	'state'=>'state',
	'category'=>'category',
	'nationality'=>'nationality'
);	

$new_data_map=array(
	'__table_name'=>'new_data',
	'registration_no'=>'regno',
	'religion'=>'religion',
	'caste'=>'caste',
	'nationality'=>'nationality',
	'fathers_occupation'=>'f_occ',
	'fathers_annual_income'=>'f_ann_income',
	'mothers_name'=>'m_name',
	'local_guardian_address'=>'loc_add',
	'handicap_type'=>'TYPE',
	'hindi_name'=>'hindi',
	'caution_alumni'=>'caution_alumni',
	'ifsc_code'=>'ifsc',
	'account_no'=>'acc_no',
	'bank_branch'=>'bbrn'
);	


$phd_admitted_map=array(
	'__table_name'=>'phd.admitted',
	'registration_no'=>'regno',
	'semester'=>'sem',
	'oe'=>'oe'
);

$reg_type_accod_map=array(
	'__table_name'=>'reg_type_accod',
	'registration_no'=>'regno',
	'accomodation'=>'accomodation'
);

$bank_detail_map=array(
	/*'id'=>'id',*/
	'__table_name'=>'fee.bank_detail',
	'registration_no'=>'regno',
	'reference_no'=>'refno',
	'date_generated'=>'date_gen',
	'transaction_id'=>'transaction_id',
	'date_received_bank'=>'date_recv',
	'amount'=>'amount',
	'session'=>'session',
	'semester'=>'sem',
	'transaction_purpose'=>'purpose',
	'transaction_status'=>'status',
	'transaction_status_desc'=>'status_desc',
	'remark'=>'remark'
);

$addnl_dd_map=array(
	'__table_name'=>'addnl_dd',
	'registration_no'=>'reg_no',
	'draft_no'=>'count',
	'draft_no'=>'ddno',
	'bank_name'=>'bankname',
	'bank_branch'=>'branch',
	'amount'=>'amount',
	'currency'=>'curr',
	'dd_date'=>'date',
	'accounts_receipt_no'=>'rcpt_no',
	'user'=>'user',
	'accounts_book_no'=>'bookno',
	'accounts_submission_date'=>'sub_date'
);

$inst_fee_map=array(
	'__table_name'=>'inst_fee',
	'registration_no'=>'reg_no',
	'receipt_no'=>'rcpt_no',
	'registration_counter'=>'counter',
	'registration_date'=>'date'
);


$stu_acad_rec_cols=db_col_names('tab','stu_acad_rec');
$stu_per_rec_cols=db_col_names('tab','stu_per_rec');
$new_data_cols=db_col_names('tab','new_data');
$phd_stu_acad_rec_cols=db_col_names('tab','phd_stu_acad_rec');
$phd_stu_per_rec_cols=db_col_names('tab','phd_stu_per_rec');

//_________________________Composite keys_______________________________
//$composite_key=array('code','name','dept','prog','bra','sem','session');
//$phd_composite_key=array('code','name','prog','sem','session','eid');

//_________________________Table fieldname lists_______________________________
//$marks_map=acad_get_course_map_type();
//$course_cols=db_col_names('tab','course');
//$phd_course_cols=array('eid','credit','elective','elec_name','cord','thesis');//db_col_names('phd','curr_course');
//$cmd_cols=db_col_names('tab','course_map_detail');
//$teaching_cols=db_col_names('tab','teaching');

//$phd_course_ins_cols=db_col_names('phd','curr_course');		//USE THIS!!! NOT phd_course
//$phd_ccm_cols=db_col_names('phd','curr_course_marks');
//$phd_admitted_cols=db_col_names('phd','admitted');//array('regno','sem','oe');

//_________________________Pagination page lists_______________________________
$add_course_pgs=array('add_course.php','add_course_p2.php','add_course_p3.php','add_course_p4.php');
$phd_add_course_pgs=array('phd_add_course.php','phd_add_course_p2.php','phd_add_student.php','phd_add_course_p3.php');
$edit_course_pgs=array('edit_course_p2.php','edit_course_p3.php');	
$phd_edit_course_pgs=array('phd_edit_course_p2.php','phd_edit_course_p3.php');	
//____________________________________________________________________________

	session_start();
	//authenticate();
	function get_admses_var($var){
		return isset($_SESSION['admses'][$var])?$_SESSION['admses'][$var]:'';
	}
	function set_admses_var($var,$val){
		$_SESSION['admses'][$var]=$val;
	}
	function allot_admses_var(){
		 foreach($_SESSION['admses'] as $var=>$val){
			 if(is_array($val)){
				 
				 //continue;
				 /*
				foreach($val as $k){ ?>
				 	$("#<?=$var?> option[value='<?=$k?>']").prop("selected", true);
				 	
                 <?php
				 } */?>
                 $("#<?=$var?>").val(['<?=implode("','",$val)?>']).trigger('liszt:updated');
                 $("#<?=$var?>").val(['<?=implode("','",$val)?>']).trigger("chosen:updated");
                 <?php 
			 }
			  else{
			  ?>
             
			  $("#<?=$var?>").val("<?=trim(preg_replace('/\s+/', ' ', $val))?>");	//replace line breaks-- Major bug resolved 7/2/2016
			  <?php
			  }
		  }
	}
	function req_to_admses(){
		foreach($_REQUEST as $var=>$val){
			$_SESSION['admses'][$var]=$val;
		}
	}
	function post_to_admses(){
		foreach($_POST as $var=>$val){
			$_SESSION['admses'][$var]=$val;
		}
	}
	function authenticate(){
		if(get_sess_var('status')<=1)
			header('location:https://172.31.100.19/adm2016/admission2016/index.php');

	}
	
	/*if(!in_array(get_file_name(),array("convodata.php","convodata_p2.php","cont_convodata.php")))
	authenticate();*/
?>
