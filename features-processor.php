<?php
require_once("includes/functions.php");
require_once("includes/database.php");

session_start();
$user_id = $_SESSION["user_id"];
$db = new Database();
$db_connection = $db->get_connection();
$user = $db -> get_all_items("users", "id", $user_id);


if(isset($_GET)) {
      if(isset($_GET["deposit_money"]) && $_GET["deposit_money"] !== "") {

            $db -> insert_transaction("transactions", $_GET["deposit_money"], "deposit_money", $user_id);
      }
      if(isset($_GET["withdraw_money"]) && $_GET["withdraw_money"] !== "") {

            $db -> insert_transaction("transactions", $_GET["withdraw_money"], "withdraw_money", $user_id);
      }
      if(isset($_GET["close_password"]) && $_GET["close_password"] !== "") {
            var_dump($_GET["close_password"]);
            $results = $db -> get_all_items("users", "password", $user_id);
            var_dump($user[0]["password"]);
            echo "<br>";
            var_dump($_GET["close_password"]);

            if(password_verify($_GET["close_password"], $user[0]["password"])) {
                  echo "worked";
                  $query = "DELETE FROM users WHERE id=$user_id";
                  if ($db_connection ->query($query)) {
                        header("Location: index.php");
                  }
                  else {
                        die("delete failed");
                  }

            }

      }

};
