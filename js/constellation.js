// ========== COSTELLAZIONE ==========
window.skillsData = [];
window.hoveredNodeId = null;
window.nodes = [];
window.constellationInitialized = false;
let staticCanvas = null, staticCtx = null;
let mainCanvas, mainCtx, labelsContainer;

window.initConstellation = function() {
    if (window.constellationInitialized) return;
    window.constellationInitialized = true;

    const container = document.getElementById('constellationContainer');
    if (!container) return;
    mainCanvas = document.getElementById('constellationCanvas');
    mainCtx = mainCanvas.getContext('2d');
    labelsContainer = document.getElementById('labelsContainer');

    // skillsData viene popolata da PHP inline, ma ora conviene passarla via JSON in uno script a parte
    // es. <script>window.skillsData = <?= json_encode($jsonSkills) ?>;</script>
    const connections = [
        [0,1], [0,9], [0,10], [1,2], [1,3], [1,9], [2,3], [2,9],
        [3,4], [3,7], [3,8], [4,5], [4,8], [5,6], [5,7], [5,11],
        [6,7], [6,11], [7,8], [7,11], [10,11], [5,10]
    ];

    labelsContainer.innerHTML = '';
    window.skillsData.forEach(skill => {
        const label = document.createElement('div');
        label.className = 'skill-label';
        label.dataset.id = skill.id;
        label.innerHTML = `<span class="skill-name">${skill.name}</span>`;
        label.addEventListener('click', () => window.openSkillCard(skill.id));
        labelsContainer.appendChild(label);
    });

    staticCanvas = document.createElement('canvas');
    staticCtx = staticCanvas.getContext('2d');

    function drawStaticLayer() {
        const w = container.offsetWidth, h = container.offsetHeight;
        staticCanvas.width = w; staticCanvas.height = h;
        staticCtx.clearRect(0, 0, w, h);
        window.nodes = window.skillsData.map(s => ({...s, px: s.x * w, py: s.y * h}));

        connections.forEach(([fromIdx, toIdx]) => {
            const from = window.nodes[fromIdx], to = window.nodes[toIdx];
            staticCtx.beginPath(); staticCtx.moveTo(from.px, from.py); staticCtx.lineTo(to.px, to.py);
            staticCtx.strokeStyle = 'rgba(255,255,255,0.20)'; staticCtx.lineWidth = 1.8;
            staticCtx.shadowColor = 'rgba(228,230,234,0.2)'; staticCtx.shadowBlur = 10; staticCtx.stroke();
            staticCtx.shadowBlur = 0;
        });

        window.nodes.forEach(node => {
            staticCtx.beginPath(); staticCtx.arc(node.px, node.py, 10, 0, Math.PI*2);
            staticCtx.fillStyle = 'rgba(255,255,255,0.1)'; staticCtx.shadowColor = '#fff'; staticCtx.shadowBlur = 25; staticCtx.fill();
            staticCtx.beginPath(); staticCtx.arc(node.px, node.py, 4, 0, Math.PI*2);
            staticCtx.fillStyle = '#fff'; staticCtx.shadowBlur = 25; staticCtx.fill(); staticCtx.shadowBlur = 0;
        });
    }

    function positionLabels() {
        const w = container.offsetWidth;
        const allLabels = labelsContainer.querySelectorAll('.skill-label');
        const labelOffsets = [];
        const sortedNodes = window.nodes.slice().sort((a,b) => a.py - b.py);
        sortedNodes.forEach(node => {
            const label = Array.from(allLabels).find(l => parseInt(l.dataset.id) === node.id);
            if (!label) return;
            const labelWidth = label.offsetWidth || 80, labelHeight = label.offsetHeight || 20;
            const halfWidth = labelWidth/2, halfHeight = labelHeight/2;
            let left, top; const margin = 30;
            if (node.x < 0.5) left = node.px + margin;
            else left = node.px - margin - labelWidth;
            if (left < 5) left = 5;
            if (left + labelWidth > w - 5) left = w - 5 - labelWidth;
            top = node.py - halfHeight;
            let overlap = true, attempts = 0;
            const verticalStep = labelHeight + 4;
            while (overlap && attempts < 10) {
                overlap = false;
                for (const off of labelOffsets) {
                    if (Math.abs(left - off.left) < labelWidth && Math.abs(top - off.top) < labelHeight) {
                        overlap = true; top += verticalStep; break;
                    }
                }
                attempts++;
            }
            if (top < 5) top = 5;
            if (top + labelHeight > container.offsetHeight - 5) top = container.offsetHeight - 5 - labelHeight;
            label.style.left = (left + halfWidth) + 'px';
            label.style.top = top + 'px';
            labelOffsets.push({ left, top, id: node.id });
        });
    }

    window.drawConstellation = function(hoverId = null) {
        const w = container.offsetWidth, h = container.offsetHeight;
        mainCanvas.width = w; mainCanvas.height = h;
        mainCtx.clearRect(0,0,w,h); mainCtx.drawImage(staticCanvas,0,0);
        if (hoverId !== null) {
            const node = window.nodes.find(n => n.id === hoverId);
            if (node) {
                mainCtx.beginPath(); mainCtx.arc(node.px, node.py, 18, 0, Math.PI*2);
                mainCtx.fillStyle = 'rgba(255,255,255,0.3)'; mainCtx.shadowColor = '#fff'; mainCtx.shadowBlur = 50; mainCtx.fill();
                mainCtx.beginPath(); mainCtx.arc(node.px, node.py, 8, 0, Math.PI*2);
                mainCtx.fillStyle = '#fff'; mainCtx.shadowBlur = 25; mainCtx.fill(); mainCtx.shadowBlur = 0;
            }
        }
        positionLabels();
    };

    drawStaticLayer();
    window.drawConstellation(null);

    let hoverRAF = null;
    mainCanvas.addEventListener('mousemove', (e) => {
        if (hoverRAF) return;
        hoverRAF = requestAnimationFrame(() => {
            hoverRAF = null;
            const rect = mainCanvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left, mouseY = e.clientY - rect.top;
            let found = false;
            for (let node of window.nodes) {
                if (Math.hypot(mouseX - node.px, mouseY - node.py) < 25) {
                    if (window.hoveredNodeId !== node.id) {
                        window.hoveredNodeId = node.id;
                        window.drawConstellation(window.hoveredNodeId);
                        mainCanvas.style.cursor = 'pointer';
                    }
                    found = true; break;
                }
            }
            if (!found && window.hoveredNodeId !== null) {
                window.hoveredNodeId = null;
                window.drawConstellation(null);
                mainCanvas.style.cursor = 'default';
            }
        });
    });

    mainCanvas.addEventListener('click', (e) => {
        const rect = mainCanvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left, mouseY = e.clientY - rect.top;
        for (let node of window.nodes) {
            if (Math.hypot(mouseX - node.px, mouseY - node.py) < 25) {
                window.openSkillCard(node.id); break;
            }
        }
    });

    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => { drawStaticLayer(); window.drawConstellation(window.hoveredNodeId); }, 150);
    });
};