export function formatDate(date) {
  const dateObj = new Date(date);

  // Extract parts of the date
  const options = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    hour12: true,
  };

  const formattedDate = dateObj.toLocaleString("en-US", options);
  return formattedDate;
}
