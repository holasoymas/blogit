import { fetchBlogPage } from "../api/blog.js";
import { logout } from "../api/user.js";

// cange the fetchProfile to call init and inside init fetchProfile fetchBlog etc
document.addEventListener("DOMContentLoaded", init);

// load user and blogs in the profile
function init() {
    fetchBlogPage();
    document.querySelector("#logout").addEventListener("click", logout);
}
