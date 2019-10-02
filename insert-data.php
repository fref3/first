<?php
include 'dataBaseConection.php';

/* Create connection */
$conn = new mysqli($host, $username, $password, $dbname);
/* Check connection */
if ($conn->connect_error) {
     die("Connection to database failed: " . $conn->connect_error);
}

/* Get data from Client side using $_POST array */
$_name  = $_POST['nom'];
$_dateRecu  = $_POST['dateRecu'];
$_dateDu  = $_POST['dateRemettre'];
/* validate whether user has entered all values. */
if(!$_name || !$_dateRecu || !$_dateDu){
  $result = 2;
}
else {
   //SQL query to get results from database
   $sql    = "insert into devoir (nom, dateArriver, dateDue) values (?, ?, ?)  ";
   $stmt   = $conn->prepare($sql);
   $stmt->bind_param('sss', $_name, $_dateRecu, $_dateDu);
   if($stmt->execute()){
     $result = 1;
   }
}
echo $result;
$conn->close();


