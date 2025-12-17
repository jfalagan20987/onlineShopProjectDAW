<?php
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/customer_functions.php');
    $sql = "SELECT * FROM `012_customers`";

    $result = mysqli_query($conn, $sql);
    $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<script>
    // Search customers
    function showSearch(str) {
        let hintText = document.getElementById('hintText');

        // If the input is empty, show all customers (default option)
        if (str.length === 0) {
            let httpRequest = new XMLHttpRequest();

            httpRequest.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    let customers = JSON.parse(this.responseText);
                    renderCustomers(customers, hintText);
                }
            };

            httpRequest.open("GET", "db_customers.php?param=", true);
            httpRequest.send();
            return;
        }

        // If the input has any content
        let httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let customers = JSON.parse(this.responseText);
                renderCustomers(customers, hintText);
            }
        };

        httpRequest.open("GET", "db_customers.php?param=" + str, true);
        httpRequest.send();
    }

    // Function to show the coincidences in both cases, so we don't repeat the same code two times
    function renderCustomers(customers, container) {
        let output = "";

        customers.forEach(customer => {
            output += `
                <div class="border border-solid border-poppy rounded-xl p-4 min-w-80 flex flex-col items-center justify-center gap-2 hover:bg-red-200">
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">Username:</p>
                    <p>${customer.username}</p>
                  </div>
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">Email:</p>
                    <p>${customer.email}</p>
                  </div>
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">Customer Type:</p>
                    <p>${customer.customer_type}</p>
                  </div>
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">Full name:</p>
                    <p>${customer.forename} ${customer.surname}</p>
                  </div>
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">NIF:</p>
                    <p>${customer.nif}</p>
                  </div>
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">Phone:</p>
                    <p>${customer.phone}</p>
                  </div>
                  <div class="flex gap-1 items-center">
                    <p class="font-bold">Birthdate:</p>
                    <p>${customer.birthdate}</p>
                  </div>
                  
                  <form class="w-full" action="/student012/shop/backend/db/customer_update.php" method="POST">
                      <input type="hidden" name="customer_id" value="${customer.customer_id}">
                      <input type="submit" value="UPDATE" class="rounded bg-poppy border-0 p-1.5 w-full text-anti-flash-white font-bold cursor-pointer hover:scale-110">
                  </form>

                  <form class="w-full" action="/student012/shop/backend/db/customer_delete.php" method="POST">
                      <input type="hidden" name="customer_id" value="${customer.customer_id}">
                      <input type="submit" value="DELETE" class="rounded bg-anti-flash-white border-2 border-solid border-poppy p-1.5 w-full text-poppy font-bold cursor-pointer hover:scale-110">
                  </form>
              </div>
            `;
        });

        container.innerHTML = output;
    }
</script>

<main class="bg-anti-flash-white p-5">
    <div class="flex items-center w-11/12">
        <form class="text-center flex items-center w-11/12">
            <label class="font-bold w-full" for="customer_name">Search:
                <input class="w-2/3 bg-white border border-solid border-onyx rounded pl-1 focus:border-salmon-pink focus:outline-0 focus:border-2" type="text" name="product_name" id="product_name" onkeyup="showSearch(this.value)">
            </label>
        </form>
        <a href="/student012/shop/backend/db/customer_insert.php"><button type="submit" class="rounded bg-poppy border-0 p-1.5 w-20 text-anti-flash-white font-bold cursor-pointer hover:scale-110">ADD</button></a>
    </div>
    
    <div class="w-full flex flex-wrap items-center justify-center gap-4 mt-3" id="hintText">
        <?php foreach($customers as $customer):
                showCustomer($customer);
        endforeach;
        ?>
    </div>

</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>