
<?php 

session_start();
      //Put session start at the beginning of the file
$i =  $_POST['imgname'];
$i = (int)substr($i, 2, 4);
$_SESSION['k'] = $i;
$img = $_POST['img'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = 'out/'.$_POST["imgname"];
$file = substr($file, 0, -4);	
			//Removing .jpg extension	
			
$file = $file.".png";						//Adding .png extension
   
if (file_put_contents($file, $data)) {
   echo "<p>The canvas was saved as $file.</p>";

$f = "in/".$_POST["imgname"];
if (!unlink($f))
  {
  echo ("Error deleting $f");
  }
else
  {
  echo ("Deleted $f");
  }   

header("Location: test.php");   
   
} else {
   echo "<p>The canvas could not be saved.</p>";
}   
?>