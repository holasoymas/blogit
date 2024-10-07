import { renderAdminUsers } from "../assets/js/renderer/renderAdminUsers.js";
import { fetchFromServer } from "../assets/js/util/fetcher.js";

document.addEventListener("DOMContentLoaded", initAdmin);

async function initAdmin() {
  try {
    const res = await fetchFromServer("adminUser.php", "GET");
    console.log(res);
    renderAdminUsers(res);
  } catch (err) {
    console.log(err);
  }
}
