<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');
?>
<main class="bg-anti-flash-white text-onyx flex flex-col items-center justify-center p-20 gap-15 mt-0 min-h-3/4">

    <?php if($customer_type == 'customer'): ?>
        <form action="/student012/shop/backend/views/products.php">
            <input type="submit" value="SEE PRODUCTS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/db/my_profile.php">
            <input type="submit" value="MY PROFILE" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/db/my_shopping_cart.php">
            <input type="submit" value="MY SHOPPING CART" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/views/my_orders.php">
            <input type="submit" value="MY ORDERS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/db/logout.php">
            <input type="submit" value="LOGOUT" class="h-10 w-25 border-4 border-poppy rounded bg-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
    <?php elseif($customer_type == 'admin'): ?>
        <form action="/student012/shop/backend/views/customers.php">
            <input type="submit" value="CUSTOMERS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/views/products.php">
            <input type="submit" value="PRODUCTS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/views/orders.php">
            <input type="submit" value="ORDERS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/db/my_shopping_cart.php">
            <input type="submit" value="MY SHOPPING CART" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/views/my_orders.php">
            <input type="submit" value="MY ORDERS" class="h-10 w-50 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/db/logout.php">
            <input type="submit" value="LOGOUT" class="h-10 w-25 border-4 border-poppy rounded bg-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
    <?php else: ?>
        <form action="/student012/shop/backend/db/login.php">
            <input type="submit" value="LOGIN" class="h-10 w-25 rounded bg-poppy text-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
        <form action="/student012/shop/backend/forms/form_register.php">
            <input type="submit" value="REGISTER" class="h-10 w-25 border-4 border-poppy rounded bg-anti-flash-white cursor-pointer font-bold hover:scale-110">
        </form>
    <?php endif;?>
    
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>