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
    $files = glob('out/*'); //get all file names
foreach($files as $file){
    if(is_file($file))
    unlink($file); //delete file
}
?>
