import { addBlock } from "../api/block.js";

export function initBlock() {
  document.querySelector(".block-box button").addEventListener("click", handleBlock);
}

function handleBlock() {
  console.log("btn clikced bllocked");
  const blockTo = document.querySelector(".profile-card").dataset.userId;
  const blockMsg = document.querySelector(".block-box input").value;
  console.log({ blockMsg, blockTo });
  addBlock({ blockTo, blockMsg });
}
