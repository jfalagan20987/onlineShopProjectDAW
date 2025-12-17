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
    const CUSTOMER_TYPE = "<?php echo $customer_type;?>";
    console.log("DEBUG CUSTOMER_TYPE =", JSON.stringify(CUSTOMER_TYPE));
</script>

<script>

    function showSearch(str) {
        let hintText = document.getElementById('hintText');
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

    function renderProducts(products, container) {
        let output = "";

        products.forEach(product => {

            let adminHTML = `
                <form class="w-full" action="/student012/shop/backend/db/product_update.php" method="POST">
                    <input type="hidden" name="product_id" value="${product.product_id}">
                    <input type="submit" value="UPDATE" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
                </form>

                <form class="w-full" action="/student012/shop/backend/db/product_delete.php" method="POST">
                    <input type="hidden" name="product_id" value="${product.product_id}">
                    <input type="submit" value="DELETE" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-110">
                </form>

                <form class="w-full" action="/student012/shop/backend/db/db_add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="${product.product_id}">
                    
                    <div class="flex items-center justify-between mb-2 w-full">
                        <label class="font-bold">Color:
                            <select name="color" class="font-normal bg-white border border-solid border-onyx rounded">
                                ${product.color.split(',').map(color =>
                                    `<option value="${color}">${color.toUpperCase()}</option>`
                                ).join('')}
                            </select>
                        </label>

                        <label class="font-bold">Quantity:
                            <input type="number" name="quantity" min="1" class="font-normal bg-white border border-solid border-onyx rounded pl-1 w-10">
                        </label>

                        <label class="font-bold">Size:
                            <select name="size" class="font-normal bg-white border border-solid border-onyx rounded h-7 w-12">
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                                <option value="47">47</option>
                            </select>
                        </label>
                    </div>

                    <input type="submit" value="ADD TO CART"
                        class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
                </form>
            `;

            let customerHTML = `
                <form class="w-full" action="/student012/shop/backend/db/db_add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="${product.product_id}">
                    
                    <div class="flex items-center justify-between mb-2 w-full">
                        <label class="font-bold">Color:
                            <select name="color" class="font-normal bg-white border border-solid border-onyx rounded">
                                ${product.color.split(',').map(color =>
                                    `<option value="${color}">${color.toUpperCase()}</option>`
                                ).join('')}
                            </select>
                        </label>

                        <label class="font-bold">Quantity:
                            <input type="number" name="quantity" min="1" value="1" class="font-normal bg-white border border-solid border-onyx rounded pl-1 w-10">
                        </label>

                        <label class="font-bold">Size:
                            <select name="size" class="font-normal bg-white border border-solid border-onyx rounded h-7 w-12">
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                                <option value="47">47</option>
                            </select>
                        </label>
                    </div>

                    <input type="submit" value="ADD TO CART"
                        class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
                </form>
            `;

            output += `
                <div class="border border-solid border-poppy rounded-xl p-4 w-2xs flex flex-col items-center justify-center gap-2 hover:bg-red-200">

                    <img src="${product.image_path}" class="rounded-xl w-full">
                    <h3 class="font-bold text-2xl self-start">${product.product_name}</h3>
                    <p class="self-end font-bold text-lg">${product.unit_price}€</p>

                    ${CUSTOMER_TYPE == 'admin' ? adminHTML : customerHTML}

                </div>
            `;
        });

        container.innerHTML = output;
    }
</script>

<main class="bg-anti-flash-white p-5">
    <div class="flex items-center w-11/12">
        <form class="text-center flex items-center w-11/12">
            <label class="font-bold w-full" for="product_name">Search:
                <input class="w-2/3 bg-white border border-solid border-onyx rounded pl-1 focus:border-salmon-pink focus:outline-0 focus:border-2"
                       type="text" id="product_name" onkeyup="showSearch(this.value)">
            </label>
        </form>

        <a href="/student012/shop/backend/db/product_insert.php">
            <button class="rounded bg-poppy border-0 p-1.5 w-20 text-anti-flash-white font-bold cursor-pointer hover:scale-110">
                ADD
            </button>
        </a>
    </div>

    <div class="productList w-full flex flex-wrap items-center justify-center gap-4 mt-3" id="hintText">
        <?php foreach($products as $product) {
            showProduct($product, $customer_type);
        } ?>
    </div>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>