import { fetchFromServer } from "../util/fetcher.js";

export async function registerUser(userData) {
  fetchFromServer("/userRoute.php", "POST", userData)
    .then((json) => console.log(json))
    .catch((err) => console.log(err));
}
