<?php

require_once("includes/functions.php");
$db = new Database();
$db_connection = $db -> get_connection();
$error_message= false;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
      var_dump($_GET);
      if (isset($_GET["username"]) && $_GET["username"] !== "") {
            if (isset($_GET["user_password"]) && $_GET["user_password"] !== "") {
                  $query = "SELECT * FROM users WHERE username = :username";
                  $stmt = $db_connection -> prepare("SELECT * FROM users WHERE username = :username");
                  $stmt -> bindParam(":username", $_GET["username"]);
                  
                  if($stmt -> execute()) {
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if(count($results) < 2) {
                              if(password_verify($_GET["user_password"], $results[0]["password"])) {
                              // echo "<br>";
                              // var_dump($results[0]["id"]);
                              // echo "<br>";
                              // echo $results[0]["password"];
                              // echo "<br>";
                              // echo "worked";
                              session_start();
                              $_SESSION["user_id"] = $results[0]["id"];
                             
                              header("Location: account.php");
                              exit;
      
                              }
                              // else {
                              //       $error_message = true;
                              // }

                        }
                        // else {
                        //       die("results didnt work");
                        // }
                  }
                  // else {
                  //       die("didnt work");
                  // }
            } 
            // else {
            //       die ("didnt work 1");
            //       // echo isset($_GET["password"]);
            //       // echo $_GET["password"] !== "";
            //       // echo "get password";
            // }
      }
      // else {
      //       echo "get";
      //       exit;
      // }
}
// else {
//       echo "request method";
//       exit;
// }
header("Location: index.php");