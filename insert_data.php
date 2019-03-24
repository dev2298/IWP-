<html>
<head>
<style>
.c1{
	background-image:url("thanks_final.jpg");
	background-size: 100%;
	background-repeat: no-repeat;
	background-position:center;
	text-align:center;
	font-size:20px;
	font-family:verdana;
	color: black;
	font-weight:bold;
}

</style>
</head>

<body class="c1","h1">

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iwp_proj";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Take data from front_end file and insert it into Database Tables.

$name = $_POST['NAME'];
$source = $_POST['FROM'];
$dest = $_POST['CheckOut'];
$traveller = $_POST['numtraveller'];
$mode = $_POST['cars'];
$date = $_POST['date'];
$time = $_POST['time'];
$email = $_POST['email'];
$phone = $_POST['mobile'];
$gender = $_POST['gender'];

$sql = "INSERT INTO user_info ( name, source, destination, num_of_trav, trans_mode, date, time, email, phone, gender ) VALUES ( '$name','$source','$dest','$traveller','$mode','$date',
'$time','$email','$phone','$gender' )";


if ($conn->query($sql) === TRUE){
	echo "<br/><br/><br/>	";
	echo"THANK YOU!!! YOUR DATA HAS BEEN ENTERED SUCCESSFULLY.<br/><br/><br/>
	WE HAVE DISPLAYED YOUR INFORMATION, FOLLOWED BY THAT OF THOSE, WHO HAVE SIMILAR TRAVEL TIMINGS TO YOU 
	ON THE SAME DATE AND BETWEEN SAME LOCATIONS AT THE MOMENT.
	<br/><br/>WE WILL LET YOU KNOW IF WE FIND MORE SUITABLE TRAVEL PARTNERS FOR YOU.";
}
else{
	echo "<br/><br/><br/>";
	echo "SORRY!! WE COULDN'T ENTER YOUR DATA. WE GOT THE FOLLOWING ERROR: " . $conn->error;                             //AND ABS(TMEDIFF($time,time)) < 30
}


//Now to display similar datas
echo "<br/><br/><br/>";

$sql = "SELECT name, trans_mode, time, email, phone, gender FROM user_info WHERE date='$date' AND source='$source' AND destination='$dest' AND TIME_TO_SEC('$time') - TIME_TO_SEC(time) < 1801 ";
$result = $conn->query($sql);
if ($result->num_rows>0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<p style ='font-size:20px;	background-repeat: no-repeat;background-size: 100%;background-color:  rgba(255,255,255,.4);font-family:verdana;color: black;font-weight:bold'>Name: " . $row["name"]. " - Travel Mode: " . $row["trans_mode"]. " - Time: " . $row["time"]. " - E-Mail: " . $row["email"]. " - Contact Number: " . $row["phone"]. " - Gender: " . $row["gender"]." </p><br>";
		}
} else {
    echo "No matches found as of now. We will intimate you later if we find anyone!!!";
}

//Close Connection
$conn->close();
?>

</body>
</html>