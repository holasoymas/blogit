import { getLikesByPostId } from "../api/likes.js";

export async function renderCurrLikeStat($selector, postId) {
  const likeData = await getLikesByPostId(postId);
  if (likeData) {
    console.log(likeData);
    $selector.querySelector(".like-count").innerText = likeData.like_count;

    const $heart = $selector.querySelector(".heart");
    if (likeData.hasLiked) {
      $heart.classList.add("liked");
    } else {
      $heart.classList.remove("liked");
    }

    // $selector
    //   .querySelector(".heart-path")
    //   .setAttribute("fill", likeData.hasLiked ? "#ff3366" : "none");
  }
}

export async function updateCurrentLikeStat($selector, likeData) {
  const $likePart = document.querySelector($selector);
  $likePart.querySelector(".like-count").innerText = likeData.like_count;

  const $heart = $likePart.querySelector(".heart");
  if (likeData.hasLiked) {
    $heart.classList.add("liked");
  } else {
    $heart.classList.remove("liked");
  }

  // $likePart
  // .querySelector(".heart-path")
  // .setAttribute("fill", likeData.hasLiked ? "#ff3366" : "none");
}
