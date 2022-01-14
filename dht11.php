<?php
//SENDING TEMPERATURE AND HUMIDITY DATA TO DATABASE 
class dht11{
 public $link='';
 function __construct($temperature, $humidity){
  $this->connect();
  $this->storeInDB($temperature, $humidity);
 }
 
 //connecting to database
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'dht') or die('Cannot select the DB');
 }
 
 //function to insert data to database
 function storeInDB($temperature, $humidity){
  $query = "insert into dht11 set humidity='".$humidity."', temperature='".$temperature."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
//getting data from the get method
if($_GET['temperature'] != '' and  $_GET['humidity'] != ''){
 $dht11=new dht11($_GET['temperature'],$_GET['humidity']);
}
?>
