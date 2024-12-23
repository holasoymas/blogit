import { renderUserProfile } from "../renderer/renderUser.js";
import { renderBlogs } from "../renderer/renderBlog.js";
import { fetchFromServer } from "../util/fetcher.js";
import { renderNav } from "../renderer/renderNav.js";
import { renderBlock } from "../renderer/renderBlock.js";
import { initBlock } from "../pages/block.js";
import { hasBlocked } from "./block.js";
import { goNotFoundUser } from "../util/goErrorPages.js";

export async function fetchProfile() {
  try {
    const params = new URLSearchParams(window.location.search);
    const uid = params.get("uid");

    const json = await fetchFromServer(`profileRoute.php?uid=${encodeURIComponent(uid)}`, "GET");
    if (json.error && json.status === 404) return goNotFoundUser();
    const { loggedInUser, user, blogs } = json;
    console.log(json);
    renderNav(loggedInUser);
    renderUserProfile(".profile-section", user);
    renderBlogs(".blog-section", blogs);
    const isBlockedBy = await hasBlocked(uid);
    if (uid == loggedInUser) {
      document.querySelector(".block-box").style.display = "none";
    }
    if (uid != loggedInUser) {
      document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.style.display = "none";
      });
      document.querySelectorAll(".update-btn").forEach((btn) => {
        btn.style.display = "none";
      });
    }
    renderBlock(".block-box", isBlockedBy);
    //after rendering only init the click event
    initBlock();
  } catch (err) {
    console.log(err);
  }
}
