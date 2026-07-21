// ========== SKILL CARD ==========
(function() {
    const overlay = document.getElementById('skillOverlay');
    const card = document.getElementById('skillCard');
    const cardTitle = document.getElementById('skillCardTitle');
    const cardDesc = document.getElementById('skillCardDesc');
    const closeBtn = document.getElementById('closeSkillCard');

    window.openSkillCard = function(id) {
        const skill = window.skillsData.find(s => s.id === id);
        if (!skill) return;
        cardTitle.textContent = skill.name;
        cardDesc.textContent = skill.desc;
        overlay.classList.add('active');
        card.classList.add('active');
    };

    closeBtn.addEventListener('click', () => {
        overlay.classList.remove('active');
        card.classList.remove('active');
    });
    overlay.addEventListener('click', () => {
        overlay.classList.remove('active');
        card.classList.remove('active');
    });
})();