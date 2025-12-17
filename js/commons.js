/* const BASE_URL = window.location.hostname === "127.0.0.1" ? "" : "/onlineShopProjectDAW"; */

let BASE_URL;

if (window.location.hostname === "127.0.0.1") {
    // Live Server
    BASE_URL = "";
} else if (window.location.hostname === "localhost") {
    // WAMP local
    BASE_URL = "/student012/shop";
} else if (window.location.hostname === "remotehost.es") {
    // WAMP remoto
    BASE_URL = "/student012/shop";
} else {
    // GitHub Pages u otro servidor estático
    BASE_URL = "/onlineShopProjectDAW";
}

// -------------------------------
// BACKEND API URL (PHP)
// -------------------------------
let API_URL;

// 1️⃣ Live Server → usar backend en WAMP local
if (window.location.port === "5500") {
    API_URL = "http://localhost/student012/shop/backend";
}

// 2️⃣ WAMP local en localhost
else if (window.location.hostname === "localhost") {
    API_URL = "/student012/shop/backend";
}

// 3️⃣ WAMP remoto
else if (window.location.hostname === "remotehost.es") {
    API_URL = "/student012/shop/backend";
}

// 4️⃣ GitHub Pages → No hay PHP
else {
    API_URL = null;
    console.warn("⚠ El backend PHP no está disponible en este entorno.");
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

  shoppingCart.addEventListener('click', () => {
    window.location.href="/student012/shop/backend/db/my_shopping_cart.php";
  })

});