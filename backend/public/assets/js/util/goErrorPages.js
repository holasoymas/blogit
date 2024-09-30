import { getBaseDomainUrl } from "../config.js";

export function goNotFoundBlog() {
    window.location.href = `${getBaseDomainUrl()}/404blog.html`;
}

export function goNotFoundUser() {
    window.location.href = `${getBaseDomainUrl()}/404profile.html`;
}
