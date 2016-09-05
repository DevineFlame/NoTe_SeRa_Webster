<?php
include_once('included/config_db_feedback.inc.php');
include_once('included/db.inc.php');
include_once('fusioncharts/fusioncharts.php');
include_once ('json_string.php');

$db=get_global_db_pdo();
// get the data semester wise1


$sql="select distinct dept from teaching";  //  to get the names of the  departments
$dept_result=db_query($sql);
//print_r($dept_result);

$dept="csed";
$what_sem=0;
$year=2016;
$odd_sem=0;  // for odd sem put 1
$teacher_raw_json = array();
$size_of_data = array();
$teacher_raw_data = 0;

for($j=0;$j<4;$j++) {        //loop for semester
    $sem = ($j+1)*2-$odd_sem;

    $sql = "SELECT year,course_no,course_title,instructor_name,ROUND(AVG((`course_1`+`course_2`+`course_3`+`course_4`+`course_5`+`course_6`+`course_7`+`course_8`+`course_9`\n"
        . "+`course_10`+`course_11`+ `course_12`+ `course_13`+ `course_14`+ `course_15`)/12),2) as satisfaction_score FROM `course` WHERE\n"
        . "course_no in (\n"
        . "SELECT distinct code FROM `teaching` where prog=\"bt\" and dept='$dept' \n"
        . "ORDER BY `teaching`.`sem` ASC) and instructor_name not like \"\" and semester=$sem and year=$year GROUP by instructor_name order by satisfaction_score ASC";

    $data_result = db_query($sql);
//print_r($data_result);




    $size_of_data[$j] = sizeof($data_result); // size of each barnch codes
    //  echo "<h4> $sem    </h4><br>";
    //  print_r($size_of_data);

    for ($i = 0; $i < $size_of_data[$j]; $i++) {          //loop for subjects in that semester

        $teacher_raw_data = $data_result[$i];
        // print_r($teacher_raw_data);

        $sat_val = $teacher_raw_data["satisfaction_score"];
        $sat_val = ($sat_val * 100) / 4;
        $teacher_raw_json[$j][$i] = give_circular_teacher_json($teacher_raw_data, $teacher_raw_data["course_title"],
            $teacher_raw_data["instructor_name"], $sat_val, "problmatic", "excellent");
        // print_r($teacher_raw_json[$j][$i]);
    }

}



?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>performance of student</title>
    <script src="fusioncharts/js/fusioncharts.js"></script>
    <script src="fusioncharts/js/fusioncharts.charts.js"></script>
    <script src="fusioncharts/js/fusioncharts.widgets.js"></script>

    <style>
        /* Note: Try to remove the following lines to see the effect of CSS positioning */
        .affix {
            top: 0;
            width: 100%;
        }

    </style>

</head>
<body>
<?php



//$stu_chart=  new FusionCharts("doughnut2D", "myFirstChart42" , "70%", "70%", "cse", "jsonurl","data/branch_wise.json");
//$stu_chart->render();
?>


<div class="panel panel-info">
    <div class="panel-heading">Teacher Student Relationship Based on the feedback</div>
</div>

<div class="container" style="padding: 0%;margin: 0%;height: 100%;width: 100%">
    <div class="col-lg-12" style="padding: 0%;margin: 0%;width: 100%"> <!-- required for floating -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs   nav-pills  " data-spy="affix" data-offset="200" ><!-- 'tabs-right' for right tabs -->
            <li class="active"><a href="#cse" data-toggle="tab">CSE</a></li>

            <?php                // code to automatically generate the dept list
            for($i=0;$i<sizeof($dept_result);$i++){
                $dept_name=$dept_result[$i]["dept"];
                echo " <li><a   href=' #".$dept_name."'  data-toggle='tab'>".$dept_name."</a></li> ";
            }

            ?>
        </ul>
    </div>
    <div class="col-lg-12">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="cse">
                <div>
                    <nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="450">
                        <ul class="nav navbar-nav">
                            <?php

                            for($i=0;$i<4;$i++) {          //name the semester
                                $sem=($i+1)*2-$odd_sem;

                                echo "<li><a href='#csed_$sem'>SEMESTER $sem</a></li>";

                            }

                            ?>
                        </ul>
                    </nav>
                    <ul>
                        <?php

                        for($j=0;$j<4;$j++) {   //loop for semester
                            if($size_of_data[$j]==0)
                                continue;
                            $sem = ($j + 1) * 2 - $odd_sem;
                            echo "<div class='container-fluid'><ul class='list-unstyled'>";

                            echo "<li id='csed_$sem'><h3 class='page-header '>SEMESTER $sem </h3></li>";


                            for ($i = 0; $i < $size_of_data[$j]; $i++) {   // loop for subjects
                                $id = "teach_sem_chart_cse" . "$i" . "$j";

                                $unique_chart_id = "teach_sem_A_cse" . "$i" . "$j";

                                // echo $id."  ".$unique_chart_id;
                                echo "<li id=$id class='col-sm-4 list-group-item' style='padding: 0%;margin-left: 0%;'>";
                                $angularChart = new FusionCharts("AngularGauge", $unique_chart_id, "100%", "200", $id, "json", $teacher_raw_json[$j][$i]);
                                $angularChart->render();


                                echo " </li>";
                            }
                            echo "</ul></div>";
                        }
                        ?>


                    </ul>
                </div>


            </div>

            <div class="tab-pane" id="profile">Profile Tab.</div>
            <div class="tab-pane" id="messages">Messages Tab.</div>
            <div class="tab-pane" id="settings">Settings Tab.</div>

            <?php                // code to automatically generate the dept list
            for($i=0;$i<sizeof($dept_result);$i++) {
                $dept_name = $dept_result[$i]["dept"];
                echo "<div class='tab-pane' id='" . $dept_name . "''>";
                echo $dept_name;
                ?>
                here you can do what you want
                <?php
                echo "</div>";
            }// for loop ends here
            ?>
        </div>
    </div>
</div
