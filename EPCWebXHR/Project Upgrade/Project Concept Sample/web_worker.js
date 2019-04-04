var get = "0";

var put = "0";

var get_count = 0;

var put_count = 0;

function TheProcess() {


        xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
            get = ""+this.responseText;    
            get_count++;
            }
        };
       xmlhttp.open("GET","get_from_db.php",true);
       xmlhttp.send();


     var values = get.split(",");
          var id=values[0];
     var a=values[1];
     var b=values[2];
     var result=parseInt(a)+parseInt(b);
     
   if(result){
             xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
            put = ""+this.responseText;    
            put_count++;
            }
        };
       xmlhttp.open("GET","put_into_db.php?id="+id+"&result="+result,true);
       xmlhttp.send();
         }


   postMessage("<br>Data Received = "+get+" id = "+id+"<br> Result = "+result+"<br> Count of Data : Received = "+get_count+" ; Sent = "+put_count);
 
   setTimeout("TheProcess()",100);
}

TheProcess(); 