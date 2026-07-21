// ========== AVATAR FALLBACK ==========
(function() {
    const avatarImg = document.getElementById("avatarImg");
    const avatarFallback = document.getElementById("avatarFallback");
    if (!avatarImg) return;
    const showFallback = () => {
        avatarImg.style.display = "none";
        if (avatarFallback) avatarFallback.style.display = "flex";
    };
    if (!avatarImg.getAttribute("src")) {
        showFallback();
    } else {
        avatarImg.addEventListener("error", showFallback);
    }
})();