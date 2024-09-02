import { getBaseApiUrl } from "../config.js";

export async function fetchFromServer(endpoint, method, body = null) {
  try {
    const response = await fetch(`${getBaseApiUrl()}/${endpoint}`, buildOptions(method, body));

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || "Registration failed");
    }

    const json = await response.json();
    return json;
  } catch (error) {
    console.error("Fetch error:", error);
    throw error;
  }
}

function buildOptions(method, body) {
  const options = {
    method,
    headers: {
      "Content-Type": "application/json; charset=UTF-8",
    },
  };

  if (body) {
    options.body = JSON.stringify(body);
  }

  return options;
}
