<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of miscfunctions
 *
 * @author hemesh
 */
class miscfunctions
{
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
}
?>
