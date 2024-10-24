import { renderAdminUsers } from "../assets/js/renderer/renderAdminUsers.js";
import { fetchFromServer } from "../assets/js/util/fetcher.js";
import { deleteUser } from "../assets/js/api/user.js";

document.addEventListener("DOMContentLoaded", initAdmin);

async function initAdmin() {
  await fetchAndRenderUsers();
  setupDeleteButtons();
}

async function fetchAndRenderUsers() {
  try {
    const res = await fetchFromServer("adminUser.php", "GET");
    console.log(res);
    renderAdminUsers(res);
  } catch (err) {
    console.log("Error fetching users:", err);
  }
}

function setupDeleteButtons() {
  const deleteButtons = document.querySelectorAll(".delete-btn");
  deleteButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      const userId = event.target.getAttribute("data-id");
      deleteUser(userId);
    });
  });
}
