import { getBaseApiUrl } from "../config.js";
import { renderValidationErrors } from "../renderer/renderValidationErrors.js";

document.getElementById("uploadForm").addEventListener("submit", async function (e) {
  e.preventDefault();

  // Clear previous errors
  renderValidationErrors("#uploadForm", {});
  const formData = new FormData(this);
  const progressDiv = document.getElementById("uploadProgress");

  progressDiv.style.display = "block";
  // progressDiv.textContent = "Uploading...";
  progressDiv.className = "upload-progress";

  try {
    const response = await fetch(`${getBaseApiUrl()}/blogRoute.php`, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      if (response.status === 401) {
        // If the user is not authenticated, alert them
        alert("Unauthorized: Please login first.");
      } else if (response.status === 400) {
        // If it's a 400 error, it's typically a validation issue
        const errorData = await response.json();
        if (errorData.errors) {
          // Render validation errors if they exist
          renderValidationErrors("#uploadForm", errorData.errors);
        }
      } else {
        throw new Error("Network response was not ok");
      }
      return;
    }

    const data = await response.json();
    console.log(data);

    progressDiv.textContent = "Upload successful!";
    progressDiv.classList.add("success");

    setTimeout(() => {
      window.location.href = `http://localhost/blogit/blog.html?pid=${data.pid}`;
    }, 1000);
  } catch (error) {
    progressDiv.textContent = "Upload failed: " + error.message;
    progressDiv.classList.add("error");
  }
});
