async function fetchFromServer(endpoint, method, body = null) {
  try {
    const response = await fetch(`${getBaseApiUrl()}/${endpoint}`, buildOptions(method, body));

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const json = await response.json();

    if (json.errors) {
      throw new Error(JSON.stringify(json.errors));
    }

    console.log(json);
    return json;
  } catch (error) {
    console.error("Fetch failed:", error);
    throw error; // Rethrow the error after logging it
  }
}

function buildOptions(method, body) {
  if (!method) {
    throw new Error("HTTP method is required");
  }

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
