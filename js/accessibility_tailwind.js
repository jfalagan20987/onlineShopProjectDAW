// ==============================
// ACCESSIBILITY - PRODUCT DETAIL
// ==============================

// Contenedor objetivo para aplicar accesibilidad
const $content = $("#accessibility-content");
const target = $content.length ? $content : $("body");

// Valores por defecto
let settings = {
  fontSize: 1,
  lineHeight: 1.5,
  wordSpace: 0,
  letterSpace: 0,
  contrast: "normal"
};

// Límites de la fuente
const MIN_FONT = 0.9;
const MAX_FONT = 1.2;
const FONT_STEP = 0.1;

// Cargar settings desde localStorage
if (localStorage.getItem("accessibility")) {
  settings = JSON.parse(localStorage.getItem("accessibility"));
  applySettings();
}

// --------- MENU ACCESIBILIDAD ---------

// Abrir menú
$("#accessibility-btn").on("click", () => {
  $("#accessibility-menu").removeClass("hidden").addClass("flex");
});

// Cerrar menú
$("img[alt=close-accessibility]").on("click", () => {
  $("#accessibility-menu").removeClass("flex").addClass("hidden");
});

// Cerrar menú con teclado (Enter / Space)
$("img[alt=close-accessibility]").on("keydown", (e) => {
  if(e.key === "Enter" || e.key === " ") {
    $("#accessibility-menu").removeClass("flex").addClass("hidden");
  }
});

// --------- MODOS DE CONTRASTE ---------
$("button[data-contrast]").on("click", function () {
  const mode = $(this).data("contrast");

  // Limpiar clases dinámicas de Tailwind
  target.removeClass(
    "bg-white text-black bg-black text-white filter grayscale-100"
  );

  // Aplicar modo seleccionado
  if (mode === "gray") {
    target.addClass("filter grayscale-100");
  } else if (mode === "dark") {
    target.addClass("bg-black text-white");
  } else if (mode === "light") {
    target.addClass("bg-white text-black");
  } else if (mode === "normal") {
    // Normal → no añadimos nada, mantiene Tailwind base
  }

  settings.contrast = mode;
  save();
});

// --------- TAMAÑO DE FUENTE ---------
$("#fontSize-plus").on("click", function () {
  if (settings.fontSize < MAX_FONT) {
    settings.fontSize += FONT_STEP;
    settings.fontSize = parseFloat(settings.fontSize.toFixed(2));
    applySettings();
    save();
  }
});

$("#fontSize-minus").on("click", function () {
  if (settings.fontSize > MIN_FONT) {
    settings.fontSize -= FONT_STEP;
    settings.fontSize = parseFloat(settings.fontSize.toFixed(2));
    applySettings();
    save();
  }
});

// --------- RESET / RESTAURAR VALORES ---------
$(".reset").on("click", function () {
  settings = {
    fontSize: 1,
    lineHeight: 1.5,
    wordSpace: 0,
    letterSpace: 0,
    contrast: "normal"
  };

  localStorage.removeItem("accessibility");

  // Solo eliminar estilos inline y clases de contraste dinámicas
  target.css({
    "font-size": "",
    "line-height": "",
    "word-spacing": "",
    "letter-spacing": ""
  });

  target.removeClass("filter grayscale-100 bg-black text-white bg-white text-black");

  applySettings();
});

// --------- FUNCIONES ---------
function applySettings() {
  // Limitar fontSize
  settings.fontSize = Math.min(MAX_FONT, Math.max(MIN_FONT, settings.fontSize));

  // Aplicar estilos inline (font-size, line-height, spacing)
  target.css({
    "font-size": settings.fontSize + "em",
    "line-height": settings.lineHeight,
    "word-spacing": settings.wordSpace + "em",
    "letter-spacing": settings.letterSpace + "em"
  });

  // Limpiar clases de contraste
  target.removeClass("filter grayscale-100 bg-black text-white bg-white text-black");

  // Aplicar contraste actual
  if (settings.contrast === "gray") target.addClass("filter grayscale-100");
  else if (settings.contrast === "dark") target.addClass("bg-black text-white");
  else if (settings.contrast === "light") target.addClass("bg-white text-black");
  // Normal → mantiene colores base
}

// Guardar settings en localStorage
function save() {
  localStorage.setItem("accessibility", JSON.stringify(settings));
}