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
  $template.querySelector(".blog-content").innerText = blog.content;

  return $template;
}
