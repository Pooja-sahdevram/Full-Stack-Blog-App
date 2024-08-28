<?php
$server="localhost";
$username="root";
$password="Poo_ja1221";
$db="intesols_pvt";


$conn=new mysqli($server,$username,$password,$db);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
    
}
// else{

//   
// }

?>