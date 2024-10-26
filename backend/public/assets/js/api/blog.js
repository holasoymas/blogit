import { getBaseApiUrl, getBaseDomainUrl } from "../config.js";
import { renderFullBlogItem } from "../renderer/renderBlog.js";
import { renderComments } from "../renderer/renderComments.js";
import { fetchFromServer } from "../util/fetcher.js";
import { getCommentsByBlog } from "./comment.js";
import { renderNav } from "../renderer/renderNav.js";
import { goNotFoundBlog } from "../util/goErrorPages.js";
import { renderValidationErrors } from "../renderer/renderValidationErrors.js";

export async function addBlog(blogData) {
  try {
    const response = await fetch(`${getBaseApiUrl()}/blogRoute.php`, {
      method: "POST",
      body: blogData,
    });
    // Check if the response is OK
    if (!response.ok) {
      const result = await response.json();
      console.log(result);
      if (response.status === 401) {
        alert(result.error);
        window.location.href = `${getBaseDomainUrl()}/login.html`;
        return;
      }
      if (response.status === 400) {
        renderValidationErrors("#blog-form", result.errors);
        return;
      }
    }

    // Parse the response as JSON
    const result = await response.json();
    console.log(result);
    // Handle the response
  } catch (error) {
    // Handle errors
    alert(`An error occurred: ${error.message}`);
  }
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
    if (!pid) goNotFoundBlog();
    const res = await fetchFromServer(`blogRoute.php?pid=${encodeURIComponent(pid)}`, "GET");
    if (res.status === 404) return goNotFoundBlog();
    const comments = await getCommentsByBlog(pid);
    // console.log(comments);
    // console.log(res);
    await renderFullBlogItem(".blog-content-area", res.blog);
    renderComments(".comments", comments);
    // render the nav section dynamic
    renderNav(res.loggedInUser);
  } catch (err) {
    alert(err);
  }
}
