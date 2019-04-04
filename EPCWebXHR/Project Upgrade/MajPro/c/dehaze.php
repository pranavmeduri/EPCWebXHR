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
$dir = "in/";

$a = scandir($dir);
print_r($a);
loop:
if(count($a)<=2)
{
//$page = $_SERVER['PHP_SELF'];
//$sec = "10";
//header("Refresh: $sec; url=$page");
//header("Location: opt/lampp/htdocs/MajPro/index.php/ ");
?>
<!DOCTYPE html>
<html>
<body bgcolor="#ADD8E6">
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<center><h1>   Image processing finished </h1></center>
<br>
<br>
<center><a href="finish.php">Click Here to download Images</a></center>
</body>
</html>

<?php
die();

}

$i = rand(2,count($a)-1);
$x = $a[$i];
$x = (int)substr($x, 2, 4);
$sql = "SELECT sent from image where fileno = '$x'";
$return = mysqli_query($db,$sql);
$row = $return->fetch_assoc();
//echo $return;
if ($row['sent'] == '0')
{
echo "<br>".$i."<br>";
echo $a[$i]."<br>";
$sq = "UPDATE image SET sent = '1',time = CURRENT_TIMESTAMP() WHERE fileno = '$x'";
mysqli_query($db,$sq);
}
else {
	$sq = "select time from image where fileno = '$x'";
	$ti = mysqli_query($db,$sq);
	
	$ro = $ti->fetch_assoc();
	$mro = (int)substr($ro['time'], 3, 5);
	$sro = (int)substr($ro['time'], 6, 9);
	$sumro = $mro*60+$sro; 
	$dt = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
   $d = $dt->format('H:i:s');
$ctm = (int)substr($d, 3, 5);
	$cts = (int)substr($d, 6, 9);
	$sumc = $ctm*60+$cts;
	$thres = $sumc - $sumro;
	if($thres < 10)
	goto loop;
}
?>

<script src="lib/utils.js"></script>
<script async="" src="lib/opencv.js" id="opencvjs"></script>

<body onload="hazeRemoveExecuteCode()">

<textarea rows="18" cols="100" id="hazeRemoveTestCode" spellcheck="false" style="display:none">
function quickSort(s, l, r, k) {
    if (l &lt; r) {
        let i = l, j = r;
        let x = s[l];
        while (i &lt; j) {
            while (i &lt; j &amp;&amp; s[j][2] &lt; x[2])
                --j;
            if (i &lt; j)
            { s[i++] = s[j]; }
            while (i &lt; j &amp;&amp; s[i][2] &gt;= x[2])
                ++i;
            if (i &lt; j)
                s[j--] = s[i];
        }
        s[i] = x;
        if (i &gt; k) {
            quickSort(s, l, i - 1, k);
        }
        if (k &gt; i) {
            quickSort(s, i + 1, r, k - i);
        }
    }
}

function Producedarkimg(image, w) {
    // Get channel min image
    let min = 255;
    let radius = Math.round((w - 1) / 2);
    let row = image.rows;
    let col = image.cols;
    let darkImg = new cv.Mat(row, col, cv.CV_8UC1);
    let B, G, R;

    for (let i = 0; i &lt; row; ++i) {
        for (let j = 0; j &lt; col; ++j) {
            R = image.ucharPtr(i, j)[0];
            G = image.ucharPtr(i, j)[1];
            B = image.ucharPtr(i, j)[2];
            min = min &gt; R ? R : min;
            min = min &gt; B ? B : min;
            min = min &gt; G ? G : min;
            darkImg.ucharPtr(i, j)[0] = min;
            min = 255;
        }
    }

    // Get window min image
    let rowMinImg = new cv.Mat(row, col, cv.CV_8UC1);
    let darkFilterImg = new cv.Mat(row, col, cv.CV_8UC1);

    for(let j = 0; j &lt; row; ++j) {
        L = [];
        min = 255;
        for (let i = 0; i &lt; radius; ++i) {
            if (darkImg.ucharPtr(j, i)[0] &lt; min)
                min = darkImg.ucharPtr(j, i)[0];
            rowMinImg.ucharPtr(j, i)[0] = min;
        }
        for (let i = 1; i &lt; col; ++i) {
            if (i &gt;= w) {
                rowMinImg.ucharPtr(j, i - radius - 1)[0] = darkImg.ucharPtr(j, L.length &gt; 0 ? L[0] :i - 1)[0];
            }
            if (darkImg.ucharPtr(j, i)[0] &gt; darkImg.ucharPtr(j, i - 1)[0]) {
                L.push(i - 1);
                if (i == w + L[0])
                    L.shift();
            }
            else {
                while (L.length &gt; 0) {
                    if (darkImg.ucharPtr(j, i)[0] &gt;= darkImg.ucharPtr(j, L[L.length - 1])[0]) {
                        if (i == w + L[0])
                            L.shift();
                        break ;
                    }
                    L.pop();
                }
            }
        }
        rowMinImg.ucharPtr(j, col - radius - 1)[0] = darkImg.ucharPtr(j, L.length &gt; 0 ? L[0] : col - 1)[0];
        min = 255;
        for (let i = col - 1; i &gt;= col - radius; --i) {
            if (darkImg.ucharPtr(j, i)[0] &lt; min)
                min = darkImg.ucharPtr(j, i)[0];
            rowMinImg.ucharPtr(j, i)[0] = min;
        }
    }
    
    for(let j = 0; j &lt; col; ++j) {
        L = [];
        min = 255;
        for (let i = 0; i &lt; radius; ++i) {
            if (rowMinImg.ucharPtr(i, j)[0] &lt; min)
                min = rowMinImg.ucharPtr(i, j)[0];
            darkFilterImg.ucharPtr(i, j)[0] = min;
        }
        for (let i = 1; i &lt; row; ++i) {
            if (i &gt;= w) {
                darkFilterImg.ucharPtr(i - radius - 1, j)[0] = rowMinImg.ucharPtr(L.length &gt; 0 ? L[0] : i - 1, j)[0];
            }
            if (rowMinImg.ucharPtr(i, j)[0] &gt; rowMinImg.ucharPtr(i - 1, j)[0]) {
                L.push(i - 1);
                if (i == w + L[0])
                    L.shift();
            }
            else {
                while (L.length &gt; 0) {
                    if (rowMinImg.ucharPtr(i, j)[0] &gt;= rowMinImg.ucharPtr(L[L.length - 1], j)[0]) {
                        if (i == w + L[0])
                            L.shift();
                        break;
                    }
                    L.pop();
                }
            }
        }
        darkFilterImg.ucharPtr(row - radius - 1, j)[0] = rowMinImg.ucharPtr(L.length &gt; 0 ? L[0] : row - 1, j)[0];
        min = 255;
        for (let i = row - 1; i &gt;= row - radius; --i) {
            if (rowMinImg.ucharPtr(i, j)[0] &lt; min)
                min = rowMinImg.ucharPtr(i, j)[0];
            darkFilterImg.ucharPtr(i, j)[0] = min;
        }
    }
    rowMinImg.delete();
    darkImg.delete();
    return darkFilterImg;
}

function getatmospheric_light(image, darkimg)
 {
    // Get A
    let row = darkimg.rows;
    let col = darkimg.cols;
    let darksize = row * col;
    let topsize = Math.ceil(darksize / 1000);
    let A = Array(3);
    let allpixels = Array(row * col);

    for (let i = 0; i &lt; row; i++)
       for (let j = 0;j &lt; col;j++)
            {
                let Pixel = [i, j, darkimg.ucharPtr(i, j)[0]];
                allpixels[i * col + j] = Pixel;
            }

    // Sort k maximum number
    let tmp = allpixels[0];
    allpixels[0] = allpixels[allpixels.length - 1];
    allpixels[allpixels.length - 1] = tmp;
    quickSort(allpixels, 0, allpixels.length - 1, topsize);

    let R, G, B, sum;
    let max = 0, maxi, maxj, x, y;
    for (let i = 0; i &lt; topsize; i++) {
       x = allpixels[i][0];
       y = allpixels[i][1];
       R = image.ucharPtr(x, y)[0];
       G = image.ucharPtr(x, y)[1];
       B = image.ucharPtr(x, y)[2];
       sum = R * 0.299 + G * 0.587 + B * 0.114;
       if (max &lt; sum) {
           max = sum;
           maxi = x;
           maxj = y;
       }
    }
    A[0] = image.ucharPtr(maxi, maxj)[0];
    A[1] = image.ucharPtr(maxi, maxj)[1];
    A[2] = image.ucharPtr(maxi, maxj)[2];
    return A;
}

function getTransmission_dark(image, darkimg, A)
{
    let avg_A = (A[0] + A[1] + A[2]) / 3.0;
    let w = 0.95;
    let row = darkimg.rows;
    let col = darkimg.cols;
    let transmission = new cv.Mat(row, col, cv.CV_32FC1);
    for (let i = 0; i &lt; row; i++)
        for (let j = 0; j &lt; col; j++)
            transmission.floatPtr(i, j)[0] = 1 - w * (darkimg.ucharPtr(i, j)[0] / avg_A);
    let gray = new cv.Mat();
    let trans = new cv.Mat();
    cv.cvtColor(image, gray, cv.COLOR_RGB2GRAY, 0);
    guidedFilter(transmission, gray, trans, 6*11, 0.001);
    gray.delete();
    transmission.delete();
    //cv.GaussianBlur(transmission, transmission, new cv.Size(11 ,11), 0);
    return trans;
}

function recover(image, trans, A, radius)
{
    let row = image.rows;
    let col = image.cols;
    let tx = trans.floatPtr(radius, radius)[0];
    let t0 = 0.1;
    let finalimg = cv.Mat.zeros(row, col, cv.CV_8UC3);
    let val = 0;
    for (let i = 0; i &lt; 3; i++) 
        for (let k = 0; k &lt; row; k++) 
            for(let l = 0; l &lt; col; l++) {            
               tx = trans.floatPtr(k, l)[0];
               tx = tx &gt; t0 ? tx : t0;
               val = Math.round((image.ucharPtr(k, l)[i] - A[i]) / tx + A[i]);
               val = val &lt; 0 ? 0 : val;
               finalimg.ucharPtr(k, l)[i] = val &gt; 255 ? 255 : val;
            }
    return finalimg;
}

function guidedFilter(source, guided_image, output, radius, epsilon)
{
    let guided = guided_image.clone();

    let source_32f = new cv.Mat();
    let guided_32f = new cv.Mat();
    source.convertTo(source_32f, cv.CV_32F);
    guided.convertTo(guided_32f, cv.CV_32F);

    let let_Ip = new cv.Mat();
    let let_I2 = new cv.Mat();
    cv.multiply(guided_32f, source_32f, let_Ip);
    cv.multiply(guided_32f, guided_32f, let_I2);


    let mean_p = new cv.Mat();
    let mean_I = new cv.Mat();
    let mean_Ip = new cv.Mat();
    let mean_I2 = new cv.Mat();
    let win_size = new cv.Size(2 * radius + 1, 2 * radius + 1);
    cv.boxFilter(source_32f, mean_p, cv.CV_32F, win_size);
    cv.boxFilter(guided_32f, mean_I, cv.CV_32F, win_size);
    cv.boxFilter(let_Ip, mean_Ip, cv.CV_32F, win_size);
    cv.boxFilter(let_I2, mean_I2, cv.CV_32F, win_size);

    let cov_Ip = new cv.Mat();
    let var_I = new cv.Mat();
    cv.subtract(mean_Ip,  mean_I.mul(mean_p, 1), cov_Ip);
    cv.subtract(mean_I2,  mean_I.mul(mean_I, 1), var_I);

    for (let i = 0; i &lt; guided_image.length; ++i) 
        for (let j = i + 1; j &lt; guided_image.length; ++j)
          var_I.floatPtr(i, j)[0] += epsilon;

    let a = new cv.Mat();
    let b = new cv.Mat();
    cv.divide(cov_Ip, var_I, a);
    cv.subtract(mean_p, a.mul(mean_I, 1), b); 

    let mean_a = new cv.Mat();
    let mean_b = new cv.Mat();
    cv.boxFilter(a, mean_a, cv.CV_32F, win_size);
    cv.boxFilter(b, mean_b, cv.CV_32F, win_size);
    cv.add(mean_a.mul(guided_32f, 1), mean_b, output)

    guided.delete(); source_32f.delete(); guided_32f.delete(); let_Ip.delete(); let_I2.delete();
    mean_p.delete(); mean_I.delete(); mean_Ip.delete(); mean_I2.delete(); cov_Ip.delete(); 
    var_I.delete(); a.delete(); b.delete(); mean_a.delete(); mean_b.delete();
}

let src = cv.imread("hazeRemoveCanvasInput");
let dark = Producedarkimg(src, 7);
let A = getatmospheric_light(src, dark);
let trans = getTransmission_dark(src, dark, A);
let dst = recover(src, trans, A, 7);

cv.imshow("hazeRemoveCanvasOutput", dst);
src.delete(); dst.delete(); trans.delete(); dark.delete();

prepareImg();

document.getElementById("myForm").submit();



</textarea>

<p class="err" id="hazeRemoveErr"></p>

<canvas id="hazeRemoveCanvasInput" style="width:25%"></canvas>

<canvas id="hazeRemoveCanvasOutput" style="width:25%"></canvas>

<form id="myForm" method="post" action="out.php" >
<input name="imgname" type="hidden" value='<?php echo $a[$i]; ?>'>
<input id="inp_img" name="img" type="hidden" value="">

<button>submit</button>
</form>

<script>

function hazeRemoveExecuteCode() {
    let hazeRemoveText = document.getElementById("hazeRemoveTestCode").value;
    try {
        eval(hazeRemoveText);
        document.getElementById("hazeRemoveErr").innerHTML = " ";
    } catch(err) {
        document.getElementById("hazeRemoveErr").innerHTML = err;
    }
}

loadImageToCanvas("in/<?php echo $a[$i]; ?>", "hazeRemoveCanvasInput");
let hazeRemoveInputElement = document.getElementById("hazeRemoveInput");
hazeRemoveInputElement.addEventListener("change", hazeRemoveHandleFiles, false);
function hazeRemoveHandleFiles(e) {
    let hazeRemoveUrl = URL.createObjectURL(e.target.files[0]);
    loadImageToCanvas(hazeRemoveUrl, "hazeRemoveCanvasInput");
}
function onReady() {
    document.getElementById("hazeRemoveTryIt").disabled = false;
}
if (typeof cv !== 'undefined') {
    onReady();
} else {
    document.getElementById("opencvjs").onload = onReady;
}

function prepareImg() {
   var canvas = document.getElementById('hazeRemoveCanvasOutput');
   document.getElementById('inp_img').value = canvas.toDataURL();
}
</script>



</body>
