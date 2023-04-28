<?php
require_once("includes/functions.php");
require_once("includes/database.php");

$db = new Database();
$db_connection = $db -> get_connection();


if (isset($_GET["username"]) && isset($_GET["user_password"])) {
      $error_message = false;
      if($_GET["username"] !== "" && $_GET["user_password"] !== "") {
                  var_dump($_GET);
                  $username = $_GET["username"];
                  $user_password = password_hash($_GET["user_password"], PASSWORD_DEFAULT);
                  try {   
                        $stmt = $db_connection -> prepare("INSERT INTO users VALUES (null, :username, :user_password, null)");
                        $stmt -> bindParam(":username", $username);
                        $stmt -> bindParam(":user_password", $user_password);
                        $stmt -> execute();
                        header("location: index.php");
                        exit;
                  } catch (PDOException $error) {
                        $error_message = true;

                  }
      }
}

page_header();
?>

<div id="new-account">
      <div class="container">
            <form action="#" method="GET">
                  <?php
                  if(isset($error_message) && $error_message !== "") {?>
                        <div class="error-message">Username already exists</div>
                  <?php
                  }
                  ?>
                  <div class="form-group username-container">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username">
                  </div>
                  <div class="form-group user-password-container">
                        <label for="user_password">Password</label>
                        <input type="text" name="user_password" id="user_password">
                  </div>
                  <button class="btn">Create</button>
            </form>
      </div>
</div>

