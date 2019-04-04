<html>
<head>
<meta http-equiv="refresh" content="2; URL=http://localhost/MajPro/">
<meta name="keywords" content="automatic redirection">
</head>
<body>
<h1 style="text-align:center;">Deleting Files</h1>
<p style="text-align:center;">redirecting in 2 seconds</p>

</body>
</html>



<?php
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
$sql = "delete from image";
mysqli_query($db,$sql);

    $files = glob('c/out/*'); //get all file names
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
}
//header("Location: index.php");
?>
