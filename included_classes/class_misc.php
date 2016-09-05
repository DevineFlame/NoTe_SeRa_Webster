<?php
require_once("class_sql.php");
class miscfunctions
{
    private $sql;

	
	public function redirect($url)
    {
        echo '<script type="text/javascript">';
        echo "window.location.href= \"$url\"  ";
       	echo '</script>';
    }
    public function palert($message,$tourl)
    {
      echo "<script> alert( \"$message\" ); </script>";
        $this->redirect($tourl);
    }
	public function palert2($message)
    {
      echo "<script> alert( \"$message\" ); </script>";
     
    }
    
    public function getMacAddress(){
        $location = `which arp`; 
        $arpTable = `$location`; 
        $arpSplitted = split("\n",$arpTable); 
        $remoteIp = $GLOBALS['REMOTE_ADDR'];  
        foreach ($arpSplitted as $value) { 
            $valueSplitted = split(" ",$value); 
            foreach ($valueSplitted as $spLine) { 
                if (preg_match("/$remoteIp/",$spLine)) { 
                    $ipFound = true; 
                 } 
            if ($ipFound) { 
                reset($valueSplitted); 
                foreach ($valueSplitted as $spLine) { 
                    if (preg_match("/[0-9a-f][0-9a-f][:-]". 
                         "[0-9a-f][0-9a-f][:-]". 
                         "[0-9a-f][0-9a-f][:-]". 
                         "[0-9a-f][0-9a-f][:-]". 
                         "[0-9a-f][0-9a-f][:-]". 
                         "[0-9a-f][0-9a-f]/i",$spLine)) { 
                            return $spLine; 
                    } 
                } 
            } 
            $ipFound = false; 
            } 
        } 
        return false; 
}  

    public function getUpdates()
	{ 
		$sql=new sqlfunctions();	
		$sql->connect_db("mainsite");
		$sql1="SELECT * FROM updates WHERE display LIKE \"y\" ORDER BY pref DESC";
		$sql->query=$sql->process_query($sql1);
		?>
        <div id="leftheading">
        <div class="heading"> News &amp; Updates</div><br />
         </div>
		
		<?php
		while($array=mysql_fetch_array($sql->query))
		{
			$id=$array['pref'];	
			$title=$array['title'];
			$text=$array['text'];
			$date=$array['date'];
		?>	
         	<div class="lefttxtblank">
			
          <div class="leftboldtxtblank">
            <div class="leftboldtxt" style=""><font size="3px"><strong><?php echo $title;?></strong></font></div>
            <div class="lefttxt">-<?php echo $date;?></div></div></div>
		  <div class="leftnormaltxtblank">
		  <br />
          <div class="leftnormaltxt" style="font-size:13px;"><?php echo $text;?></div>
            </div>
        <?php 
		}
		
	}
	
	public function getFooter()
	{
		?>
        <div id="footerbg">
  <div id="footerblank">
    <div id="footer"><br />
       <div id="copyrights"><font color="red"> <strong>This Site works best when viewed in Mozilla Firefox (3.6.1 or higher)</strong></font></div>
      <div id="copyrights"> Copyright &copy MNNIT Allahabad. All rights reserved.</div>
      <div id="designedby">Designed by
	  Webteam,DEAN (ACADEMICS)
	  </div>
      </div>
  </div>
</div>

<?php
	}
	public function Extension($name)
		{
			$pos=strpos($name,'.');
			return substr($name,$pos+1,3);
		}
}
?>
