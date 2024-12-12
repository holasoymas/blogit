import { getBaseApiUrl, getBaseDomainUrl } from "../config.js";
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

export function renderPopularBlogs($container, blogs) {
  const $section = document.querySelector($container);

  if (!$section) {
    console.error("Container not found!");
    return;
  }

  const sortedBlogs = blogs
    .map((blog) => ({
      ...blog,
      popularity: (blog.likes + blog.comments) / 2,
    }))
    .sort((a, b) => b.popularity - a.popularity)
    .slice(0, 3);

  const $list = $section.querySelector("ul");
  $list.innerHTML = "";
  // console.log(sortedBlogs);

  sortedBlogs.forEach((blog) => {
    const listItem = document.createElement("li");
    listItem.innerHTML = `
      <a href="http://localhost/blogit/blog.html?pid=${blog.blog_id}" 
         class="popular-post-link" 
         title="${blog.blog_title}">
        ${blog.blog_title}
      </a>
    `;
    $list.appendChild(listItem);
  });
}

function renderBlogItem(blog) {
  const $template = document
    .querySelector("#blog-template")
    .content.firstElementChild.cloneNode(true);
  $template.dataset.blogId = blog.blog_id;
  // $template.querySelector(".blog-title").innerText = blog.title;

  const $blogLink = $template.querySelector(".blog-link");
  $blogLink.href = `${getBaseDomainUrl()}/blog.html?pid=${blog.blog_id}`;
  $blogLink.querySelector(".blog-title").innerText = blog.blog_title;

  $template.querySelector(".blog-meta").innerText = `Posted on ${formatDate(blog.blog_created_at)}`;
  const $blogImage = $template.querySelector(".blog-image");
  if ($blogImage) {
    $blogImage.src = `${getBaseApiUrl()}/uploads/${blog.blog_image}`;
    $blogImage.alt = blog.blog_title;
  }
  $template.querySelector(".blog-content").innerText = blog.blog_content;

  $template.querySelector(".read-more-link").href = `${getBaseDomainUrl()}/blog.html?pid=${
    blog.blog_id
  }`;
  $template.querySelector(".post-like span").innerText = blog.blog_likes;
  $template.querySelector(".post-comment span").innerText = `${blog.blog_comments} Comments`;

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
  const $blogImage = $template.querySelector(".blog-image");
  if ($blogImage) {
    $blogImage.src = `${getBaseApiUrl()}/uploads/${blog.image}`;
    $blogImage.alt = blog.title;
  }
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
