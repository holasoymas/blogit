export function setProfilePicture($selector, firstName, lastName, color) {
  $selector.style.backgroundColor = color;
  // $selector.style.textAlign = "center";
  $selector.innerText = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
}
