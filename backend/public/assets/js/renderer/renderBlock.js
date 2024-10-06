export function renderBlock($selector, isBlockedBy) {
  const $blockSelector = document.querySelector($selector);
  $blockSelector.innerHTML = "";
  const $renderAlreadyBlocked = `
        <button disabled>🚫 Request for block send</button>
    `;

  const $blockArea = `
        <input type="text" placeholder="Enter text..." />
        <button>🚫 Request for block</button>
    `;
  if (isBlockedBy) {
    $blockSelector.insertAdjacentHTML("beforeend", $renderAlreadyBlocked);
    return;
  }
  $blockSelector.insertAdjacentHTML("beforeend", $blockArea);
}
