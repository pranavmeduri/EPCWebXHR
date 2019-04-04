<?php 
//include 'db.php';
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
         
if(isset($_POST['submit'])){
 // Count total files
 $countfiles = count($_FILES['file']['name']);
 
 // Looping all files
 for($i=0;$i<$countfiles;$i++){
   $filename = $_FILES['file']['name'][$i];
   //$status=0;
   //$insert ="INSERT INTO `image` (`fileno`, `status`, `time`) VALUES ('$x', NULL, CURRENT_TIMESTAMP)";
   // Upload file
   move_uploaded_file($_FILES['file']['tmp_name'][$i],'c/in/'.$filename);
 
    
 }
 $dir = "c/in/";

$a = scandir($dir);

            for ($x = 2; $x < count($a); $x++) {
          	$i = $a[$x];
            	$i = (int)substr($i, 2, 4);
       $sql = "INSERT INTO `image` (`fileno`, `status` ) VALUES ('$i', NULL)";
       mysqli_query($db,$sql);
	}
	
/*	
ignore_user_abort(1); // run script in background
set_time_limit(0); // run script forever
$interval=60*1; // do every 15 minutes...
do{
  
  
  
  
   sleep($interval); // wait 15 minutes
}while(true);
*/
}
header("Location: ."); 
?>