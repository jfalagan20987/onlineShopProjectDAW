/* const BASE_URL = window.location.hostname === "127.0.0.1" ? "" : "/onlineShopProjectDAW"; */

//Variables relacionadas con el URL y cómo van a cambiar para que todo funcione en Live Server, Github Pages, Localhost y remotehost.es
let BASE_URL;

if (window.location.hostname === "127.0.0.1") {
    //Live Server
    BASE_URL = "";
} else if (window.location.hostname === "localhost") {
    //Localhost
    BASE_URL = "/student012/shop";
} else if (window.location.hostname === "remotehost.es") {
    //remotehost.es
    BASE_URL = "/student012/shop";
} else {
    //GitHub Pages
    BASE_URL = "/onlineShopProjectDAW";
}

//BACKEND API URL (PHP)
let API_URL;

//Live Server
if (window.location.port === "5500") {
    API_URL = "http://localhost/student012/shop/backend";
}
//Localhost
else if (window.location.hostname === "localhost") {
    API_URL = "/student012/shop/backend";
}
//remotehost.es
else if (window.location.hostname === "remotehost.es") {
    API_URL = "/student012/shop/backend";
}
//Github Pages -- Backend PHP no está disponible
else {
    API_URL = null;
}

//URL para extraer ciertos assets y no encontrar problemas con rutas absolutas como la que genera la columna "image_path" de la tabla 012_products
let ASSETS_URL;

if (window.location.hostname === "127.0.0.1") {
    ASSETS_URL = "http://localhost";
}
else if (window.location.hostname === "localhost") {
    ASSETS_URL = "";
}
else if (window.location.hostname === "remotehost.es") {
    ASSETS_URL = "";
}
else {
    //GitHub Pages
    ASSETS_URL = "https://remotehost.es";
}

document.addEventListener("DOMContentLoaded", () => {

  // Variables necesarias para controles de menús y desplazamiento básico
  const btnMenu = document.querySelector("#btn-menu");
  const navHeader = document.querySelector("#nav-header");
  const btnClose = document.querySelector("#btn-close img");
  const submenu = document.querySelector(".submenu");
  const dropdowns = document.querySelectorAll(".dropdown");
  const arrowups = document.querySelectorAll(".arrowup");
  const footer = document.querySelector("footer");
  const logos = document.querySelectorAll('.logo');
  const products = document.querySelectorAll('.product');
  const shoppingCart = document.querySelector('img[alt="shopping-cart"]');

  // Control de la versión de dropdown y arrowup que he necesitado copiar y pegar porque no era capaz de hacerlo
  // EXPLICACIÓN DE ERROR PENDIENTE DE SOLUCIONAR
  // Tiene un pequeño error que no consigo solucionar: al abrir el submenú en Tablet o Mobile, cuando amplío para pasar a Desktop, el dropdown aparece inicialmente en white en Desktop
  // Una vez se hace click en Desktop, vuelve a aparecer en versión onyx, que es como debería aparecer
  // También aparece correctamente si se abre la página directamente en Desktop
  const currentVariant = () =>
    window.matchMedia("(min-width: 1025px)").matches ? "onyx" : "white";

  const toggleSubmenu = (show) => {
    const variant = currentVariant();
    submenu.classList.toggle("submenu-visible", show);

    dropdowns.forEach(d => {
      d.style.display =
        d.dataset.variant === variant && !show ? "initial" : "none";
    });

    arrowups.forEach(a => {
      a.style.display =
        a.dataset.variant === variant && show ? "initial" : "none";
    });
  };

  const resetSubmenu = () => toggleSubmenu(false);


  // Control del nav del header
  btnMenu.addEventListener("click", () => {
    navHeader.classList.add("nav-visible");
    document.body.classList.add("no-scroll");
    footer.classList.add("footer-fixed");
    resetSubmenu();
  });

  btnClose.addEventListener("click", () => {
    navHeader.classList.remove("nav-visible");
    document.body.classList.remove("no-scroll");
    footer.classList.remove("footer-fixed");
    resetSubmenu();
  });


  // Eventos para las img dropdowns y arrowups, ya que al tener más de una con la misma clase, deben tratarse como arrays
  dropdowns.forEach(drop => drop.addEventListener("click", () => toggleSubmenu(true)));
  arrowups.forEach(arrow => arrow.addEventListener("click", () => toggleSubmenu(false)));

  // Evento para hacer click en el logo y volver a inicio
  logos.forEach(logo => {
    logo.addEventListener('click', ()=> location.href = `${BASE_URL}/index.html`);
  });

  products.forEach((product) => {
    product.addEventListener('click', (e) => {
      if (
        !e.target.classList.contains('buy-now') &&
        !e.target.classList.contains('add-to-cart') &&
        !e.target.classList.contains('wishlist')
      ) {
        const productId = product.dataset.id;
        location.href = `${BASE_URL}/views/product_detail.html?id=${productId}`;
      }
    });
  });


  //Acceso a shopping_cart.html
  shoppingCart.addEventListener('click', () => {
    window.location.href="/student012/shop/backend/db/my_shopping_cart.php";
  })

  //Función extendida a otros JS para los mensajes en forma de popup -- Establecemos una duración predeterminada de 3 segundos
  window.showMessage = function(content, duration = 3000) {
    const container = document.getElementById("message");
    if (!container) return;

    const message = document.createElement("div");
    message.className = "message-popup";
    message.textContent = content;

    container.appendChild(message);

    //Animación de entrada -- Ni idea de que existía esto en JavaScript
    requestAnimationFrame(() => {
      message.classList.add("show");
    });

    //timeout para que desaparezca
    setTimeout(() => {
      message.classList.remove("show");
      message.addEventListener("transitionend", () => message.remove());
    }, duration);
  }
});