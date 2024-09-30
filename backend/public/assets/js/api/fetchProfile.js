import { renderUserProfile } from "../renderer/renderUser.js";
import { renderBlogs } from "../renderer/renderBlog.js";
import { fetchFromServer } from "../util/fetcher.js";
import { renderNav } from "../renderer/renderNav.js";

export async function fetchProfile() {
  try {
    const params = new URLSearchParams(window.location.search);
    const uid = params.get("uid");

    const json = await fetchFromServer(`profileRoute.php?uid=${encodeURIComponent(uid)}`, "GET");
    const { loggedInUser, user, blogs } = json;

    renderNav(loggedInUser);
    renderUserProfile(".profile-section", user);
    renderBlogs(".blog-section", blogs);
  } catch (err) {
    console.log(err);
  }
}
