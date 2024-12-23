import { renderAdminBlogs } from "../assets/js/renderer/renderAdminBlogs.js";
import { fetchFromServer } from "../assets/js/util/fetcher.js";
import { deleteBlog } from "../assets/js/api/blog.js";

document.addEventListener("DOMContentLoaded", initAdminBlog);

async function initAdminBlog() {
  await fetchAndRenderBlogs();
  setupDeleteButtons();
}

async function fetchAndRenderBlogs() {
  try {
    const res = await fetchFromServer("adminBlog.php", "GET");
    renderAdminBlogs(res);
    console.log(res);
  } catch (err) {
    console.log("Error while fetching blogs", err);
  }
}
function setupDeleteButtons() {
  const deleteButtons = document.querySelectorAll(".delete-btn");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const conf = confirm("Are you sure you want to delete that blog ?");
      if (conf) {
        const blogId = event.target.getAttribute("data-id");
        deleteBlog(blogId);
      }
    });
  });
}
