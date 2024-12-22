import { renderBlogs, renderPopularBlogs } from "../renderer/renderBlog.js";
import { renderNav } from "../renderer/renderNav.js";
import { fetchFromServer } from "../util/fetcher.js";

export async function fetchIndexPage() {
  try {
    const res = await fetchFromServer("indexRoute.php", "GET");
    console.log(res);
    const { loggedInUser, blogs } = res;
    renderNav(loggedInUser);
    renderBlogs(".blog-section", blogs);
    renderPopularBlogs(".popular-blogs", blogs);
    const btns = document.querySelectorAll(".report-blog");

    btns.forEach((btn) => {
      btn.addEventListener("click", async () => {
        // console.log("you clicked me ");
        if (!loggedInUser) {
          alert("Please login first to report a blog");
          return;
        }
        const reported_blog = btn.closest("[data-blog-id]").dataset.blogId;
        const report_reason = prompt("Block reason:");

        if (!report_reason || report_reason.trim().length < 10) {
          alert(
            !report_reason
              ? "Please provide a valid reason."
              : "The reason must be at least 10 characters long.",
          );
          return;
        }

        try {
          const reported_by = loggedInUser;
          await fetchFromServer("reportBlog.php", "POST", {
            reported_blog,
            reported_by,
            report_reason,
          });
          // console.log(res);
          alert("Report send successfully");
        } catch (err) {
          console.error(err);
          alert("Something went wrong, please try again later");
        }
      });
    });
    // console.log(btns);
    // console.log(res);
  } catch (err) {
    console.error(err);
  }
}
