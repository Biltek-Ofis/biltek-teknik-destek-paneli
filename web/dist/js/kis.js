function karYagdir(karRengi = "#FFF", karSayisi = 100) {
    if (document.getElementById("biltek--kis-anim")) return;

    const cont = document.createElement("div");
    cont.id = "biltek--kis-anim";
    cont.style.cssText = `
        position:fixed;
        left:0;top:0;
        width:100vw;height:100vh;
        pointer-events:none;
        overflow:hidden;
        z-index:9999999;
    `;

    // Tek keyframe → ultra performanslı
    const style = document.createElement("style");
    style.textContent = `
    @keyframes snowFall {
        0% {
            transform: translateY(-10vh) translateX(0);
            opacity: 1;
        }
        100% {
            transform: translateY(110vh) translateX(20px);
            opacity: 0.3;
        }
    }
    .snow-flake {
        position:absolute;
        color:${karRengi};
        font-size:12px;
        will-change: transform, opacity;
        animation: snowFall linear infinite;
    }
    `;
    document.head.appendChild(style);

    const chars = ["❅","❆","❄"];

    for (let i = 0; i < karSayisi; i++) {
        const f = document.createElement("div");
        f.className = "snow-flake";
		f.style.fontFamily = "Arial, sans-serif";
		f.style.textShadow = "none";
        f.textContent = chars[Math.floor(Math.random()*chars.length)];

        const x = Math.random() * 100;  // vw
        const delay = -(Math.random() * 10);
        const duration = 8 + Math.random() * 10;
        const size = 10 + Math.random() * 12;

        f.style.left = x + "vw";
        f.style.fontSize = size + "px";
        f.style.animationDuration = duration + "s";
        f.style.animationDelay = delay + "s";

        cont.appendChild(f);
    }

    document.body.appendChild(cont);
}
function karDurdur() {
    const karContainer = document.getElementById("biltek--kis-anim");
    if (karContainer) {
        karContainer.remove(); // DOM’dan kaldır
    }

    // Ek olarak eklenen style tag’ı varsa temizle
    const styles = document.querySelectorAll('style');
    styles.forEach(s => {
        if (s.textContent.includes('@keyframes snowFall')) {
            s.remove();
        }
    });
}
