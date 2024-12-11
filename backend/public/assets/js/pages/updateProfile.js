import * as User from "../api/user.js";

document.addEventListener("DOMContentLoaded", async () => {
  const userData = await User.getUserById(uid);
  if (userData) {
    document.querySelector("#fname").value = userData.fname;
    document.querySelector("#lname").value = userData.lname;
    document.querySelector("#dob").value = userData.dob;
    document.querySelector("#email").value = userData.email;
    document.querySelector("#password").value = userData.password;
  }
});

document.querySelector("#register-form").addEventListener("submit", onHandleRegister);

function onHandleRegister(e) {
  e.preventDefault();
  const registerDetails = getRegisterDetails();
  User.updateUser(registerDetails);
  // console.log(registerDetails);
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
