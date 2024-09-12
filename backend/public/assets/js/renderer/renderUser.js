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

  $cont.insertAdjacentHTML("beforeend", $template.outerHTML);
}
