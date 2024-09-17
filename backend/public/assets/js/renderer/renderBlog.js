import { formatDate } from "../util/dateFormatter.js";
import { setProfilePicture } from "../util/genprofilepic.js";

export function renderBlogs(selector, blogs) {
  const $container = document.querySelector(selector);
  $container.innerHTML = "";
  blogs.forEach((blog) => renderBlog($container, blog));
}

function renderBlog($container, blog) {
  const $blogItem = renderBlogItem(blog);
  $container.insertAdjacentHTML("beforeend", $blogItem.outerHTML);
}

function renderBlogItem(blog) {
  const $template = document
    .querySelector("#blog-template")
    .content.firstElementChild.cloneNode(true);

  $template.dataset.blogId = blog.pid;
  $template.querySelector(".blog-title").innerText = blog.title;
  $template.querySelector(".blog-meta").innerText = `Posted on ${formatDate(blog.created_at)}`;
  $template.querySelector(".blog-content").innerText = blog.content;

  return $template;
}

export function renderFullBlogItem($selector, blog) {
  const $container = document.querySelector($selector);
  $container.innerHTML = "";
  const $fullBlogItem = renderFullBlog(blog);
  $container.insertAdjacentHTML("beforeend", $fullBlogItem.outerHTML);
}

function renderFullBlog(blog) {
  const $template = document
    .querySelector("#full-blog-template")
    .content.firstElementChild.cloneNode(true);
  // console.log($template);
  $template.dataset.blogId = blog.pid;
  $template.querySelector("h1").innerText = blog.title;
  $template.querySelector(".blog-meta").innerText = `Posted on ${formatDate(blog.created_at)}`;
  $template.querySelector(".blog").innerText = blog.content;

  const $authorSection = $template.querySelector(".author-section");
  $authorSection.dataset.userId = blog.uid;
  const $authorPic = $authorSection.querySelector(".author-pic");
  $authorSection.querySelector("span").innerContent = setProfilePicture(
    $authorPic,
    blog.fname,
    blog.lname,
    blog.profile_pic,
  );
  $authorSection.querySelector(".author-info strong").innerText = `${blog.fname} ${blog.lname}`;
  $authorSection.querySelector(".author-email").innerText = `Email ${blog.email}`;
  return $template;
}
