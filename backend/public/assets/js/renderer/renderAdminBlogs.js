export function renderAdminBlogs(blogs) {
  const $blogsTableBody = document.getElementById("blogs");
  $blogsTableBody.innerHTML = ""; // Clear existing rows

  if (!blogs) {
    $blogsTableBody.insertAdjacentHTML(
      "beforeend",
      "<tr><td colspan='4'>No blogs found.</td></tr>",
    );
    return;
  }
  blogs.forEach((blog) => {
    const blogRow = `
        <tr>
        <td>${blog.reported_by}</td>
        <td>${blog.report_reason}</td>
        <td>${blog.reported_blog}</td>
        <td>${blog.no_of_reports}</td>
        <td><button class="delete-btn" data-id="${blog.reported_blog}">Delete</button></td>
      </tr>    
     `;
    $blogsTableBody.insertAdjacentHTML("beforeend", blogRow);
  });
}
