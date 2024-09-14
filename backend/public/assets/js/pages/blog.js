import * as Blog from "../api/blog.js";
document.addEventListener("DOMContentLoaded", Blog.getAddBlogPage);
document.querySelector("#blog-form").addEventListener("submit", onHandlePost);

function onHandlePost(e) {
  e.preventDefault();
  const blogDetails = getBlogDetails();
  Blog.addBlog(blogDetails);
}

function getBlogDetails() {
  return {
    title: document.querySelector("#title").value,
    content: document.querySelector("#content").value,
  };
}
