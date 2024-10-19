import { renderBlogs } from "../renderer/renderBlog.js";
import { renderNav } from "../renderer/renderNav.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function fetchIndexPage() {
  try {
    const res = await fetchFromServer("indexRoute.php", "GET");
    console.log(res);
    const { loggedInUser, blogs } = res;
    renderNav(loggedInUser);
    renderBlogs(".blog-section", blogs);
    console.log(res);
  } catch (err) {
    console.error(err);
  }
}
