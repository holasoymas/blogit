import { renderUserProfile } from "../renderer/renderUser.js";
import { renderValidationErrors } from "../renderer/renderValidationErrors.js";
import { fetchFromServer } from "../util/fetcher.js";
import { getBaseDomainUrl } from "../config.js";
import { setProfilePicture } from "../util/genprofilepic.js";
import { renderBlogs } from "../renderer/renderBlog.js";

export async function registerUser(userData) {
  try {
    const res = await fetchFromServer("userRoute.php", "POST", userData);
    console.log(res);
    if (res.status === 400) {
      renderValidationErrors("#register-form", res.errors);
    }
    if (res.userId) {
      window.location.href = `${getBaseDomainUrl()}/profile.html?uid=${encodeURIComponent(
        res.userId,
      )}`;
    }
  } catch (err) {
    alert(err.message);
  }
}

export async function loginUser(userData) {
  try {
    const res = await fetchFromServer("login.php", "POST", userData);
    if (res.status === 400) {
      alert(res.errors);
    }
    if (res.userId) {
      window.location.href = `${getBaseDomainUrl()}/profile.html?uid=${encodeURIComponent(
        res.userId,
      )}`;
    }
  } catch (err) {
    console.log(err);
  }
}

export async function getUserById(uid) {
  try {
    const res = await fetchFromServer(`userRoute.php?uid=${encodeURIComponent(uid)}`, "GET");
    if (res.status === 404) {
      return null;
    }
    return res;
  } catch (err) {
    alert(err.message);
    return null;
  }
}

export async function fetchProfile() {
  try {
    const params = new URLSearchParams(window.location.search);
    const uid = params.get("uid");

    const json = await fetchFromServer(`profileRoute.php?uid=${encodeURIComponent(uid)}`, "GET");

    const { loggedInUser, user, blogs } = json;
    const $navProfilePic = document.querySelector(".nav-profile-pic");

    if (loggedInUser) {
      const loggedUserData = await getUserById(loggedInUser);
      console.log(loggedUserData);
      if (!loggedUserData) {
        $navProfilePic.classList.add("hidden");
      } else {
        $navProfilePic.classList.remove("hidden");
        const { fname, lname, profile_pic } = loggedUserData;
        setProfilePicture($navProfilePic, fname, lname, profile_pic);
      }
    } else {
      $navProfilePic.classList.add("hidden");
    }
    renderUserProfile(".profile-section", user);
    renderBlogs(".blog-section", blogs);
  } catch (err) {
    console.log(err);
  }
}
