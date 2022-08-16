"use strict";

// ------------------------------ Sections
const app = document.querySelector(".app");
const loginSection = document.querySelector(".login__section");
const topSection = document.querySelector(".top__section");
const message = document.querySelector(".top__message");
const transactionContainer = document.querySelector(".transactions");
const balanceTotal = document.querySelector(".total__balance__number");
const moneyIn = document.querySelector(".money__in");
const moneyOut = document.querySelector(".money__out");
const moneyInterest = document.querySelector(".money__interest");
const timerDisplay = document.querySelector(".timer");

// ------------------------------ Inputs
const inputUser = document.querySelector(".login__username");
const inputUser2 = document.querySelector(".input__username");
const inputPin = document.querySelector(".login__password");
const inputPin2 = document.querySelector(".input__password");

const inputReceivingAcc = document.querySelector(".input__receiving__account");
const inputTransferAmount = document.querySelector(".input__transfer__amount");
const inputLoan = document.querySelector(".input__loan");
const inputCloseAccount = document.querySelector(".close__account__input");

// ------------------------------ Btns
const btnLogin = document.querySelectorAll(".login__btn");
const btnTransfer = document.querySelector(".transfer__btn");
const btnLoan = document.querySelector(".loan__btn");
const btnSort = document.querySelector(".sort__btn");

// ------------------------------ status variable
let currentAccount,
  timer,
  sorted = false;
const nowTime = new Date().toString();

// ------------------------------ Classes

class Account {
  transactions = [];
  movementsDates = [];

  constructor(username, pin, interestRate) {
    (this.username = username),
      (this._pin = pin),
      (this.interestRate = interestRate);
  }

  _addDate() {
    const options = {
      day: "2-digit",
      month: "2-digit",
      year: "2-digit",
    };
    const now = new Date();
    const formattedDate = Intl.DateTimeFormat("es-ES", options).format(now);
    return formattedDate;
  }
  addTransaction(...amount) {
    this.transactions.push(...amount);
    this.movementsDates.push(`${this._addDate()}`);
    return this;
  }
}

const benito = new Account("benito", 1111, 0.6);
benito.addTransaction(250);

// ------------------------------ accounts

const account1 = {
  username: "Ben Bec",
  pin: 1111,
  transactions: [147, 25, 36, 789, 35, 456, -56, -87],
  interestRate: 0.6,
  movementsDates: [
    "2021-11-18T21:31:17.178Z",
    "2021-12-23T07:42:02.383Z",
    "2022-01-28T09:15:04.904Z",
    "2022-07-01T10:17:24.185Z",
    "2022-07-08T14:11:59.604Z",
    "2022-07-19T17:01:17.194Z",
    "2022-07-20T23:36:17.929Z",
    "2022-07-21T10:51:36.790Z",
  ],
};
const account2 = {
  username: "Rosa Bec",
  pin: 2222,
  transactions: [985, -258, -753, 951, -25, 85, 123, -84],
  interestRate: 1,
  movementsDates: [
    "2020-11-18T21:31:17.178Z",
    "2020-12-23T07:42:02.383Z",
    "2021-01-28T09:15:04.904Z",
    "2021-04-01T10:17:24.185Z",
    "2022-05-08T14:11:59.604Z",
    "2022-07-22T17:01:17.194Z",
    "2022-07-23T23:36:17.929Z",
    "2022-07-24T10:51:36.790Z",
  ],
};
const account3 = {
  username: "Ken Bec",
  pin: 3333,
  transactions: [-25, -78, 564, 754, -365, 519, -213, 64],
  interestRate: 0.4,
  movementsDates: [
    "2020-11-18T21:31:17.178Z",
    "2020-12-23T07:42:02.383Z",
    "2021-01-28T09:15:04.904Z",
    "2021-04-18T10:17:24.185Z",
    "2022-05-19T14:11:59.604Z",
    "2022-07-20T17:01:17.194Z",
    "2022-07-21T23:36:17.929Z",
    "2022-07-22T10:51:36.790Z",
  ],
};

const accounts = [account1, account2, account3];

const options = {
  style: "currency",
  currency: "EUR",
};

// ------------------------------ Functions

const closeAccountFeature = function () {
  // accounts.find()
};

const sorting = function () {
  resetTimer();
  sorted = sorted === false ? true : false;
  displayTransactions(currentAccount, sorted);
};
const timerCalc = function () {
  const options = {
    second: "2-digit",
    minute: "2-digit",
  };
  let time = 1000 * 60 * 5;
  const countdown = function () {
    time = time - 1000;

    const timerFormatted = `This session will end in ${Intl.DateTimeFormat(
      "es-ES",
      options
    ).format(time)}`;
    timerDisplay.textContent = timerFormatted;

    if (time === 0) {
      app.style.display = "none";
      loginSection.style.display = "flex";
    }
  };

  countdown();

  const timer = setInterval(countdown, 1000);

  return timer;
};
const resetTimer = function () {
  if (timer) {
    clearInterval(timer);
    timer = timerCalc();
  } else {
    timer = timerCalc();
  }
};

const balanceCalc = function (currentAccount) {
  const result = currentAccount.transactions
    .reduce((acc, transaction) => transaction + acc, 0)
    .toFixed(2);

  const intResult = Intl.NumberFormat("es-ES", options).format(result);

  balanceTotal.textContent = intResult;
  balanceTotal.style.color = result > 0 ? "#53bf9d" : "#F94C66";
};

const moneyInCalc = function (currentAccount) {
  const totalDeposits = currentAccount.transactions
    .filter((transaction) => transaction >= 0)
    .reduce((acc, deposit) => acc + deposit, 0, 0);
  moneyIn.textContent = Intl.NumberFormat("es-ES", options).format(
    totalDeposits.toFixed(2)
  );

  moneyIn.style.color = totalDeposits > 0 ? "#53bf9d" : "#F94C66";
};

const moneyOutCalc = function (currentAccount) {
  const TotalWithdrawals = currentAccount.transactions
    .filter((transaction) => transaction <= 0)
    .reduce((acc, element) => acc + element, 0);
  moneyOut.textContent = Intl.NumberFormat("es-ES", options).format(
    TotalWithdrawals
  );

  moneyOut.style.color = TotalWithdrawals <= 0 ? "#F94C66" : "#53bf9d";
};
const moneyInterestCalc = function (currentAccount) {
  const totalInterest = currentAccount.transactions
    .filter((transaction) => transaction >= 0)
    .map((deposit) => (deposit * currentAccount.interestRate) / 100)
    .reduce((acc, deposit) => acc + deposit, 0);

  moneyInterest.textContent = Intl.NumberFormat("es-ES", options).format(
    totalInterest
  );
  moneyInterest.style.color = "#F2DF3A";
};

// --------------------------------- Functions > Features

const transferMoney = function (account) {
  if (
    Number(inputTransferAmount.value) > 0 &&
    inputReceivingAcc.value !== currentAccount.username &&
    inputReceivingAcc.value
  ) {
    const receivingAcc = accounts.find(
      (account) =>
        account.username.toLowerCase() === inputReceivingAcc.value.toLowerCase()
    );

    receivingAcc.transactions.push(Number(inputTransferAmount.value));
    currentAccount.transactions.push(Number(inputTransferAmount.value * -1));
    currentAccount.movementsDates.push(nowTime);
    receivingAcc.movementsDates.push(nowTime);
    balanceDisplay(currentAccount);
  }
  inputReceivingAcc.value = "";
  inputTransferAmount.value = "";
  resetTimer();
};

const loanMoney = function (account) {
  if (inputLoan.value > 0) {
    const loan = Number(inputLoan.value);
    setTimeout(() => {
      currentAccount.transactions.push(loan);
      currentAccount.movementsDates.push(nowTime);
      balanceDisplay(currentAccount);
    }, 4000);
    inputLoan.value = "";
    resetTimer();
  }
};
const balanceDisplay = function (account) {
  displayTransactions(currentAccount);
  balanceCalc(currentAccount);
  moneyInCalc(currentAccount);
  moneyOutCalc(currentAccount);
  moneyInterestCalc(currentAccount);
};

const featureLogin = function (e) {
  const user = inputUser.value.toLowerCase() || inputUser2.value?.toLowerCase();
  const password = inputPin.value || inputPin2.value;
  const users = e.target.closest("body").querySelectorAll(".username");
  const pins = e.target.closest("body").querySelectorAll(".pin");
  const clearLoginInputs = function () {
    users.forEach((user) => (user.value = ""));
    pins.forEach((pin) => (pin.value = ""));
  };

  currentAccount = accounts.find(
    (account) => user === account.username.toLowerCase()
  );
  if (currentAccount?.pin === Number(password)) {
    app.style.opacity = 1;
    message.textContent = `Welcome back, ${
      currentAccount.username.split(" ")[0]
    }`;
    loginSection.style.display = "none";
    clearLoginInputs();
    balanceDisplay(currentAccount);
    resetTimer();
  } else {
    alert("Login details incorrect.");
    clearLoginInputs();
  }
};

const displayTransactions = function (currentAccount) {
  let movs;

  transactionContainer.innerHTML = "";
  if (sorted) {
    movs = currentAccount.transactions.slice().sort((a, b) => a - b);
  } else {
    movs = currentAccount.transactions;
  }

  movs.forEach((transaction, index) => {
    const options = {
      day: "2-digit",
      month: "2-digit",
      year: "2-digit",
    };
    const type = transaction >= 0 ? "deposit" : "withdrawal";
    const date = new Date(`${currentAccount.movementsDates[index]}`);
    const now = new Date();
    const formattedDate = new Intl.DateTimeFormat("es-ES", options).format(
      date
    );
    // const date = new Intl.DateTimeFormat("es-ES", options).format(
    //   currentAccount.movementsDates[index]
    // );

    const dateFunction = function (formattedDate) {
      const nowTime = Math.trunc(now.getTime());
      const dateTime = Math.trunc(date.getTime());
      const difference = nowTime - dateTime;
      const oneDay = 1000 * 60 * 60 * 24;
      // console.log(difference < oneDay);
      // console.log(difference);
      // console.log(nowTime);
      // console.log(dateTime);
      // console.log(oneDay);
      // console.log(nowTime - dateTime);

      if (difference < oneDay) {
        return "Today";
      } else if (difference < oneDay * 2 && difference > oneDay) {
        return "Yesterday";
      } else if (difference > oneDay * 2) {
        return formattedDate;
      }
      // if (difference < oneDay) return "Today";
      // else if (difference < oneday * 2 && difference > oneday)
      //   return "Yesterday";
      // else if (difference > oneday * 2) return formattedDate;
    };

    const html = `<div class="transaction__row ${type}">
  <div class="partner ">${type}</div>
  <div class="amount">${transaction.toFixed(2)}</div>
  <div class="date">${dateFunction(formattedDate)}</div>
</div>`;
    transactionContainer.insertAdjacentHTML("afterbegin", html);
  });
};

// ------------------------------ Event Listeners

btnLogin.forEach((btn) => btn.addEventListener("click", featureLogin));

btnTransfer.addEventListener("click", transferMoney);
btnLoan.addEventListener("click", loanMoney);
btnSort.addEventListener("click", sorting);
