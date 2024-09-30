import { getUserById } from "../api/user.js";
import { getBaseDomainUrl } from "../config.js";

export function renderComments($selector, comments) {
  const $commentSection = document.querySelector($selector);
  $commentSection.innerHTML = "";
  if (!comments) {
    $commentSection.innerHTML = "<h2> 😞 No Comments yet, Be the first one to be</h2>";
    return;
  }
  comments.forEach(async (comnt) => {
    const { user_id, comment } = comnt;
    const user = await getUserById(user_id);
    console.log(user);
    if (!user) return;
    const commentHtml = `
        <div class="comment">
          <p><strong> <a href="${getBaseDomainUrl()}/profile.html?uid=${encodeURIComponent(
            user.id,
          )}">
        ${user.fname} ${user.lname}</a>: </strong>${comment}</p>
        </div>
    `;
    $commentSection.insertAdjacentHTML("beforeend", commentHtml);
  });
}
