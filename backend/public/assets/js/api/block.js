import { renderBlock } from "../renderer/renderBlock.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function addBlock(blockData) {
  try {
    const res = await fetchFromServer("blockRoute.php", "POST", blockData);
    if (res.status === 401) {
      alert("Login to request for a block");
      return;
    }
    console.log(res);
    renderBlock(".block-box", res.isBlockedBy);
  } catch (err) {
    console.log(err);
  }
}
