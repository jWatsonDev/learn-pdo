<?php
// PDO - PHP Data Objects - can use with many types of database

// Static method to check which drivers are available 
// Scope resolution opperator PDO::
// Access PDO with the PDO object
// print_R(PDO::getAvailableDrivers()); Array ( [0] => mysql [1] => pgsql [2] => sqlite )

try {
  // Connect to DB
  // DB handler PDO Object - (string, username, password)
  $connect_info = "mysql:host=localhost;dbname=learn"; // variable to hold the first param
  $handler = new PDO($connect_info, "root", "");  
  // use this syntax to set various attributes - setting the type of error mode 
  $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  // catch block with catch our error and provide us with control, allowing us to stop the program\
  // created exception named $e - can use to get info abt exception
  echo $e->getMessage();
  die();
  // production-friendly, generic message
  //die("Database error");
}
// query statement - using handler instance - query method - sql statement
$query = $handler->query("SELECT * FROM hello_world");
// iterate through each row - use query - fetch method - set each row = $row
/*while($row = $query->fetch()) {
  echo $row['name'] . " " . $row['message'] . "<br><br>";
}*/
// can fetch various types of data - assoc array, numeric array, object
// the defaault way the data is returned with fetch() is an assoc array
/*while($row = $query->fetch(PDO::FETCH_OBJ)) {
  echo $row->name . "<br>";
}*/

// TUTORIAL FOUR
// classes typically located in other files and included 
class Learn {
  public $id, $name, $message, $posted, $entry;
  
  // constructor - will run when the class is instantiated
  public function __construct() {
    $this->entry = "{$this->name} posted: {$this->message}";
  }
}

// set fetch mode
$query->setFetchMode(PDO::FETCH_CLASS, "Learn");
while($row = $query->fetch()) {
  //echo "<pre>" , print_r($row) , "</pre>";
  echo $row->entry;
}