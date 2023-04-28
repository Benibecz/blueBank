<?php

require_once("includes/functions.php");
require_once("includes/database.php");

$db = new Database();
$db_connection = $db -> get_connection();

$error_message = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["username"]) && $_POST["username"] !== "") {
                  if (isset($_POST["user_password"]) && $_POST["user_password"] !== "") {
                        try {
                              $query = "SELECT * FROM users WHERE username = :username";
                              $stmt = $db_connection -> prepare("SELECT * FROM users WHERE username = :username");
                              $stmt -> bindParam(":username", $_POST["username"]);
                              if($stmt -> execute()) {
                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if(count($results) < 2) {
                                          if(isset($results[0]["username"]) && $_POST["username"] === $results[0]["username"]) {
                                                if(password_verify($_POST["user_password"], $results[0]["password"])) {
                                                      session_start();
                                                      $_SESSION["user_id"] = $results[0]["id"];
                                                      header("Location: account.php");
                                                      exit;           
                                                      }
                                          }
                                    } 
                              }
                        }catch (PDOException $error) {
                              echo "There was an error". $error -> getMessage();
                        }
                  } 
            }
            $error_message = true;

}

page_header();
?>
<section id="loggin">
      <div class="container">
            <div class="log-in-form">
                  <div class="logo-holder">
                        <img src="old/icon.png" alt="Blue bank icon">
                  </div>
                  <h1 class="heading">Blue Bank</h1>
                  <?php if(isset($error_message) && $error_message === true) {?>
                        <div class="error-message">Please provide valid credentials</div>
                  <?php
                  } ?>
                  <div class="sub-heading">Log in to get started</div>
                  <form action="#" method="POST" >

                        <label for="username">
                              <input type="text" placeholder="Username" name="username" id="username" required>
                        </label>
                        <label for="user_password">
                              <input type="password" placeholder="Password" name="user_password" id="user_password" >
                        </label>
                        <div class="log-in-btn">
                              <button class="btn submit-btn">Login</button>
                              <a href="new_account.php" class="btn create-account" >Signup</a>
                        </div>


                  </form>
            </div>

      </div>
</section>

