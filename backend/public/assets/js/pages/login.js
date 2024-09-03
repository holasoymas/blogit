import * as User from "../api/user.js";

document.querySelector("#login-container").addEventListener("submit", onHandleLogin);

function onHandleLogin(e) {
  e.preventDefault();
  const loginDetails = getLoginDetails();
  User.loginUser(loginDetails);
}

function getLoginDetails() {
  return {
    email: document.querySelector("#login-container #email").value,
    password: document.querySelector("#login-container #password").value,
  };
}
