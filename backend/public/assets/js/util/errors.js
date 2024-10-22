export function handleBadReqErrors(errorData) {
  return { status: 400, errors: errorData.errors };
}

export function handleUnauthenticatedError(errorData) {
  return { status: 401, error: errorData.error };
}

export function handleUnauthorizedError() {
  return { status: 403 };
}

export function handleUserNotFound(errorData) {
  return { status: 404, error: errorData.error };
}

export function handleDataConflict(errorData) {
  return { status: 409, error: errorData.error };
}
