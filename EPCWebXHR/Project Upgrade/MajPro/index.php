<center>

<br>An Application of<br>
" <b>Embrasingly Parallel Computations over the Web using XAMPP stack</b> "<br>
for Haze Removal<br>

<br><hr><center><br>

<?php

$page = $_SERVER['PHP_SELF'];
$sec = "5";
header("Refresh: $sec; url=$page");
$dir = "c/in/";
$a = scandir($dir); //Sort in ascending order
//print_r($a);

$dir2 = "c/out/";
$b = scandir($dir2); //Sort in ascending order
//print_r($b);

if(count($a)<=2 && count($b)>2)
{
echo "Processing finished <br><br> ";
/*$page = $_SERVER['PHP_SELF'];
$sec = "10";
header("Refresh: $sec; url=$page");*/
?>

<p><b>Step - 4 : </b><a href="zip.php">Download the Zip File</a></p><br><br>
<p><b>Step - 5 :</b><a href="delete.php">Clean all the images in the folder</a></p>

<?php
die();
}

if(count($a)<=2)
{
?>

<p><b>Step - 1 : Extract all the Frames from a Fog Video</b><br>
(Hint: You may use the following free converter)<br>
https://www.dvdvideosoft.com/products/dvd/Free-Video-to-JPG-Converter.htm</p><br>

<p><b>Step - 2 : </b><a href="in.html">Click here to UPLOAD ALL the extracted FRAMES</a></p><br>

<?php
}
else {
	

echo "Number of Image(s) left to be processed = ".(count($a)-2);

$dbHost     = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName     = 'image';
       
        
        //Create connection and select DB
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        
        // Check connection
        if($db->connect_error){
            die("Connection failed: " . $db->connect_error);
            }
            $dir = "c/in/";

/*$a = scandir($dir);

            for ($x = 2; $x < count($a); $x++) {
          	$i = $a[$x];
            	$i = (int)substr($i, 2, 4);
       $sql = "INSERT INTO `image` (`fileno`, `status` ) VALUES ('$i', NULL)";
       mysqli_query($db,$sql);
	}
	*/
	
}
//echo $i;
?>
<!--
<p><b>Step - 3 : </b><a href="dehaze.php">Click here to ENROLL this Machine into Haze Removal Process</a></p>
-->
<?php

?>

<br><hr>
