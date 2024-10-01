import { getBaseDomainUrl } from "../config.js";
import { handleToggleLikeBtn } from "../pages/like.js";
import { formatDate } from "../util/dateFormatter.js";
import { setProfilePicture } from "../util/genprofilepic.js";
import { renderCurrLikeStat } from "./renderLike.js";

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
  // $template.querySelector(".blog-title").innerText = blog.title;

  const $blogLink = $template.querySelector(".blog-link");
  $blogLink.href = `${getBaseDomainUrl()}/blog.html?pid=${blog.pid}`; // Assuming you have a route for blog posts like /blog/{id}
  $blogLink.querySelector(".blog-title").innerText = blog.title;

  $template.querySelector(".blog-meta").innerText = `Posted on ${formatDate(blog.created_at)}`;
  $template.querySelector(".blog-content").innerText = blog.content;

  $template.querySelector(".read-more-link").href = `${getBaseDomainUrl()}/blog.html?pid=${
    blog.pid
  }`;

  return $template;
}

export async function renderFullBlogItem($selector, blog) {
  const $container = document.querySelector($selector);
  const $fullBlogItem = await renderFullBlog(blog);
  $container.insertAdjacentHTML("beforeend", $fullBlogItem.outerHTML);

  const $likeBtn = document.querySelector(".inner-like-btn svg");
  console.log($likeBtn);
  $likeBtn.addEventListener("click", () => {
    handleToggleLikeBtn(blog.pid);
  });
}

async function renderFullBlog(blog) {
  const $template = document
    .querySelector("#full-blog-template")
    .content.firstElementChild.cloneNode(true);
  // console.log($template);
  // $container.innerHTML = "";
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

  // Like part
  const postId = blog.pid;
  await renderCurrLikeStat($template, postId);

  return $template;
}
