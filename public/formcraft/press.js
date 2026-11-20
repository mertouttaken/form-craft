const scene = document.querySelector(".press-scene");
const stage = document.querySelector(".press-window");
const step = scene.querySelector(".press-step");
const reduced = matchMedia("(prefers-reduced-motion: reduce)");
const clamp = value => Math.max(0, Math.min(1, value));
const ramp = (value, from, to) => {
    const t = clamp((value - from) / (to - from));
    return t * t * (3 - 2 * t);
};

let start = 0;
let distance = 1;
let target = 0;
let shown = 0;
let frame = 0;
let previous = 0;

function draw() {
    const p = shown;
    const contact = ramp(p, .68, .704) * (1 - ramp(p, .704, .75));
    const properties = {
        "--press-p": p,
        "--edit-slide": ramp(p, 0, .63),
        "--share-slide": ramp(p, .09, .665),
        "--answer-slide": ramp(p, .28, .96),
        "--stamp-lift": 1 - ramp(p, .535, .685) + ramp(p, .705, .82),
        "--stamp-presence": ramp(p, .53, .57) * (1 - ramp(p, .78, .85)),
        "--stamp-contact": reduced.matches ? 0 : contact,
        "--inked": ramp(p, .686, .716),
        "--link-reveal": ramp(p, .746, .86),
    };
    for (const [name, value] of Object.entries(properties)) {
        scene.style.setProperty(name, value.toFixed(4));
    }
    const text = p < .68 ? "Formu hazırla" : p < .89 ? "Bağlantıyı paylaş" : "Yanıtları topla";
    if (step.textContent !== text) step.textContent = text;
}

function advance(time) {
    const delta = Math.min(48, time - previous);
    previous = time;
    shown += (target - shown) * -Math.expm1(-delta / (reduced.matches ? 65 : 98));
    if (Math.abs(shown - target) < .0005) shown = target;
    draw();
    frame = shown === target ? 0 : requestAnimationFrame(advance);
}

function scrollPress() {
    target = clamp((window.scrollY - start) / distance);
    if (!frame && shown !== target) {
        previous = performance.now();
        frame = requestAnimationFrame(advance);
    }
}

function measure() {
    const hiddenHeight = Math.max(0, stage.offsetHeight - window.innerHeight);
    stage.style.setProperty("--press-sticky-top", -hiddenHeight + "px");
    start = scene.getBoundingClientRect().top + window.scrollY + hiddenHeight;
    distance = Math.max(1, scene.offsetHeight - stage.offsetHeight);
    scrollPress();
}

scene.classList.add("is-tracked");
window.addEventListener("scroll", scrollPress, { passive: true });
new ResizeObserver(measure).observe(stage);
window.addEventListener("resize", measure);
reduced.addEventListener("change", () => {
    draw();
});
measure();

