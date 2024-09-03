import * as User from "../api/user.js";
document.querySelector("#register-form").addEventListener("submit", onHandleRegister);

function onHandleRegister(e) {
  e.preventDefault();
  const registerDetails = getRegisterDetails();
  User.registerUser(registerDetails);
  console.log(registerDetails);
}

function getRegisterDetails() {
  return {
    fname: document.querySelector("#fname").value,
    lname: document.querySelector("#lname").value,
    dob: document.querySelector("#dob").value,
    email: document.querySelector("#email").value,
    password: document.querySelector("#password").value,
  };
}
