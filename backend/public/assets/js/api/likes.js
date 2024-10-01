import { fetchFromServer } from "../util/fetcher.js";

export async function getLikesByPostId(postId) {
  try {
    const res = await fetchFromServer(`likeRoute.php?pid=${postId}`, "GET");
    return res;
  } catch (err) {
    console.log(err);
  }
}

export async function toggleLike(postId) {
  try {
    const res = await fetchFromServer(`likeRoute.php`, "POST", { postId });
    return res;
  } catch (err) {
    console.log(err);
  }
}
