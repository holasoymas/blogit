import { renderUserProfile } from "../renderer/renderUser.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function registerUser(userData) {
  fetchFromServer("userRoute.php", "POST", userData)
    .then((json) => console.log(json))
    .catch((err) => console.log(err));
}

export async function loginUser(userData) {
  fetchFromServer("login.php", "POST", userData)
    .then((json) => console.log(json))
    .catch((err) => console.log(err));
}

export function fetchProfile() {
  const params = new URLSearchParams(window.location.search);
  const uid = params.get("uid");
  // console.log(uid);

  fetchFromServer(`userRoute.php?uid=${encodeURIComponent(uid)}`, "GET")
    .then((json) => renderUserProfile(".profile-section", json))
    // .then((json) => console.log(json))
    .catch((err) => console.log(err));
}
