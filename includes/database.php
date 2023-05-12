<?php

Class Database {

function get_connection() {
      $db_host = "localhost";
      $db_name = "***";
      $db_username = "***";
      $db_password = "***";
      $dns = "mysql:host=$db_host; dbname=$db_name; charset=utf8";
      try {
            return new PDO ($dns, $db_username, $db_password);
      } catch (PDOException $e) {
            echo "Something went wrong". $e -> getMessage();
            exit;
      }
}
function get_all_items($table, $column, $user_id) {

      $query_all = "SELECT * FROM $table WHERE $column = $user_id";
      global $db_connection;
      try {
            $results = $db_connection -> query($query_all);
            if($results === false) {
                  echo $db_connection -> errorInfo();
                  exit;
            }
            return $results -> fetchAll(PDO::FETCH_ASSOC);

      }catch (PDOException $error) {
            echo "There was an error". $error->getMessage();
            exit;
      }

}
function insert_transaction($table, $values, $type, $user_id) {
      global $db_connection;
      if($type === "withdraw_money") {
            $values = $values * -1;
      }
      try {
            $current_date = date("Y-m-d");
            $stmt = $db_connection -> prepare("INSERT INTO $table VALUES (null, :amount, :current_date, :user_id) ");
            $stmt -> bindParam(":amount", $values);
            $stmt -> bindParam(":current_date", $current_date);
            $stmt -> bindParam(":user_id", $user_id);
            $stmt -> execute();
            header("Location: account.php");
            exit;
      } catch (PDOException $error) {
            echo "Sorry, there was an error". $error -> getMessage();
            exit;
      }
}
}