import { getBaseDomainUrl } from "../config.js";
import { renderFullBlogItem } from "../renderer/renderBlog.js";
import { renderComments } from "../renderer/renderComments.js";
import { fetchFromServer } from "../util/fetcher.js";
import { getCommentsByBlog } from "./comment.js";

export async function addBlog(blogData) {
  fetchFromServer("blogRoute.php", "POST", blogData)
    .then((res) => {
      if (res.status === 401) {
        alert(res.error);
        window.location.href = `${getBaseDomainUrl()}/login.html`;
      }
    })
    .catch((err) => alert(err.message));
}

// function to check instantly if the user is authorized to add a blog
export async function getAddBlogPage() {
  fetchFromServer("blogRoute.php", "GET")
    .then((res) => {
      console.log(res);
      if (res.status === 401) {
        alert(res.error);
        window.location.href = `${getBaseDomainUrl()}/login.html`;
      }
    })
    .catch((err) => alert(err.message));
}

export async function fetchBlogPage() {
  try {
    const params = new URLSearchParams(window.location.search);
    const pid = params.get("pid");
    const res = await fetchFromServer(`blogRoute.php?pid=${encodeURIComponent(pid)}`, "GET");
    const comments = await getCommentsByBlog(pid);
    console.log(comments);
    console.log(res);
    renderFullBlogItem(".blog-content", res);
    renderComments(".comments", comments);
    // renderFullBlogItem("article", res);
  } catch (err) {
    alert(err);
  }
}
