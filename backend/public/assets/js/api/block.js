import { renderBlock } from "../renderer/renderBlock.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function addBlock(blockData) {
  try {
    const res = await fetchFromServer("blockRoute.php", "POST", blockData);
    if (res.status && res.status === 401) {
      alert("Login to request for a block");
      return;
    }
    if (res.status && res.status === 409) {
      renderBlock(".block-box", null);
      return;
    }
    console.log(res);
    renderBlock(".block-box", res);
  } catch (err) {
    throw err;
  }
}

export async function hasBlocked(blockTo) {
  try {
    const res = await fetchFromServer(`blockRoute.php?blockTo=${blockTo}`, "GET");
    console.log("isbeing blocked", res);
    if (res.status && res.status === 404) {
      return null;
    }
    return res;
  } catch (err) {
    console.log(err);
  }
}
