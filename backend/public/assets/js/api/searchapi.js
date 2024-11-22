import { fetchFromServer } from "../util/fetcher.js";

const searchInput = document.getElementById("searchInput");
const suggestionsBox = document.getElementById("suggestionsBox");

searchInput.addEventListener("input", async () => {
  const query = searchInput.value.trim();
  const suggessData = await fetchSugessions(query);
  console.log(suggessData);
  renderSuggestions(suggessData);
});

async function fetchSugessions(query) {
  try {
    const data = await fetchFromServer(`searchRoute.php?query=${encodeURIComponent(query)}`, "GET");
    return data;
  } catch (err) {
    console.error("Error while seaching : ", err);
  }
}

export function renderSuggestions(suggestions) {
  suggestionsBox.innerHTML = "";
  if (suggestions.length === 0) {
    suggestionsBox.style.display = "none";
    return;
  }

  suggestions.forEach((user) => {
    const suggestionItem = document.createElement("div");
    suggestionItem.classList.add("suggestion-item");
    suggestionItem.textContent = user;

    // Click event to select suggestion
    suggestionItem.addEventListener("click", () => {
      searchInput.value = user;
      suggestionsBox.style.display = "none"; // Hide suggestions
    });

    suggestionsBox.appendChild(suggestionItem);
  });

  suggestionsBox.style.display = "block"; // Show the suggestions box
}

// Hide suggestions when clicking outside the input
document.addEventListener("click", (e) => {
  if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
    suggestionsBox.style.display = "none";
  }
});
