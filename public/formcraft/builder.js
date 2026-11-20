const limit = 10;
const types = { text: "Kısa metin", textarea: "Uzun metin", email: "E-posta", number: "Sayı", select: "Açılır liste", radio: "Tek seçim", checkbox: "Çoklu seçim", date: "Tarih" };
const choiceTypes = ["select", "radio", "checkbox"];
const palette = document.querySelector("#builder-types");
const list = document.querySelector("#builder-list");
const preview = document.querySelector("#preview-fields");
const template = document.querySelector("#editor-field");
const note = document.querySelector("#builder-note");
const fields = [
    { id: 1, type: "text", label: "Ad soyad", placeholder: "Deniz Yılmaz", options: "", required: true },
    { id: 2, type: "email", label: "E-posta", placeholder: "deniz@ornek.com", options: "", required: true },
    { id: 3, type: "radio", label: "Hangi oturuma katılacaksın?", placeholder: "", options: "Sabah\nÖğleden sonra\nİkisi de", required: true },
];
let nextId = fields.length;

function renderPreview() {
    const elements = fields.map(field => {
        const isChoiceGroup = field.type === "radio" || field.type === "checkbox";
        const id = "preview-" + field.id;
        const row = document.createElement(isChoiceGroup ? "fieldset" : "div");
        row.className = "preview-field";
        const label = document.createElement(isChoiceGroup ? "legend" : "label");
        label.textContent = (field.label.trim() || "Adsız alan") + (field.required ? " *" : "");
        row.append(label);
        const options = field.options.split("\n").map(line => line.trim()).filter(Boolean);
        if (isChoiceGroup) {
            options.forEach(option => {
                const choice = document.createElement("label");
                choice.className = "check";
                const input = document.createElement("input");
                input.type = field.type;
                input.name = id;
                choice.append(input, option);
                row.append(choice);
            });
            return row;
        }
        const tag = field.type === "select" ? "select" : field.type === "textarea" ? "textarea" : "input";
        const input = document.createElement(tag);
        input.id = id;
        label.htmlFor = id;
        input.className = tag === "input" ? "input" : tag;
        if (tag === "input") input.type = field.type;
        if (tag === "select") input.add(new Option("Bir seçenek seç", ""));
        if (tag === "select") options.forEach(option => input.add(new Option(option)));
        if (tag !== "select") input.placeholder = field.placeholder;
        row.append(input);
        return row;
    });
    preview.replaceChildren(...elements);
}

function renderEditor() {
    const items = fields.map((field, index) => {
        const item = template.content.firstElementChild.cloneNode(true);
        item.dataset.id = field.id;
        item.querySelector(".editor-number").textContent = String(index + 1).padStart(2, "0");
        item.querySelector(".editor-type").textContent = types[field.type];
        item.querySelector("[data-options]").hidden = !choiceTypes.includes(field.type);
        item.querySelector("[data-placeholder]").hidden = choiceTypes.includes(field.type) || field.type === "date";
        item.querySelector('[data-move="-1"]').disabled = index === 0;
        item.querySelector('[data-move="1"]').disabled = index === fields.length - 1;
        for (const control of item.querySelectorAll("[data-setting]")) {
            if (control.type === "checkbox") control.checked = field.required;
            else control.value = field[control.dataset.setting];
        }
        return item;
    });
    list.replaceChildren(...items);
    document.querySelector(".builder-empty").hidden = fields.length !== 0;
    document.querySelector("#builder-count").textContent = fields.length + " / " + limit + " alan";
    document.querySelector("#builder-limit").hidden = fields.length < limit;
    palette.querySelectorAll("button").forEach(button => {
        button.disabled = fields.length >= limit;
    });
    renderPreview();
}

function focusField(id) {
    list.querySelector('[data-id="' + id + '"] [data-setting="label"]')?.focus();
}

palette.addEventListener("click", event => {
    const button = event.target.closest("button[data-type]");
    if (!button || fields.length >= limit) return;
    const type = button.dataset.type;
    const field = {
        id: ++nextId,
        type,
        label: types[type],
        placeholder: "",
        options: choiceTypes.includes(type) ? "Seçenek 1\nSeçenek 2" : "",
        required: false,
    };
    fields.push(field);
    renderEditor();
    note.textContent = types[type] + " alanı eklendi.";
    focusField(field.id);
});

list.addEventListener("input", event => {
    const control = event.target;
    if (!control.dataset.setting) return;
    const field = fields.find(item => item.id === Number(control.closest("[data-id]").dataset.id));
    field[control.dataset.setting] = control.type === "checkbox" ? control.checked : control.value;
    renderPreview();
});

list.addEventListener("click", event => {
    const button = event.target.closest("button");
    if (!button) return;
    const id = Number(button.closest("[data-id]").dataset.id);
    const index = fields.findIndex(field => field.id === id);
    if (button.hasAttribute("data-remove")) {
        if (!window.confirm("Bu alanı örnek formdan kaldırmak istiyor musun?")) return;
        fields.splice(index, 1);
        renderEditor();
        note.textContent = "Alan kaldırıldı.";
        if (fields.length) focusField(fields[Math.min(index, fields.length - 1)].id);
        else palette.querySelector("button").focus();
        return;
    }
    const next = index + Number(button.dataset.move);
    if (next < 0 || next >= fields.length) return;
    [fields[index], fields[next]] = [fields[next], fields[index]];
    renderEditor();
    note.textContent = "Alan " + (next + 1) + ". sıraya taşındı.";
    focusField(id);
});

renderEditor();

