document.addEventListener("DOMContentLoaded", async () => {
  const btnReviews = document.querySelector('.reviews-list button');
  const moreReviews = document.querySelector('.more-reviews');

  btnReviews?.addEventListener('click', () => {
    moreReviews.classList.toggle('hidden');
    btnReviews.textContent = moreReviews.classList.contains('hidden') ? 'See more' : 'See less';
  });

  //Hacemos que el contenido sea dinámico con el ID del producto
  const params = new URLSearchParams(window.location.search);
  const productId = params.get("id");

  if (!productId) return;

  if (!API_URL) {
    console.error("No backend available.");
    return;
  }

  try {
    const response = await fetch(`${API_URL}/db/get_product.php?id=${productId}`);
    const product = await response.json();
    //console.log(product);

    if (!product || product.error) return;

    document.getElementById("image_path").src = `${ASSETS_URL}${product.image_path}`;
    document.getElementById("product_name").textContent = product.product_name;
    document.getElementById("description").textContent = product.description;
    document.getElementById("unit_price").textContent = product.unit_price + "€";

    //Generar radio buttons de color dinámicos
    const colors = product.color ? product.color.split(',') : [];
    const colorLabel = document.querySelector('label[for="color"]');
    if (colorLabel) {
      colorLabel.innerHTML = 'Color: '; //Limpiamos los botones antiguos

      colors.forEach(c => {
        const radio = document.createElement("input");
        radio.type = "radio";
        radio.name = "color";
        radio.id = `color-${c}`;
        radio.value = c;
        radio.className = `color-radio ${c}`;

        const label = document.createElement("label");
        label.setAttribute("for", `color-${c}`);
        label.className = "cursor-pointer px-1";
        label.textContent = "";

        colorLabel.appendChild(radio);
        colorLabel.appendChild(label);
      });
    }

  } catch (error) {
    console.error("Error: ", error);
  }

  //Añadir elementos al carrito
  async function addToCart(productId, quantity = 1, color = null, size = null) {
    if (!API_URL) {
      return;
    }

    try {
      const res = await fetch(`${API_URL}/cart/add_to_cart.php`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          product_id: productId,
          quantity: quantity,
          selected_color: color ?? '', //Le damos un valor en blanco, ya que sino será "undefined" y la base de datos lo rechazará
          size: size ?? 40 //Por defecto, ponemos la talla mínima
        })
      });

      const data = await res.json();
      if (data.error) {
        //console.error("Error añadiendo al carrito:", data.error);
      } else {
        //console.log("Producto añadido al carrito:", data);
      }
    } catch (err) {
      console.error("Error: ", err);
    }
  }

  //Comportamiento del boton para añadir al carrito
  const addToCartBtn = document.querySelector('.add-to-cart');

  addToCartBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    const productId = new URLSearchParams(window.location.search).get('id');
    const quantity = parseInt(document.querySelector('#quantity').value);
    const size = document.querySelector('#size').value;
    const color = document.querySelector('input[name="color"]:checked')?.value || null;

    if (!color) {
      showMessage("You need to select a color!"); //Lanzamos el popup con un mensaje que avise al usuario de que debe elegir un color
      return;
    }

    await addToCart(productId, quantity, color, size);
    showMessage("Added to cart");
  });
});
