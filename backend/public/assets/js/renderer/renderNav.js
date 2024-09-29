import { getUserById } from "../api/user.js";
import { getBaseDomainUrl } from "../config.js";
import { setProfilePicture } from "../util/genprofilepic.js";

export async function renderNav(loggedInUser) {
    const $navProfilePic = document.querySelector(".nav-profile-pic");
    const $navLoginLink = document.querySelector(".nav-login");

    try {
        if (!loggedInUser) {
            $navLoginLink.classList.remove("hidden");
            $navProfilePic.classList.add("hidden");
            return;
        }
        const loggedUserData = await getUserById(loggedInUser);
        if (!loggedUserData) throw new Error("User data not found");

        const { id, fname, lname, profile_pic } = loggedUserData;
        setProfilePicture($navProfilePic, fname, lname, profile_pic);
        document
            .querySelector(".dropdown-menu li a")
            .setAttribute("href", `${getBaseDomainUrl()}/profile.html?uid=${id}`);
        $navProfilePic.classList.remove("hidden");
    } catch (error) {
        console.error(error);
        $navProfilePic.classList.add("hidden");
    }
}
