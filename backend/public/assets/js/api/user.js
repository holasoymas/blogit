import { renderValidationErrors } from "../renderer/renderValidationErrors.js";
import { fetchFromServer } from "../util/fetcher.js";
import { getBaseDomainUrl } from "../config.js";

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

export async function updateUser(userData) {
  try {
    const res = await fetchFromServer("userRoute.php", "PUT", userData);
    if (res.status === 400) {
      renderValidationErrors("#register-form", res.errors);
    }
    if (res.userId) {
      alert("User updated successfully");
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
    if (res.status === 401) {
      alert(res.error);
    }
    if (res.status === 400) renderValidationErrors("#login-container", res.errors);
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
    if (res.status === 404) return null;

    return res;
  } catch (err) {
    alert(err.message);
    return null;
  }
}

export async function logout(e) {
  e.preventDefault();
  try {
    const res = await fetchFromServer("logout.php", "POST");
    console.log(res, "wolla wolla");
    if (res.status === "success") window.location.reload();
    if (res.status === 400) alert(res.errors);
  } catch (err) {
    alert("Error occured", err.message);
  }
}

export async function deleteUser(uid) {
  const conf = confirm("Are you sure you want to delete this user ?");
  if (!conf) return;
  try {
    const res = await fetchFromServer(`userRoute.php?uid=${encodeURIComponent(uid)}`, "DELETE");
    console.log(res);
    alert(res.message);
  } catch (err) {
    console.error(err);
  }
}
