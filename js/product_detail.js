//const { default: createPlugin } = require("tailwindcss/plugin");

document.addEventListener("DOMContentLoaded", async () => {
  const btnReviews = document.querySelector('.reviews-list button');
  const moreReviews = document.querySelector('.more-reviews');

  btnReviews?.addEventListener('click', () => {
    moreReviews.classList.toggle('hidden');
    btnReviews.textContent = moreReviews.classList.contains('hidden') ? 'See more' : 'See less';
  });

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
    console.log(product);

    if (!product || product.error) return;
    const image = document.getElementById("image_path").src;
    console.log(image);
    document.getElementById("image_path").src = `${window.location.origin}${product.image_path}`;
    document.getElementById("product_name").textContent = product.product_name;
    document.getElementById("description").textContent = product.description;
    document.getElementById("unit_price").textContent = product.unit_price + "€";

  } catch (error) {
    console.error("Error: ", error);
  }
});