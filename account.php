<?php
require_once("includes/functions.php");
require_once("includes/database.php");

session_start();
$user_id = $_SESSION["user_id"];
$db = new Database();
$db_connection = $db -> get_connection();
$transactions = $db -> get_all_items("transactions", "user",$user_id);
$user = $db -> get_all_items("users", "id", $user_id);
$current_balance = 0;
$deposit_total = 0;
$withdrawal_total = 0;
foreach($transactions as $item) {
      // $amount = intval($item["amount"]);
      global $current_balance;
      $current_balance = floatval($item["amount"] + $current_balance);
      if($item["amount"] > 0) {
            $deposit_total = floatval($item["amount"] + $deposit_total);
      }else {
            $withdrawal_total = floatval($item["amount"] + $withdrawal_total);
      }
}

page_header();
?>
<div id="account" class="container">
      <header>
            <h3 class="welcome">Welcome back, <?=ucfirst($user[0]["username"])?></h3>
            <div class="logo-holder">
                  <img src="old/icon.png" alt="Blue bank icon">
            </div>
            <a href="logout.php" class="btn log-out">Log Out</a>
      </header>
      <section>
            <div class="section-2columns">
                  <div class="app-features-container">
                        <form action="features-processor.php" method="get" class="app-features-holder transfer">
                              <h3>Withdraw Money</h3>
                              <label for="withdraw_money">
                                    <input name="withdraw_money" id="withdraw_money" type="text" placeholder="Amount" required>

                              </label>
                              <button class="btn">Submit</button>
                        </form>
                        <form action="features-processor.php" method="get" class="app-features-holder loan">
                              <label for="deposit_money"><h3>Deposit Money</h3></label>
                              <input name="deposit_money" id="deposit_money" type="number" placeholder="Amount" required>
                              <button class="btn">Submit</button>
                        </form>
                        <form action="features-processor.php" method="get" class="app-features-holder close-account">
                              <label for="close_password">
                                    <h3>Close Account</h3>
                              </label>
                              <input name="close_password" id="close_password" type="password" placeholder="Password" required>
                              <button class="btn">Submit</button>
                        </form>
                  </div>
                  <div class="app-displays">
                        <div class="current-balance">
                              Current balance
                              <div class="display-balance"><?=number_format(+$current_balance,2,",",".")?>€</div>
                        </div>
                        <div class="multiple-display-holder">
                              <div class="multiple-display-item money-in">
                                    <p>IN</p>
                                    <?=number_format($deposit_total,2,",",".")?>€
                              </div>
                              <div class="multiple-display-item money-out">
                                    <p>OUT</p>
                                    <?=number_format($withdrawal_total,2,",",".")?>€
                              </div>
                              <div class="multiple-display-item money-interest">
                                    <p>INTEREST</p>
                                    8,93€
                              </div>
                        </div>
                  </div>
            </div>
      </section>
      <section>
            <div class="help-section">
                  <input type="text" class="search" placeholder="Search Transaction">
                  <button class="btn" value="submit">Sort</button>
                  <div>This session will end in <span class="countdown">05: 00</span></div>
            </div>
            <div class="transaction-container">
                  <?php foreach($transactions as $item) {
                        if($item["amount"] > 0) {?>               
                        <div class="transaction-item positive">
                              <div class="transaction type">Deposit</div>
                              <div class="transaction amount"><?=number_format($item["amount"],2)?></div>
                              <div class="transaction date"><?=$item["date"]?></div>
                        </div>
                  <?php
                        }else {?>
                        <div class="transaction-item negative">
                              <div class="transaction type">Withdrawal</div>
                              <div class="transaction amount"><?=$item["amount"]?></div>
                              <div class="transaction date"><?=$item["date"]?></div>
                        </div>

                        <?php
                        }
                  }
                  ?>
            </div>
      </section>
</div>

<?php
page_footer();
?>
<script>
      const countdown_element = document.querySelector(".countdown");
      console.log(countdown_element);
      // const startig_minutes = 3;
      let start_time = 5 * 60;
      const countdown_function = function() {
            const minutes = Math.floor(start_time/60).toString().padStart(2,"0");
            let seconds = (start_time % 60).toString().padStart(2,"0");
            if (start_time === 0) {
                  window.location.href= "logout.php";
            }
            countdown_element.innerHTML = `${minutes}: ${seconds}`;
            start_time--;

      }
      setInterval(countdown_function, 1000)
      document.querySelector("#account").addEventListener("click", function(){
            start_time = 5 * 60;
      })

</script>