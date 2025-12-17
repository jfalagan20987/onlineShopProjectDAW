<?php
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/functions/orders_functions.php');
  $sql = "SELECT o.*, p.image_path, p.product_name, c.forename, c.surname, c.nif, c.phone, a.direction, a.location, a.country, a.zip_code
        FROM `012_orders` AS o
        INNER JOIN `012_products` AS p ON o.product_id = p.product_id
        INNER JOIN `012_customers` AS c ON o.customer_id = c.customer_id
        INNER JOIN `012_addresses` AS a ON o.address_id = a.address_id;";

  $result = mysqli_query($conn, $sql);
  $all_orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

  // Group the products by order_number to retrieve all their details
  $orders_numbers = [];
  foreach($all_orders as $order):
    $orders_numbers[$order['order_number']][] = $order;
  endforeach;
?>

<script>
  function showSearch(str) {
    console.log(str);
    let hintText = document.getElementById('hintText');

    // If the input is empty
    if (str.length === 0) {
      let httpRequest = new XMLHttpRequest();

      httpRequest.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
          let orders = JSON.parse(this.responseText);
          renderOrders(orders, hintText);
        }
      };

      httpRequest.open("GET", "db_orders.php?param=" + str, true);
      httpRequest.send();
      return;
    }

    // If the input has any content
    let httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let orders = JSON.parse(this.responseText);
            renderOrders(orders, hintText);
        }
    };

    httpRequest.open("GET", "db_orders.php?param=" + str, true);
    httpRequest.send();
  }

  function renderOrders(orders, container){
    let output = "";

    orders.forEach(order => {
      output += `
        <div class="flex flex-col gap-2 border border-solid border-poppy rounded-xl p-4 w-[400px] justify-center self-center">
          <h3 class="font-bold text-2xl">ORDER NUMBER: ${order.order_number}</h3>
          <div>
            <p>${order.forename} ${order.surname}</p>
            <p>${order.nif}</p>
            <p>${order.phone}</p>
            <p>${order.direction}, ${order.zip_code}</p>
            <p>(${order.location}, ${order.country})</p>
          </div>
        </div>
      `;
    });

    container.innerHTML = output;
  }
</script>

<main class="mt-0 bg-anti-flash-white min-h-3/4 p-5 flex flex-col items-center">
   <h2 class="font-bold text-center text-3xl mb-3">ORDERS</h2>
   <form class="text-center flex items-center justify-center w-11/12">
    <label class="font-bold w-96" for="order">
      <input class="w-96 bg-white border border-solid border-onyx rounded pl-1 focus:border-salmon-pink focus:outline-0 focus:border-2" type="text" name="order" id="order" placeholder="Insert order number..." onkeyup="showSearch(this.value)">
    </label>
  </form>
  <section class="flex gap-4 w-full m-4 flex-wrap justify-center" id="hintText">
    <?php foreach($orders_numbers as $order_number):
      showOrder($order_number);
    endforeach; ?>
  </section>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>