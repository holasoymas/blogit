import { addComment } from "../api/comment.js";

document.querySelector("#handle-add-blog").addEventListener("click", handleAddComment);

function handleAddComment() {
  console.log("you clicked me ");
  const commentDetails = getCommentDetails();
  console.log(commentDetails);
  addComment(commentDetails);
}

function getCommentDetails() {
  const $blogSec = document.querySelector("article");
  const pid = $blogSec.dataset.blogId;
  const comment = document.querySelector("#comment").value;
  return {
    pid,
    comment,
  };
}
