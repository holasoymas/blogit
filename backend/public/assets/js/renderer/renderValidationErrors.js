export function renderValidationErrors($selector, errors) {
  const $form = document.querySelector($selector);
  for (const key in errors) {
    $form.querySelector(`#error-${key}`).innerText = errors[key];
  }
}
