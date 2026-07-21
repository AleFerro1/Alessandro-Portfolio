// ========== COSTELLAZIONE ==========
//window.skillsData = [];
window.hoveredNodeId = null;
window.nodes = [];
window.constellationInitialized = false;
let staticCanvas = null, staticCtx = null;
let mainCanvas, mainCtx, labelsContainer;

window.initConstellation = function() {
    if (window.constellationInitialized) return;
    if (!window.skillsData || !Array.isArray(window.skillsData) || window.skillsData.length === 0) {
        console.warn('Costellazione: dati non ancora disponibili, riprovo tra 100ms');
        setTimeout(window.initConstellation, 100);
        return;
    }
    window.constellationInitialized = true;

    const container = document.getElementById('constellationContainer');
    if (!container) return;
    mainCanvas = document.getElementById('constellationCanvas');
    mainCtx = mainCanvas.getContext('2d');
    labelsContainer = document.getElementById('labelsContainer');

    const connections = [
        [0,1], [0,9], [0,10], [1,2], [1,3], [1,9], [2,3], [2,9],
        [3,4], [3,7], [3,8], [4,5], [4,8], [5,6], [5,7], [5,11],
        [6,7], [6,11], [7,8], [7,11], [10,11], [5,10],
        [12, 0], [12, 1], [12, 2], [12, 3],
        [13, 4], [13, 5], [13, 7], [13, 8]
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
        const h = container.offsetHeight;
        const allLabels = labelsContainer.querySelectorAll('.skill-label');
        const labelOffsets = [];
        
        // Margine orizzontale adattivo: almeno 15px, ma su mobile può essere ridotto
        const horizontalMargin = w < 500 ? 8 : 30;
        
        // Ordina i nodi per posizione y (come prima) ma su schermi piccoli 
        // può essere utile dare priorità alla leggibilità spostando di più verticalmente
        const sortedNodes = window.nodes.slice().sort((a,b) => a.py - b.py);
        
        sortedNodes.forEach(node => {
            const label = Array.from(allLabels).find(l => parseInt(l.dataset.id) === node.id);
            if (!label) return;
            
            const labelWidth = label.offsetWidth || 80;
            const labelHeight = label.offsetHeight || 22;
            const halfWidth = labelWidth / 2;
            const halfHeight = labelHeight / 2;
            
            let left, top;
            
            // Posiziona a destra o sinistra del nodo a seconda della metà schermo
            if (node.x < 0.5) {
                left = node.px + horizontalMargin;
            } else {
                left = node.px - horizontalMargin - labelWidth;
            }
            
            // Mantieni entro i limiti orizzontali
            left = Math.max(5, Math.min(left, w - labelWidth - 5));
            
            // Allineamento verticale centrato sul nodo
            top = node.py - halfHeight;
            
            // Evita sovrapposizioni verticali: passo maggiore su mobile
            const verticalStep = labelHeight + (w < 500 ? 12 : 6);
            let overlap = true;
            let attempts = 0;
            const maxAttempts = 15;
            
            while (overlap && attempts < maxAttempts) {
                overlap = false;
                for (const off of labelOffsets) {
                    // Verifica sovrapposizione orizzontale + verticale
                    if (Math.abs(left + halfWidth - off.left - off.halfWidth) < (labelWidth + off.labelWidth) / 2 &&
                        Math.abs(top - off.top) < (labelHeight + off.labelHeight) / 2) {
                        overlap = true;
                        top += verticalStep;
                        break;
                    }
                }
                attempts++;
            }
            
            // Se esce dal bordo inferiore, riporta in alto con un piccolo margine
            if (top + labelHeight > h - 5) {
                top = h - labelHeight - 5;
            }
            // Non può andare sopra il bordo superiore
            top = Math.max(5, top);
            
            label.style.left = (left + halfWidth) + 'px';
            label.style.top = top + 'px';
            
            labelOffsets.push({ 
                left, 
                top, 
                halfWidth, 
                halfHeight,
                labelWidth, 
                labelHeight 
            });
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