<?php
    //session_start();
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/product_functions.php');
    $sql = "SELECT * FROM `012_products`";

    $result = mysqli_query($conn, $sql);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<script>
    // Search products
    function showSearch(str) {
        let hintText = document.getElementById('hintText');

        // If the input is empty, show all products (default option)
        if (str.length === 0) {
            let httpRequest = new XMLHttpRequest();

            httpRequest.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    let products = JSON.parse(this.responseText);
                    renderProducts(products, hintText);
                }
            };

            httpRequest.open("GET", "db_products.php?param=", true);
            httpRequest.send();
            return;
        }

        // If the input has any content
        let httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let products = JSON.parse(this.responseText);
                renderProducts(products, hintText);
            }
        };

        httpRequest.open("GET", "db_products.php?param=" + str, true);
        httpRequest.send();
    }

    // Function to show the coincidences in both cases, so we don't repeat the same code two times
    function renderProducts(products, container) {
        let output = "";

        products.forEach(product => {
            output += `
                <div class="border border-solid border-poppy rounded-xl p-4 w-3xs flex flex-col items-center justify-center gap-2 hover:bg-red-200">
                    <img src="${product.image_path}" class="rounded-xl w-full">
                    <h3 class="font-bold text-2xl self-start">${product.product_name}</h3>
                    <p class="self-end font-bold text-lg">${product.unit_price}€</p>

                    <form class="w-full" action="/student012/shop/backend/db/product_update.php" method="POST">
                        <input type="hidden" name="product_id" value="${product.product_id}">
                        <input type="submit" value="UPDATE" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
                    </form>

                    <form class="w-full" action="/student012/shop/backend/db/product_delete.php" method="POST">
                        <input type="hidden" name="product_id" value="${product.product_id}">
                        <input type="submit" value="DELETE" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-110">
                    </form>
                </div>
            `;
        });

        container.innerHTML = output;
    }
</script>

<main class="bg-anti-flash-white p-5">
    <form class="text-center">
        <label class="font-bold" for="product_name">Search product:</label>
        <input class="w-2/3 bg-white border border-solid border-onyx rounded pl-1 focus:border-salmon-pink focus:outline-0 focus:border-2" type="text" name="product_name" id="product_name" onkeyup="showSearch(this.value)">
    </form>
    
    <div class="productList w-full flex flex-wrap items-center justify-center gap-4 mt-3" id="hintText">
        <?php foreach($products as $product):
                showProduct($product);
        endforeach;
        ?>
    </div>

</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>