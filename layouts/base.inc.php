<?php 
function layout_head() {
?><head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Administrative Portal, Dean Academics">
    <meta name="author" content="WebTeam, Dean Academics">

    <title>Admin Portal</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=CONST_PATH_CSS?>/bootstrap.min.css" rel="stylesheet">
    
    
    <!-- Custom CSS -->
    <link href="<?=CONST_PATH_CSS?>/sb-admin.css" rel="stylesheet">

     <!-- Custom Fonts -->
    <link href="<?=CONST_SITE_URL?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<?php 
}

function layout_navbar($active="normal") {
?>
        <!-- Navigation -->
        


<div id="cover"><div>Please Wait...<br><br><span style="font-size:12px">( if this screen is showing too long, click <a href="<?=CONST_SITE_URL?>/index.php">here</a> to exit and contact Webteam )</span></div></div>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=CONST_SITE_URL?>/index.php">Admin Portal</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li class="dropdown"  id="rsy">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?='Anar'?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=CONST_SITE_URL?>/index.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        
                        
                        <li class="divider"></li>
                        <li>
                            <a href="<?=CONST_SITE_URL?>/logout_main.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="<?=get_file_name()?>">
                <ul class="nav navbar-nav side-nav">
                <li <?=(get_file_name()=='index.php'?'class="active"':'')?>>
                    <a href="<?=CONST_SITE_URL?>/index.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                
                <li <?=(substr(get_file_name(),0,7)=='student'?'class="active"':'')?>>
                    <a href="<?=CONST_SITE_URL?>/student/student_p1.php"><i class="fa fa-fw fa-user"></i> Edit Student</a>
                </li>
                
                <li <?=(substr(get_file_name(),0,7)=='queries'?'class="active"':'')?>>
                    <a href="<?=CONST_SITE_URL?>/queries/queries_p1.php"><i class="fa fa-fw fa-user"></i> Queries</a>
                </li>
                <!--<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#ncourse"><i class="fa fa-fw fa-arrows-v"></i><span data-toggle="tooltip"  data-placement="bottom" title="(B.Tech, M.Tech, M.Sc, MBA, MSW, MCA)">Normal Courses</span><i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="ncourse" class='collapse <?=($active=="normal")?"active in":""?>'>
                            
                            <li <?=(get_file_name()=='add_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/add_course.php"><i class="fa fa-fw fa-plus"></i> Add Course</a>
                            </li>
                            <li <?=(get_file_name()=='edit_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/edit_course.php"><i class="fa fa-fw fa-edit"></i> Edit Course</a>
                            </li>
                            <li <?=(get_file_name()=='remove_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/remove_course.php"><i class="fa fa-fw fa-trash"></i> Remove Course</a>
                            </li>
                            <li <?=(get_file_name()=='print_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/print_course.php"><i class="fa fa-fw fa-print"></i> Print Course</a>
                            </li>
                          </ul>
                    </li>-->
                    <!--<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> PhD Courses <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class='collapse <?=($active=="phd")?"in":""?>'>
                           <li <?=(get_file_name()=='phd_add_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/phd/phd_add_course.php"><i class="fa fa-fw fa-plus"></i> Add Course</a>
                            </li>
                            <li <?=(get_file_name()=='phd_edit_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/phd/phd_edit_course.php"><i class="fa fa-fw fa-edit"></i> Edit Course</a>
                            </li>
                             <li <?=(get_file_name()=='phd_remove_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/phd/phd_remove_course.php"><i class="fa fa-fw fa-trash"></i> Remove Course</a>
                            </li>
                             <li <?=(get_file_name()=='phd_print_course.php'?'class="active"':'')?>>
                                <a href="<?=CONST_SITE_URL?>/phd/phd_print_course.php"><i class="fa fa-fw fa-print"></i> Print Course</a>
                            </li>
                        </ul>
                    </li>-->
                    <li <?=(get_file_name()=='feedback.php'?'class="active"':'')?>>
                        <a href="<?=CONST_SITE_URL?>/feedback.php"><i class="fa fa-fw fa-comment"></i> Feedback</a>
                    </li>
                    <li <?=(get_file_name()=='about.php'?'class="active"':'')?>>
                        <a href="<?=CONST_SITE_URL?>/about.php"><i class="fa fa-fw fa-question-circle"></i> About </a>
                    </li>
                    <li >
                        <a href="<?=CONST_SITE_URL?>/logout_main.php"><i class="fa fa-fw fa-sign-out"></i> Logout </a>
                    </li>
                    <!--<li>
                        <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
        
<?php 
}



function layout_scripts(){
?>

<nav class="navbar navbar-default navbar-fixed-bottom" style="margin-bottom:-15px;">
    <div class="container" align="center" style="margin-top:8px">
            Designed By <a href="mailto:webteam.academic@mnnit.ac.in" id="webteam">Webteam, Dean Academics</a>
    </div>
</nav>
     <!-- jQuery -->
    <script src="<?=CONST_PATH_JS?>/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=CONST_PATH_JS?>/bootstrap.min.js"></script>
    
     <!-- BootBox -->
    <script src="<?=CONST_PATH_JS?>/bootbox.min.js"></script>
    
    <script>
	$(document).ready(function(e) {
		$('[data-toggle="tooltip"]').tooltip(); 
		
		$("#webteam").click(function(e){
			//e.preventDefault();
			bootbox.alert("<br><dl class='dl-horizontal'><dt>Designed By:</dt><dd><a href='mailto:webteam.academic@mnnit.ac.in'>Anaranya Sen</a>, B.Tech CSE 2016<br>Webteam, Dean Academics</dd>");
		})
		
        $(document).ajaxStart(function() {
            $("#cover").css("display","block").css("pointer-events","auto");
        });
		$(document).ajaxSuccess(function() {
            $("#cover").css("display","none").css("pointer-events","none");
        });
    });
    </script>
    
<?php
}

function get_pagination(array $pages,$active){	
	?>
    <div class="text-center">
      <ul class="pagination no-padding-or-margin">
      <?php 
	  $k=1;
	  foreach($pages as $pg){ ?>
      <li <?=($pg==$active)?'class="active"':''?>><a href="<?=$pg?>"><?=$k++?></a></li>
      <?php } ?>
      </ul>
    </div><br><br>
	
    <?php
}
?>