import { fetchProfile } from "../api/fetchProfile.js";
import { logout } from "../api/user.js";

// cange the fetchProfile to call init and inside init fetchProfile fetchBlog etc
document.addEventListener("DOMContentLoaded", init);

// load user and blogs in the profile
function init() {
    fetchProfile();
    document.querySelector("#logout").addEventListener("click", logout);
}
