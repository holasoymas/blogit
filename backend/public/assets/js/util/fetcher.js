import { getBaseApiUrl } from "../config.js";
import {
  handleBadReqErrors,
  handleUnauthenticatedError,
  handleUnauthorizedError,
} from "./errors.js";

export async function fetchFromServer(endpoint, method, body = null) {
  try {
    const response = await fetch(`${getBaseApiUrl()}/${endpoint}`, buildOptions(method, body));

    if (!response.ok) {
      const errorData = await response.json();
      console.log(errorData);
      const resStatus = response.status;
      switch (resStatus) {
        case 400:
          return handleBadReqErrors(errorData);
        case 401:
          return handleUnauthenticatedError(errorData);
        case 403:
          return handleUnauthorizedError(errorData);
        case 404:
          return handleUserNotFound(errorData);
        default:
          throw new Error(errorData.message || "Registration failed");
      }
    }
    const json = await response.json();
    console.log(json);
    return json;
  } catch (error) {
    // console.error("Fetch error:", error);
    throw error;
  }
}

function buildOptions(method, body) {
  const options = {};

  options.method = method;

  if (body) {
    options.body = JSON.stringify(body);
  }

  options.headers = {
    "Content-Type": "application/json; charset=UTF-8",
  };

  return options;
}
