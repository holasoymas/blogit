import { renderUserProfile } from "../renderer/renderUser.js";
import { setProfilePicture } from "../util/genprofilepic.js";
import { renderBlogs } from "../renderer/renderBlog.js";
import { fetchFromServer } from "../util/fetcher.js";
import { getUserById } from "./user.js";

export async function fetchProfile() {
    try {
        const params = new URLSearchParams(window.location.search);
        const uid = params.get("uid");

        const json = await fetchFromServer(
            `profileRoute.php?uid=${encodeURIComponent(uid)}`,
            "GET",
        );

        const { loggedInUser, user, blogs } = json;
        const $navProfilePic = document.querySelector(".nav-profile-pic");
        const $navLoginLink = document.querySelector(".nav-login");

        if (loggedInUser) {
            const loggedUserData = await getUserById(loggedInUser);
            console.log(loggedUserData);
            if (!loggedUserData) {
                $navProfilePic.classList.add("hidden");
            } else {
                $navProfilePic.classList.remove("hidden");
                const { fname, lname, profile_pic } = loggedUserData;
                setProfilePicture($navProfilePic, fname, lname, profile_pic);
            }
        } else {
            $navLoginLink.classList.remove("hidden");
            $navProfilePic.classList.add("hidden");
        }
        renderUserProfile(".profile-section", user);
        renderBlogs(".blog-section", blogs);
    } catch (err) {
        console.log(err);
    }
}
