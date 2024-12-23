import { getBaseDomainUrl } from "../config.js";
import { renderFullBlogItem } from "../renderer/renderBlog.js";
import { renderComments } from "../renderer/renderComments.js";
import { fetchFromServer } from "../util/fetcher.js";
import { getCommentsByBlog } from "./comment.js";
import { renderNav } from "../renderer/renderNav.js";
import { goNotFoundBlog } from "../util/goErrorPages.js";
import { renderValidationErrors } from "../renderer/renderValidationErrors.js";

export async function addBlog(blogData) {
  try {
    // const response = await fetch(`${getBaseApiUrl()}/blogRoute.php`, {
    //   method: "POST",
    //   body: blogData,
    // });
    const response = await fetchFromServer("blogRoute.php", "POST", blogData);
    console.log(response);

    if (response.status === 401) {
      // alert(result.error);
      window.location.href = `${getBaseDomainUrl()}/login.html`;
      return;
    }
    if (response.status === 400) {
      renderValidationErrors("#blog-form", response.errors);
      return;
    }

    // Parse the response as JSON
    const result = response;
    console.log(result);
    // Handle the response
  } catch (error) {
    // Handle errors
    alert(`An error occurred: ${error}`);
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
    await renderFullBlogItem(".blog-content-area", res.blog);
    const comments = await getCommentsByBlog(pid);
    // console.log(comments);
    // console.log(res);
    renderComments(".comments", comments);
    // render the nav section dynamic
    renderNav(res.loggedInUser);
  } catch (err) {
    console.error(err);
    alert(err);
  }
}

export async function deleteBlog(pid) {
  try {
    const res = await fetchFromServer(`blogRoute.php?pid=${encodeURIComponent(pid)}`, "DELETE");
    console.log(res);
    if (res.status === 401) {
      alert("Please login to delete a blog");
      return;
    }
    if (res.status === 403) {
      alert("Only the owner of the blog can delete a blog");
      return;
    }
    // alert()
  } catch (err) {
    console.log(err);
    alert("Couldn't delete blog, Try again later");
  }
}
