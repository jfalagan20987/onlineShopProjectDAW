const BASE_URL = window.location.hostname === "127.0.0.1" ? "" : "/onlineShopProjectDAW";
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
  const products = document.querySelectorAll('#product');

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
    logo.addEventListener('click', ()=> location.href = `..${BASE_URL}/index.html`);
  });

  products.forEach((product) => {
    product.addEventListener('click', (e) => {
      if(e.target != document.querySelector('.buy-now') && e.target != document.querySelector('.add-to-cart') && e.target != document.querySelector('.wishlist')){
        location.href = `..${BASE_URL}/views/product_detail.html`;
      }
    });
  });
});