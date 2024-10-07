export function renderAdminUsers(users) {
  const $usersTableBody = document.getElementById("users");
  $usersTableBody.innerHTML = ""; // Clear existing rows

  if (!users) {
    $usersTableBody.insertAdjacentHTML(
      "beforeend",
      "<tr><td colspan='4'>No users found.</td></tr>",
    );
    return;
  }
  users.forEach((user) => {
    const userRow = `
            <tr>
                <td>${user.id}</td>
                <td>${user.fname} ${user.lname}</td>
                <td>${user.email}</td>
                <td>${user.block_req_nums}</td>
                <td><button class="delete-btn" onclick="deleteUser(${user.id})">Delete</button></td>
            </tr>
        `;
    $usersTableBody.insertAdjacentHTML("beforeend", userRow);
  });
}
