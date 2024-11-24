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

  suggestions.forEach((item) => {
    const suggestionItem = document.createElement("div");
    suggestionItem.classList.add("suggestion-item");

    const link = document.createElement("a");
    link.style.textDecoration = "none";
    link.style.color = "inherit";

    switch (item.type) {
      case "uid":
        link.href = `http://localhost/blogit/profile.html?uid=${item.id}`;
        break;
      case "pid":
        link.href = `http://localhost/blogit/blog.html?pid=${item.id}`;
        break;
      default:
        break;
    }

    link.textContent = item.text;
    suggestionItem.appendChild(link);

    suggestionItem.classList.add("suggestion-hover");

    suggestionItem.addEventListener("click", () => {
      searchInput.value = item.text;
      suggestionsBox.style.display = "none";
    });

    suggestionsBox.appendChild(suggestionItem);
  });

  suggestionsBox.style.display = "block";
}

document.addEventListener("click", (e) => {
  if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
    suggestionsBox.style.display = "none";
  }
});
