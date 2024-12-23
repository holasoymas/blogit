import { deleteBlog } from "../api/blog.js";
import { fetchProfile } from "../api/fetchProfile.js";
import { logout } from "../api/user.js";

// cange the fetchProfile to call init and inside init fetchProfile fetchBlog etc
document.addEventListener("DOMContentLoaded", init);

async function init() {
  document.querySelector("#logout").addEventListener("click", logout);
  await fetchProfile(); // Wait for fetchProfile to complete
  attachDeleteListeners();
  attachUpdateListeners();
}

function attachDeleteListeners() {
  const deleteButtons = document.querySelectorAll(".delete-btn button");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", async function () {
      if (confirm("Are you sure you want to delete this blog?")) {
        console.log("User confirmed deletion");
        const article = this.closest("article");
        const blogId = article.dataset.blogId;
        await deleteBlog(blogId);
        window.location.reload();
      } else {
        console.log("User canceled deletion");
      }
    });
  });
}

function attachUpdateListeners() {
  const deleteButtons = document.querySelectorAll(".update-btn button");

  deleteButtons.forEach((button) => {
    button.addEventListener("click", async function () {
      console.log("btn click");
      const article = this.closest("article");
      const blogId = article.dataset.blogId;
      window.location.href = `http://localhost/blogit/updateBlog.html?pid=${blogId}`;
    });
  });
}
