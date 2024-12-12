import { toLocaleStr } from "../util/dateFormatter.js";
import { setProfilePicture } from "../util/genprofilepic.js";

export function renderUserProfile($container, userData) {
  console.log(userData);
  const $cont = document.querySelector($container);
  const $template = document
    .querySelector("#profile-card-template")
    .content.firstElementChild.cloneNode(true);

  $cont.innerHTML = "";
  $template.dataset.userId = userData.id;

  const $profilePic = $template.querySelector(".profile-pic");
  // console.log($profilePic);
  setProfilePicture($profilePic, userData.fname, userData.lname, userData.profile_pic);

  $template.querySelector(".profile-name").innerText = `${userData.fname} ${userData.lname}`;
  $template.querySelector(".profile-email").innerText = userData.email;
  $template.querySelector(".profile-blogs").innerText = userData.blog_count;
  // $template.querySelector(".profile-likes").innerText = userData.total_likes;
  // $template.querySelector(".profile-comments").innerText = userData.comment_count;
  $template.querySelector(".profile-join-date").innerText = `${toLocaleStr(userData.created_at)}`;

  $cont.insertAdjacentHTML("beforeend", $template.outerHTML);
}
