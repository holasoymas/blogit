export function setProfilePicture($selector, firstName, lastName, color) {
  // const $profilePic = document.querySelector($selector);
  // console.log(color, firstName, lastName);
  $selector.style.backgroundColor = color;
  $selector.innerText = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
}
