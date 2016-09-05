<?php

/**
 * General academic server-specific functions
 * @TODO MAKE DOCUMENTATION!!
 */

require_once('db.inc.php');

function acad_get_cur_reg(){	//reg_?_??
	$db=get_global_db_pdo();
	$res=db_select_one("current_reg",array("cur_reg"));
	return $res['cur_reg'];
}

function acad_get_oe(){		//odd-->1 , even-->0
	//$db=get_global_db_pdo();
	//$res=db_select_one("map",array("value"),array('code'=>'odd'));
	
	return (substr(acad_get_cur_reg(),4,1)=='o')?1:0;
}

function acad_get_alias($code){	//tab.map
	$db=get_global_db_pdo();
	$res=db_select_one("map",array("value"),array("code"=>"$code"));
	return $res['value'];
}

function acad_phd_get_bra($dept){	//get branch name from department for phd
	$db=get_global_db_pdo();
	$res=db_select_one("phd.departments",array("bra"),array("deptt"=>$dept));
	return $res['bra'];
}

function acad_get_bras($prog=null){	//associative array
	$db=get_global_db_pdo();
	if($prog)
		$res=db_query_fetch_all("SELECT DISTINCT bra from prog_bra_sem_map where prog = ? ",array($prog));
	else
		$res=db_query_fetch_all("SELECT DISTINCT bra from prog_bra_sem_map");
	$bras=array();
	foreach($res as $k){
		if(($al=acad_get_alias($k['bra']))!='')
			$bras[$k['bra']]=$al;
	}		
	return $bras;
}

function acad_get_bra_max_sem($prog=null){	//associative array of bra=>max_sem
	$db=get_global_db_pdo();
	if($prog)
		$res=db_query_fetch_all("SELECT DISTINCT bra,sem from prog_bra_sem_map where prog = ? ",array($prog));
	else
		$res=db_query_fetch_all("SELECT DISTINCT bra,sem from prog_bra_sem_map");
	$bras=array();
	foreach($res as $k){
		if(($al=acad_get_alias($k['bra']))!='')
			$bras[$k['bra']]=$k['sem'];
	}		
	return $bras;
}

function acad_get_categories(){	//associative array
	$db=get_global_db_pdo();
	
	$res=db_query_fetch_all("SELECT DISTINCT category from stu_per_rec");
	$cats=array();
	foreach($res as $k){
			$cats[$k['category']]=$k['category'];
	}		
	return $cats;
}

function acad_get_progs($dept=false){	//associative ...
	$db=get_global_db_pdo();
	if($dept){
		$res=db_query_fetch_all("SELECT DISTINCT prog from prog_bra_sem_map where dept = ?",array($dept));
	}
	else{
		$res=db_query_fetch_all("SELECT DISTINCT prog from prog_bra_sem_map ");
	}
	
	$prgs=array();
	foreach($res as $k){
		if(($al=acad_get_alias($k['prog']))!='')
			$prgs[$k['prog']]=$al;
	}		
	return $prgs;
}

function acad_get_student_name($regno,$phd=false){		//get student name from tab.student
	$db=get_global_db_pdo();
	if($phd)
		$res=db_select_one("phd.stu_per_rec",array("name"),array('regno'=>$regno));
	else
		$res=db_select_one("student",array("name"),array('regno'=>$regno));
	return $res['name'];
}

function acad_get_sess(){	// 2-digit session
	$db=get_global_db_pdo();
	$res=db_select_one("map",array("value"),array("code"=>"cur_sess"));
	return $res['value'];
}

function acad_get_phd_students($prog=""){	//associative array regno--name => regno --- name
	$db=get_global_db_pdo();
	$qry="SELECT a.regno,name from phd.stu_acad_rec a inner join phd.stu_per_rec p on a.regno=p.regno where a.regno in (select reg_no from ".acad_get_cur_reg().".inst_fee)";
	if($prog!="")
		$qry.=" and prog like '$prog'";
		
	$res=db_query_fetch_all($qry);
	//print_r($res);
	$studs=array();
	foreach($res as $k){
			$studs[$k['regno'].'--'.$k['name']]=$k['regno'].' --- '.$k['name'];
	}		
	return $studs;
}

function is_registered($regno,$reg=''){		//check entry in $reg.inst_fee
	if(!$reg)
		$reg=acad_get_cur_reg();
	$db=get_global_db_pdo();
	$res=db_select_one("$reg.inst_fee",array("reg_no"),array("reg_no"=>$regno));	
	if($res)
		return true;
	else
		return false;
}

function acad_get_sems($prog){		//get sems list for program & odd/even sess
//	if($oe===false)
//		$oe=(int)acad_get_oe();	//1-->odd
	$db=get_global_db_pdo();
	$res=db_select_one("prog_bra_sem_map",array("sem"),array('prog'=>$prog),'sem ASC');
	$sems=array();
	
	for($i=1;$i<=$res['sem'];$i++){
		$sems[$i]=$i;
	}	
	return $sems;
}

function acad_post_feedback($site,$sub,$desc,$name,$comments=''){	//entry to log.suggestions
	$ip=get_ip();
	db_insert("logs.suggestions",array("site"=>$site,"category"=>"feedback","subject"=>$sub,"description"=>$desc,"ip"=>$ip,"author"=>$name,"comments"=>$comments));
}

function acad_get_photo($regno){		//return image file WARNING: header("Content-type: image/jpeg"); 
	
	$photo_id=db_select_one("icard.registeration",array("photoid"),array("regisno"=>$regno));
	$photo_id=$photo_id['photoid'];
	
	if(!$photo_id){
		$photo_id=$regno;
	}
	$photo_id= trim($photo_id);
			
	//exec("chmod 777 ".CONST_PATH_ACADS."/photos/".$photo_id.".JPG");
	
	$photoPath=CONST_PATH_ACADS."/photos/".$photo_id.".JPG";
	if(!file_exists($photoPath))
	{ header ("HTTP/1.0 404 Not Found");
	  return;
	}
   
	$size=filesize($photoPath);
   
	$fm=@fopen($photoPath,'r');
	if(!$fm)
	{ header ("HTTP/1.0 505 Internal server error");
	  return;
	}
	
	header("Content-type: image/jpeg"); 
	@readfile("$photoPath"); 
	//exec("chmod 000 ".CONST_PATH_ACADS."/photos/".$photo_id.".JPG");
}

function acad_get_photo_id($regno) 	//get photo name from icard.registeration table...if not exists, insert new entry
{
	$photo_id=db_select_one("icard.registeration",array("photoid"),array("regisno"=>$regno));
	$photo_id=trim($photo_id['photoid']);
	
	if(!$photo_id)
	{
		$photo_id=strtoupper($regno);
		db_insert("icard.registeration",array("regisno"=>$regno,"photoid"=>$photo_id));
	}
	return $photo_id;
}

function acad_unset_photo_id($photo_id)
{
	exec("chmod 000 ".CONST_PATH_ACADS."/photos/".$photo_id.".JPG"); 
}

function acad_get_spi($regno,$sem){
	$res_tab=db_select_one("tab",array('spi','result'),array('reg_no'=>$regno,'sem'=>$sem));
	if(!$res_tab) return 'N/A';
	$res_supp=db_select_one("supp",array('max(spi)'),array('reg_no'=>$regno,'sem'=>$sem),null,null,'sem');
	return max($res_supp[0],$res_tab[0]);
}

function acad_get_cpi($regno,$sem){
	$res_tab=db_select_one("tab",array('cpi','result'),array('reg_no'=>$regno,'sem'=>$sem));
	if(!$res_tab) return 'N/A';

	$res_supp=db_select_one("supp",array('max(cpi)'),array('reg_no'=>$regno,'sem'=>$sem),null,null,'sem');
	return max($res_supp[0],$res_tab[0]);
}

function acad_is_pass($regno,$sem){
	$res_tab=db_select_one("tab",array('result'),array('reg_no'=>$regno,'sem'=>$sem));
	if(!$res_tab) return 'N/A';

	if(strtoupper($res_tab['result'])=='P')
		return true;
	$res_supp=db_select_one("supp",array('cpi'),array('reg_no'=>$regno,'sem'=>$sem,'result'=>'P'));
		return $res_supp?true:false;
}

/**
 * Returns SPI, CPI, Result(P,A,N/A)
 * @param String $regno Registration No.
 * @param int $sem Semester
 * @return array() (spi,cpi,result)
 */
function acad_get_academic($regno, $sem){
	$cpi=$spi=$result='N/A';
	$res_tab=db_select_one("tab",array('spi','cpi','result'),array('reg_no'=>$regno,'sem'=>$sem),'year desc');
	if(!$res_tab)
		return array('spi'=>$spi,'cpi'=>$cpi,'result'=>$result);

	$res_supp=db_select_one("supp",array('spi','cpi','result'),array('reg_no'=>$regno,'sem'=>$sem),'depth desc');

	if($res_supp && (($res_tab['result']=='A')||$res_tab['spi']<$res_supp['spi']))
		return array('spi'=>$res_supp['spi'],'cpi'=>$res_supp['cpi'],'result'=>$res_supp['result']);

	return array('spi'=>$res_tab['spi'],'cpi'=>$res_tab['cpi'],'result'=>$res_tab['result']);
}

function res_is_backlog($grade){
	$grade=strtoupper($grade);
	if($grade=='E'||$grade=='F'||$grade=='I'||$grade=='W'||$grade=='- -'||$grade=='X' || $grade==''){
		return true;
	}
	return false;
}

function res_get_backlogs($regno,$sem=null,$year=null){
	if($sem) {
		$subs = res_get_subjects($regno, $sem);
		$back=array();
		foreach($subs as $k=>$v) {
			if (res_is_backlog(res_get_best_grade($regno, $k, $sem))) {
				$back[$k] = $v;
			}
		}
	}
	else{
		$max_sem=db_select_one("tab",array('max(sem) as sem'),array('reg_no'=>$regno));
		$max_sem=$max_sem['sem'];
		$back=array();
		for($sem=1;$sem<=$max_sem;$sem++){
			$result=acad_get_academic($regno,$sem);

			if ($result['result']=='A'){
				$back['not pass'.$sem]="NOT CLEARED (Sem -".$sem.")";
			}

			$res=res_get_backlogs($regno,$sem);
			if(!empty($res))
				$back[$sem]=$res;


		}
	}
	return empty($back)?null:$back;
}

/**
 * Returns associative array of sub_code=>subject_name in ascending order of sub_no
 * @param $regno
 * @param $sem
 * @return array associative array of sub_code=>subject_name in ascending order of sub_no
 * @throws Exception
 */
function res_get_subjects($regno, $sem){
	$db=get_global_db_pdo();
	$yr=db_select_one("tab",array('year'),array('reg_no'=>$regno,'sem'=>$sem),'year desc');
	if(!$yr)
		throw new Exception("Error: Invalid Semester $sem for $regno");
	$yr=$yr['year'];

	$subs=db_query_fetch_all("select c.code,c.`name`,s.sub_no from subject s inner join course c
			on s.sub_code=c.code and
			s.bra=c.bra and
			SUBSTRING(s.year,-2)=c.session and
			s.sem=c.sem
			where s.year=? and s.regno=? AND s.sem=? order by s.sub_no asc",array($yr,$regno,$sem));
	$res=array();
	foreach($subs as $k){
		$res[$k['code']]=$k['name'];
	}
	return $res;
}

function compare_grades($g1,$g2){
	$grade_point_old=array('A+'=>10,'A'=>9,'B+'=>'8','B'=>7,'C+'=>6,'C'=>5,'D'=>4,'E'=>2,'F'=>0,'S'=>0,'- -'=>-2,'W'=>-1,'I'=>-3,'X'=>-1);

	if(!isset($grade_point_old[$g1]))
		$grade_point_old[$g1]=-50;
	if(!isset($grade_point_old[$g2]))
		$grade_point_old[$g2]=-50;
	//echo '<br>'.$g1.'-->'.$grade_point_old[$g1].'<br>'.$g2.'-->'.$grade_point_old[$g2].'<br>';
	return $grade_point_old[$g1]>$grade_point_old[$g2];
}
function res_get_best_grade($regno,$code,$sem){
	$db=get_global_db_pdo();
	//$subjects=res_get_subjects($regno,$sem);
	$sub_num=db_select_one("subject",array('sub_no','year'),array('sub_code'=>$code,'sem'=>$sem,'regno'=>$regno),"year desc");
	if(!$sub_num)
		throw new Exception("Error: Invalid Subject Code $code for $regno");
	$sub_num='s'.$sub_num['sub_no'];

	$res_tab=db_select_one("tab",array($sub_num,'result'),array('reg_no'=>$regno,'sem'=>$sem),'year desc');

	$res_supp=db_select_all("supp",array($sub_num),array('reg_no'=>$regno,'sem'=>$sem),"depth desc");
	$best_grd=$res_tab[$sub_num];
	foreach($res_supp as $sup_grd){
		$sup_grd[$sub_num];
		if(compare_grades($sup_grd[$sub_num],$best_grd))
			$best_grd=$sup_grd[$sub_num];
	}
	return $best_grd;
}
function acad_get_course($prog, $bra = false, $sess = 0, $sem = 0){	//tab.courses non-associative(only codes)...acad_get_course_name for associative
	$db=get_global_db_pdo();
	$where=array('prog'=>$prog);
	if($bra)
		$where['bra']=$bra;
	if($sess)
		$where['session']=$sess;
	if($sem)
		$where['sem']=$sem;
	/*if($dept)
		$where['dept']=$dept;*/
	if(substr($prog,0,3)=='phd'){
		$res=db_select_all("phd.course",array("distinct code"),$where,'code ASC');
	}
	else{
		$res=db_select_all("course",array("code"),$where,'code ASC');
	}
	$ccodes=array();
	foreach($res as $k){

		array_push($ccodes,$k['code']);
	}
	return $ccodes;
}


function acad_get_course_name($prog, $bra = false, $sess = 0, $sem = 0){	//tab.courses associative
	$db=get_global_db_pdo();
	$where=array('prog'=>$prog);
	if($bra)
		$where['bra']=$bra;
	if($sess)
		$where['session']=$sess;
	if($sem)
		$where['(sem='.(int)$sem.' or sem='.((int)$sem+1).') and 1']=1;
	/*if($dept)
		$where['dept']=$dept;*/

	if(substr($prog,0,3)=='phd'){
		$res=db_select_all("phd.course",array("distinct code","name"),$where,'code ASC');
	}
	else{
		$res=db_select_all("course",array("distinct code","name"),$where,'code ASC');
	}
	$ccodes=array();
	foreach($res as $k){
		$ccodes[$k['code']]=$k['code'].' --> '.$k['name'];
	}
	return $ccodes;
}
?>