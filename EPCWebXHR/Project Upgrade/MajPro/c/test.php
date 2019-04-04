 <?php 
 session_start();
      //Put session start at the beginning of the file



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
$i = $_SESSION['k'];

$sq = "UPDATE image SET status = '1' WHERE fileno = '$i'";
mysqli_query($db,$sq);
header("Location: dehaze.php");
?>