import { fetchIndexPage } from "../api/fetchIndexPage.js";
import { logout } from "../api/user.js";

document.addEventListener("DOMContentLoaded", init);

// load user and blogs in the profile
function init() {
  fetchIndexPage();
  document.querySelector("#logout").addEventListener("click", logout);
}
