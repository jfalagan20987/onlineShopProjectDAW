document.addEventListener('DOMContentLoaded', () => {
  // Variables necesarias para controlar el comportamiento del aside que contiene los filtros
  const filterIcon = document.querySelector('.buscador img[alt="filter"]');
  const filtersAside = document.querySelector('.filters');

  // Pequeño control de errores
  if (!filterIcon || !filtersAside) return;

  // Creamos el overlay que aplicamos cuando se despliega en versión popup, aplicando las clases que tenemos declaradas en index.css
  const overlay = document.createElement('div');
  overlay.classList.add('filters-overlay');
  const closeBtn = document.createElement('button');
  closeBtn.classList.add('close-filters');
  closeBtn.innerHTML = 'x';

  // Insertamos el overlay como hijo del body y nos guardamos el elemento padre para restaurar
  document.body.appendChild(overlay);
  const originalParent = filtersAside.parentElement;

  // Evento para abrir el popup al hacer click en el icono de filtros
  filterIcon.addEventListener('click', () => {

    // Mover el aside dentro del overlay cuando no esté ya dentro. He tenido que buscar lo del prepend para que funcione como deseaba
    if (!overlay.contains(filtersAside)) {
      filtersAside.prepend(closeBtn);
      overlay.appendChild(filtersAside);
    }

    // Añadimos la clase active declarada en index.css para activar el overlay
    overlay.classList.add('active');

    // Desactivamos el scroll de fondo mientras el popup está desplegado
    document.body.style.overflow = 'hidden';
  });

  // Variable con una función para cerrar el popup
  const closePopup = () => {

    // Le quitamos la clase active al overlay y le devolvemos al body la posibilidad de hacer scroll, para que no quede todo el contenido bloqueado
    overlay.classList.remove('active');
    document.body.style.overflow = '';

    // Devolvemos el aside a su sitio original, para que no nos desaparezca en Desktop (he tenido que buscar lo de insertBefore)
    originalParent.insertBefore(filtersAside, originalParent.firstChild);

    // Eliminamos el botón de cierre, ya que en Desktop no se necesita
    if (filtersAside.contains(closeBtn)) closeBtn.remove();
  };

  // Evento para cerrar el popup, tanto haciendo click en la "X" como sobre el overlay que cubre el body
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay || e.target === closeBtn) closePopup();
  });
});