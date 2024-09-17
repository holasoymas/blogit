import { getBaseDomainUrl } from "../config.js";
import { renderComments } from "../renderer/renderComments.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function addComment(commentData) {
  try {
    const res = await fetchFromServer("commentRoute.php", "POST", commentData);
    if (res.status === 401) {
      alert("Login first to comment");
      window.location.href = `${getBaseDomainUrl()}/login.html`;
      return;
    }
    console.log(res);
    renderComments(".comments", res);
  } catch (err) {
    console.log(err);
  }
}

export async function getCommentsByBlog(pid) {
  try {
    const res = await fetchFromServer(`commentRoute.php?pid=${encodeURIComponent(pid)}`, "GET");
    console.log(res);
    return res;
  } catch (err) {
    console.log(err);
  }
}
