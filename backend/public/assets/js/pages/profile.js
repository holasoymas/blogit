import { fetchFromServer } from "../util/fetcher.js";

document.addEventListener("DOMContentLoaded", fetchProfile);

function fetchProfile() {
  const params = new URLSearchParams(window.location.search);
  const uid = params.get("uid");
  console.log(uid);

  fetchFromServer(`userRoute.php?uid=${encodeURIComponent(uid)}`, "GET")
    .then((json) => console.log(json))
    .catch((err) => console.log(err));
}
