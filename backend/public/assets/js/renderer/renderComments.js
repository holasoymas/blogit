export function renderComments($selector, comments) {
  const $commentSection = document.querySelector($selector);
  $commentSection.innerHTML = "";
  if (!comments) {
    $commentSection.innerHTML = "<h1>No Comments yet, Be the first one to be</h1>";
    return;
  }
  comments.forEach((comment) => {
    const commentHtml = `
        <div class="comment">
          <p><strong>${comment.user_id}: </strong>${comment.comment}</p>
        </div>
    `;
    $commentSection.insertAdjacentHTML("beforeend", commentHtml);
  });
}
