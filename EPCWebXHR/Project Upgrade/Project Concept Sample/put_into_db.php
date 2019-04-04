<?php

include "db.php";

$sql = "UPDATE data SET status=1, result={$_GET["result"]} WHERE id={$_GET["id"]}";

if (mysqli_query($conn, $sql)) {
   echo "1";
} else {
   echo "0";
}

mysqli_close($conn);
?> 