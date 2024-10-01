import { toggleLike } from "../api/likes.js";
import { updateCurrentLikeStat } from "../renderer/renderLike.js";

export function handleToggleLikeBtn(postId) {
  toggleLike(postId)
    .then((data) => {
      console.log(data);
      if (data.status === 401) {
        alert(data.error);
        return;
      }
      updateCurrentLikeStat(".inner-like-btn", data);
    })
    .catch((err) => console.log(err));
}
