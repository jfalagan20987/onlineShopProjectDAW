//ARCHIVO QUE HE USADO PARA HACER PRUEBAS -- QUEDA DESCARTADO POR AHORA

document.addEventListener("DOMContentLoaded", async () => {

    if (!API_URL) return;

    const res = await fetch(`${API_URL}/cart/get_cart.php`);
    const cart = await res.json();

    const list = document.querySelector(".product-list");
    list.innerHTML = "";

    let subtotal = 0;

    cart.forEach(item => {
      subtotal += item.unit_price * item.quantity;

      list.innerHTML += `
        <div class="product-cart">
          <img src="${item.image_path}">
          <h2>${item.product_name}</h2>
          <p>${item.unit_price}€ × ${item.quantity}</p>
        </div>
      `;
    });

    document.querySelector(".subtotal span").textContent =
      subtotal.toFixed(2) + "€";
    
    //Eliminar elementos
    document.querySelectorAll(".remove").forEach(btn => {
      btn.addEventListener("click", async (e) => {
        const productId = e.target.dataset.id;
        await fetch(`${API_URL}/cart/remove_from_cart.php?product_id=${productId}`);
        location.reload();x
      });
    });
  });