import { getBaseDomainUrl } from "../config.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function addBlog(blogData) {
  fetchFromServer("blogRoute.php", "POST", blogData)
    .then((res) => {
      if (res.status === 401) {
        alert(res.error);
        window.location.href = `${getBaseDomainUrl()}/login.html`;
      }
    })
    .catch((err) => alert(err.message));
}

// function to check instantly if the user is authorized to add a blog
export async function getAddBlogPage() {
  fetchFromServer("blogRoute.php", "GET")
    .then((res) => {
      console.log(res);
      if (res.status === 401) {
        alert(res.error);
        window.location.href = `${getBaseDomainUrl()}/login.html`;
      }
    })
    .catch((err) => alert(err.message));
}

// export async function getBlogsByUser(uid) {
//   fetchFromServer("blogRoute.php", "GET")
//     .then((res) => {
//       console.log(res);
//     })
//     .catch((err) => err.message);
// }
