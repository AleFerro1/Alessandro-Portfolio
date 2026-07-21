// ========== LANGUAGE SWITCHER ==========
(function() {
    const langSwitcher = document.getElementById("langSwitcher");
    if (!langSwitcher) return;
    const langToggle = langSwitcher.querySelector(".lang-toggle");
    const langItems = langSwitcher.querySelectorAll(".lang-dropdown li");

    langToggle.addEventListener("click", (e) => {
        e.stopPropagation();
        langSwitcher.classList.toggle("open");
    });

    langItems.forEach(item => {
        item.addEventListener("click", () => {
            const langCode = item.dataset.lang;
            if (item.classList.contains("active")) {
                langSwitcher.classList.remove("open");
                return;
            }
            fetch("./lang/set_language.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ lang: langCode })
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data && data.success) {
                        window.location.reload();
                    }
                })
                .catch((err) => console.error("Impossibile cambiare lingua:", err));
            langSwitcher.classList.remove("open");
        });
    });

    document.addEventListener("click", () => {
        langSwitcher.classList.remove("open");
    });
})();