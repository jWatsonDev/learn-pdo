<?php
// Scope resolution opperator PDO::
try {
    $connect_info = "mysql:host=localhost;dbname=learn";
    $handler = new PDO($connect_info, "root", "");
    $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
    die();
}
$query = $handler->query("SELECT * FROM hello_world");
// can use the fetch all method to get all of the results instead of just looping through all of them
$results = $query->fetchAll(PDO::FETCH_ASSOC);

if(count($results)){
    echo "there are some";
} else {
    echo "not any";
}
$name = "Josh";
$msg = "This is life.";
// prepared statements
$sql = "INSERT INTO hello_world (name, message, posted) VALUES (:name, :msg, NOW())";
// instead of using query, we want to preopare it
//$handler->query($sql);
// This prepares the query for executioin
$query = $handler->prepare($sql);
// binding the values in query to the particular fields
$query->execute(array(
    ':name' => $name,
    ':msg' => $msg
));

// CAN ALSO DO LIKE THIS
/*$sql = "INSERT INTO hello_world (name, message, posted) VALUES (?, ?, NOW())";
$query = $handler->prepare($sql);
$query->execute(array($name, $msg));*/

// GREAT STACK OVERFLOW Explanation 
/*
When a query is sent to a data base, it's typically sent as a string. The db engine will try to parse the string and separate the data from the instructions, relying on quote marks and syntax. So if you send "SELECT * WHERE 'user submitted data' EQUALS 'table row name', the engine will be able to parse the instruction.

If you allow a user to enter what will be sent inside 'user submitted data', then they can include in this something like '..."OR IF 1=1 ERASE DATABASE'. The db engine will have trouble parsing this and will take the above as an instruction rather than a meaningless string.

The way PDO works is that it sends separately the instruction (prepare("INSERT INTO ...)) and the data. The data is sent separately, clearly understood as being data and data only. The db engine doesn't even try to analyze the content of the data string to see if it contains instructions, and any potentially damaging code snipet is not considered.
*/