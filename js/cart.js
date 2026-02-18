//comunicación con la base de datos, que nos devolverá el estado del carrito correspondiente al cliente que generamos con las cookies
document.addEventListener("DOMContentLoaded", async () => {
  if (!API_URL) return;

  const res = await fetch(`${API_URL}/cart/get_cart.php`);
  const cart = await res.json();

  const list = document.querySelector(".product-list");
  if (!list) return;
  list.innerHTML = "";

  let subtotal = 0;

  cart.forEach(item => {
  subtotal += item.unit_price * item.quantity;

  //Regeneramos el contenido del html, que tenía un contenido estático utilizado para maquetar
  //Aunque el carrito se muestre vacío, no volverá a mostrar ese contenido estático aunque no lo eliminemos
  const div = document.createElement("div");
  div.classList.add("product-cart");

  div.dataset.price = item.unit_price;
  div.dataset.id = item.product_id;
  div.dataset.color = item.selected_color || '';
  div.dataset.size = item.size || '';

  //Tratamos el array de colores (columna tipo SET)
  const colors = item.color ? item.color.split(',') : [];
  console.log(item);

  /*Generamos un input para cada color. Importante utilizar el nombre del color en su id y su clase, 
  ya que esto nos sirve para manipular su estilo a conveniencia en CSS*/
  const colorInputs = colors.map(c => `
    <input type="radio" 
          name="color-${item.product_id}" 
          id="color-${c}-${item.product_id}" 
          value="${c}"
          aria-label="${c}"
          class="color-radio ${c}" 
          ${item.selected_color === c ? 'checked' : ''}>
    <label for="color-${c}-${item.product_id}" aria-label="${c}"></label>
  `).join('');

  /*Generamos para cada producto una estructura idéntica a la que utilizamos cuando el html era estático*/
  div.innerHTML = `
    <div>
      <img src="${item.image_path}" alt="product">
      <div>
        <h2>${item.product_name}</h2>
        <div>
          <div class="price">
            <p></p>
            <h2>${item.unit_price}€</h2>
          </div>
          <div>
            <img src="../assets/icons/wishlist.svg" alt="wishlist">
            <img src="../assets/icons/bin.svg" class="remove" data-id="${item.product_id}" alt="bin" role="button" tabindex="0">
          </div>
        </div>
      </div>
    </div>
    <div class="filters">
      <div>
        <label>Color:
          ${colorInputs}
        </label>
      </div>
      <div>
        <label for="quantity">
          <select name="quantity" id="quantity-${item.product_id}" class="cart-qty" data-id="${item.product_id}">
            ${[...Array(10).keys()].map(i => `<option value="${i+1}" ${item.quantity === i+1 ? 'selected' : ''}>Quantity: ${i+1}</option>`).join('')}
          </select>
        </label>
        <label for="size">
          <select name="size" id="size-${item.product_id}" class="cart-size" data-id="${item.product_id}">
            ${[40,41,42,43,44,45,46,47].map(sz => `<option value="${sz}" ${item.size == sz ? 'selected' : ''}>Size: ${sz}</option>`).join('')}
          </select>
        </label>
      </div>
    </div>
  `;

  list.appendChild(div);
  applySettings();
});

  //Subtotal
  document.querySelector(".subtotal span").textContent = subtotal.toFixed(2) + "€";

  //Contenido descartado para eliminar producto -- No lo borro para mantenerlo
  /* document.querySelectorAll(".remove").forEach(btn => {
    btn.addEventListener("click", async (e) => {
      const productId = e.target.dataset.id;
      await fetch(`${API_URL}/cart/remove_from_cart.php?product_id=${productId}`);
      location.reload();
    });
  }); */

  //Cambios dentro del carrito: actualizar subtotal, cantidades, colores, tallas, eliminar.
  function recalculateSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.product-cart').forEach(item => {
      const price = parseFloat(item.dataset.price);
      const qty = parseInt(item.querySelector('.cart-qty').value);
      subtotal += price * qty;
    });
    document.querySelector(".subtotal span").textContent =
    subtotal.toFixed(2) + "€";
  }

  document.querySelectorAll(".cart-qty").forEach(select => {
    select.addEventListener("change", async e => {
      const card = e.target.closest(".product-cart");
  
      await fetch(`${API_URL}/cart/update_quantity.php`, {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify({
          product_id: card.dataset.id,
          selected_color: card.dataset.color,
          size: card.dataset.size,
          quantity: e.target.value
        })
      });
  
      recalculateSubtotal();
    });
  });

  document.querySelectorAll(".color-radio, .cart-size").forEach(input => {
    input.addEventListener("change", async e => {
      const card = e.target.closest(".product-cart");

      const newColor = card.querySelector(".color-radio:checked")?.value || '';
      const newSize = card.querySelector(".cart-size").value;

      await fetch(`${API_URL}/cart/update_variant.php`, {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify({
          product_id: card.dataset.id,
          old_color: card.dataset.color,
          old_size: card.dataset.size,
          new_color: newColor,
          new_size: newSize
        })
      });

      card.dataset.color = newColor;
      card.dataset.size = newSize;
    });
  });

  //Eliminar producto mejorado -- La página no se refresca cada vez
  document.querySelectorAll(".remove").forEach(btn => {
    btn.addEventListener("click", async e => {
      const card = e.target.closest(".product-cart");

      await fetch(`${API_URL}/cart/remove_from_cart.php`, {
        method: "POST",
        headers: {"Content-Type":"application/json"},
        body: JSON.stringify({
          product_id: card.dataset.id,
          selected_color: card.dataset.color,
          size: card.dataset.size
        })
      });

      card.remove();
      recalculateSubtotal();
      showMessage("Product removed");
    });
  });

  document.querySelectorAll(".remove").forEach(btn => {
    btn.addEventListener("keydown", async e => {

      if(e.key === "Enter" || e.key === " "){   
        const card = e.target.closest(".product-cart");
  
        await fetch(`${API_URL}/cart/remove_from_cart.php`, {
          method: "POST",
          headers: {"Content-Type":"application/json"},
          body: JSON.stringify({
            product_id: card.dataset.id,
            selected_color: card.dataset.color,
            size: card.dataset.size
          })
        });
  
        card.remove();
        recalculateSubtotal();
        showMessage("Product removed");
      }
    });
  });
});
