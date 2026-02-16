//Objeto con valores por defecto
let settings = {
  fontSize: 1,
  lineHeight: 1.5,
  wordSpace: 0,
  letterSpace: 0,
  contrast: "normal",
  saturation: null
};

//Límites para la fuente
const MIN_FONT = 0.8;
const MAX_FONT = 1.2;
const FONT_STEP = 0.1;

//Cargamos localStorage
if (localStorage.getItem("accessibility")) {
  settings = JSON.parse(localStorage.getItem("accessibility"));
  applySettings();
}

//Abrir menú accesibilidad
$("#accessibility-btn").on("click", () => {
  $("#accessibility-menu").show();
});

$("#accessibility-btn").on("keydown", (e) => {
  if(e.key === "Enter" || e.key === " "){
    $("#accessibility-menu").show();
  }
});

//Cerrar menú accesibilidad
$("img[alt=close-accessibility]").on("click", () => {
  $("#accessibility-menu").hide();
});

$("img[alt=close-accessibility]").on("keydown", (e) => {
  if(e.key === "Enter" || e.key === " "){
    $("#accessibility-menu").hide();
  }
});

//Aplicar modos de contraste
$("button[data-contrast]").on("click", function () {

  let mode = $(this).data("contrast");

  // Limpiamos todas
  $("html").removeClass(
    "contrast-gray contrast-dark contrast-light contrast-saturation-high contrast-saturation-low"
  );

  /*SATURACIÓN*/
  if (mode === "saturation") {

    //Si no hay ninguna o es baja ponemos alta (200%)
    if (!settings.saturation || settings.saturation === "low") {
      $("html").addClass("contrast-saturation-high");
      settings.saturation = "high";
      $(".status").text("Applied: high saturation");

    } else {
      $("html").addClass("contrast-saturation-low");
      settings.saturation = "low";
      $(".status").text("Applied: low saturation");
    }

    save();
    return;
  }

  /*Cualquier otro modo*/
  if (mode !== "normal") {
    $("html").addClass("contrast-" + mode);
    $(".status").text(`Applied: ${mode} mode`);
  }else{
    $(".status").text(`Applied: ${mode} mode`);
  }

  settings.contrast = mode;
  settings.saturation = null;

  save();
  applySettings();
});

//Tamaño fuente
$("#fontSize-plus").on("click", function () {
  if (settings.fontSize < MAX_FONT) {
    settings.fontSize += FONT_STEP;
    settings.fontSize = parseFloat(settings.fontSize.toFixed(2));
    $(".status").text("Font size increased");

    applySettings();
    save();
  }
});

$("#fontSize-minus").on("click", function () {
  if (settings.fontSize > MIN_FONT) {
    settings.fontSize -= FONT_STEP;
    settings.fontSize = parseFloat(settings.fontSize.toFixed(2));
    $(".status").text("Font size decreased");

    applySettings();
    save();
  }
});

//Line spacing
$("#line-spacing").on("click", function () {
 if (settings.lineHeight === 1.5) {
    settings.lineHeight = 2;
    $(".status").text("Line spacing: medium");
  } else if (settings.lineHeight === 2) {
    settings.lineHeight = 2.5;
    $(".status").text("Line spacing: big");
  } else {
    settings.lineHeight = 1.5;
    $(".status").text("Line spacing: small (default)");
  }

  applySettings();
  save();
});


//Word spacing
$("#word-spacing").on("click", function () {
  if (settings.wordSpace === 0) {
    settings.wordSpace = 0.2;
    $(".status").text("Word spacing: medium");
  } else if (settings.wordSpace === 0.2) {
    settings.wordSpace = 0.4;
    $(".status").text("Word spacing: big");
  } else {
    settings.wordSpace = 0;
    $(".status").text("Word spacing: small (default)");
  }

  applySettings();
  save();
});


//Letter spacing
$("#letter-spacing").on("click", function () {
  if (settings.letterSpace === 0) {
    settings.letterSpace = 0.05;
    $(".status").text("Letter spacing: medium");
  } else if (settings.letterSpace === 0.05) {
    settings.letterSpace = 0.1;
    $(".status").text("Letter spacing: big");
  } else {
    settings.letterSpace = 0;
    $(".status").text("Line spacing: small (default)");
  }

  applySettings();
  save();
});

//Resetear
$(".reset").on("click", function () {

  // Valores por defecto
  settings = {
    fontSize: 1,
    lineHeight: 1.5,
    wordSpace: 0,
    letterSpace: 0,
    contrast: "normal",
    saturation: null
  };

  $(".status").text("Default settings applied");

  //Borramos storage
  localStorage.removeItem("accessibility");

  //Quitamos todas las clases
  $("html").removeClass(
    "contrast-gray contrast-dark contrast-light " +
    "contrast-saturation-high contrast-saturation-low"
  );

  //Quitamos estilos
  $("html").removeAttr("style");

  applySettings();

});


//Aplicar valores
function applySettings() {
  settings.fontSize = Math.min(MAX_FONT, Math.max(MIN_FONT, settings.fontSize));

  //Aplicamos las opciones de texto solo al contenedor y no todo al html porque no interesa modificar, en este ámbito, el menú de accesibilidad
  $("#accessibility-content").css({
    "font-size": settings.fontSize + "em",
    "line-height": settings.lineHeight,
    "word-spacing": settings.wordSpace + "em",
    "letter-spacing": settings.letterSpace + "em"
  });


  $("html").removeClass("contrast-gray contrast-dark contrast-light contrast-saturation");

  if (settings.contrast !== "normal") {
    $("html").addClass("contrast-" + settings.contrast);
  }

  // Aplicar saturación guardada
  if (settings.saturation === "high") {
    $("html").addClass("contrast-saturation-high");
  }

  if (settings.saturation === "low") {
    $("html").addClass("contrast-saturation-low");
  }

  //Cambiar border de los radios cuando el fondo es oscuro
  if (settings.contrast === "dark") {
    $("input[type=radio]").css("border", "2px solid white");
    $("input[type=checkbox]").css("border", "2px solid white");
  } else {
    $("input[type=radio]").css("border", "2px solid black");
    $("input[type=checkbox]").css("border", "2px solid black");
  }
}

//Guardar en local storage
function save() {
  localStorage.setItem("accessibility", JSON.stringify(settings));
}