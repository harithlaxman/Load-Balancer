<?php
$dbServername = "localhost";
$dbUsersname = "username";
$dbpassword = "password";
$dbName = "db_with_2_tables";
$connect = mysqli_connect($dbServername, $dbUsersname, $dbpassword, $dbName);

//CREATE TABEL Requests
$create_table2 = "CREATE TABLE requests(
    ID INT AUTO_INCREMENT PRIMARY KEY,
    allocated_node_name VARCHAR(255) NOT NULL,
    starttime TIME NOT NULL,
    CPU_required INT NOT NULL,
    memory_required INT NOT NULL,
    time_req_for_comp INT NOT NULL
)";
mysqli_query($connect, $create_table2);
//RECIEVING POST REQUEST FROM request.py
$rname = "cpu";
$rcreq = htmlspecialchars($_POST['creq']);
$rmreq = htmlspecialchars($_POST['mreq']);
$rtreq = htmlspecialchars($_POST['treq']);
$time = date("H:i:s");

$diff = 0;
for($i = 1; $i<=4; ++$i){
  $conds = "SELECT * from nodes where Name='$rname$i'";
  $cond = mysqli_query($connect, $conds);
  $row = mysqli_fetch_array($cond);

  $creq = $row["Available_CPUs"];

  $mreq = $row["Available_memory"];

  $tempc = $creq - $rcreq;
  $tempm = $mreq - $rmreq;

  if($tempc > $diff){
    $diff = $tempc;
    $rname = $rname$i;
    $rmcreq = $creq - $rcreq;
    $rmmreq = $rmreq - $mreq;
  }
}


if($diff != 0)
{
  $query = "INSERT INTO requests(allocated_node_name, starttime, CPU_required, memory_required, time_req_for_comp) values('$rname', '$time', '$rcreq', '$rmreq', '$rtreq')";
  mysqli_query($connect, $query);
  $query2 = "UPDATE nodes SET Available_CPUs = '$rmcreq', Available_memory = '$rmmreq' WHERE Name='$rname'";
  mysqli_query($connect, $query2);
  header("location: $rname.php");
}
else {
  echo "Can't process Request";
}

?>
