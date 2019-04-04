<?php

include "db.php";

$sql = "SELECT id,a,b FROM data WHERE status=0 ORDER BY RAND() LIMIT 1";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo $row["id"]. "," . $row["a"]. "," . $row["b"];
    }
} else {
    echo "0";
}

mysqli_close($conn);
?> 