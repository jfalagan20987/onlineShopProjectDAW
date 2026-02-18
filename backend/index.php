<?php 
    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');

    require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

    $lastWeather = null;

    $sql = "SELECT accuweather_json FROM `012_accuweather` ORDER BY weather_date DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $lastWeather = json_decode($row['accuweather_json'], true);
    }

    $forecast = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/student012/shop/api/accuweather/forecast_5days.json');

    $forecast_json = json_decode($forecast, true);

    // Store info from the three next days
    $next_day1 = $forecast_json['DailyForecasts'][1];
    $next_day2 = $forecast_json['DailyForecasts'][2];
    $next_day3 = $forecast_json['DailyForecasts'][3];
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


    <!-- WEATHER -->
    <div class="flex items-end gap-10">
        <div class="mt-10 flex flex-col items-center gap-4">
            <button id="btnWeather" class="h-8 w-50 rounded text-onyx cursor-pointer font-bold hover:scale-110">
                UPDATE WEATHER
            </button>
    
            <div id="weatherBox" class="p-4 bg-white rounded shadow text-black flex flex-col gap-4 items-center <?= $lastWeather ? '' : 'hidden' ?>">
                <h3>Today</h3>
                <?php if ($lastWeather): 
                    $w = $lastWeather[0];
                ?>
                    <div class="flex items-center gap-4">
                        <img src="/student012/shop/assets/icons/weather-icons/<?php echo $w['WeatherIcon']; ?>.svg" alt="weather-icon">
                        <div class="flex flex-col">
                            <h3 class="font-bold text-lg">Maó</h3>
                            <p class="font-bold text-2xl"><?php echo $w['Temperature']['Metric']['Value']; ?> °C</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <img src="/student012/shop/assets/icons/weather-icons/32.svg" alt="wind-icon" class="h-10">
                        <p class="font-bold"><?php echo $w['WindGust']['Speed']['Metric']['Value']; ?> km/h</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="flex flex-col items-center gap-4">
            <h2>FORECAST</h2>
            <div class="p-4 bg-white rounded shadow text-black flex gap-8 items-center">
                <div class="flex flex-col items-center gap-4 border-solid border-r-2 pr-8">
                    <h3><?php echo explode('T', $next_day1['Date'])[0] ?></h3>
                    <div class="flex items-center gap-4">
                        <img src="/student012/shop/assets/icons/weather-icons/<?php echo $next_day1['Day']['Icon']; ?>.svg" alt="weather-icon">
                        <div class="flex flex-col items-center gap-4">
                            <p class="font-bold">Min: <?php echo $next_day1['Temperature']['Minimum']['Value']; ?> °C</p>
                            <p class="font-bold">Max: <?php echo $next_day1['Temperature']['Maximum']['Value']; ?> °C</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="/student012/shop/assets/icons/weather-icons/32.svg" alt="wind-icon" class="h-10">
                        <p class="font-bold"><?php echo $next_day1['Day']['Wind']['Speed']['Value']; ?> km/h</p>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-4 border-solid border-r-2 pr-8">
                    <h3><?php echo explode('T', $next_day2['Date'])[0] ?></h3>
                    <div class="flex items-center gap-4">
                        <img src="/student012/shop/assets/icons/weather-icons/<?php echo $next_day2['Day']['Icon']; ?>.svg" alt="weather-icon">
                        <div class="flex flex-col items-center gap-4">
                            <p class="font-bold">Min: <?php echo $next_day2['Temperature']['Minimum']['Value'] ?> °C</p>
                            <p class="font-bold">Max: <?php echo $next_day2['Temperature']['Maximum']['Value'] ?> °C</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="/student012/shop/assets/icons/weather-icons/32.svg" alt="wind-icon" class="h-10">
                        <p class="font-bold"><?php echo $next_day2['Day']['Wind']['Speed']['Value']; ?> km/h</p>
                    </div>
                </div>
                <div class="flex flex-col items-center gap-4">
                    <h3><?php echo explode('T', $next_day3['Date'])[0] ?></h3>
                    <div class="flex items-center gap-4">
                        <img src="/student012/shop/assets/icons/weather-icons/<?php echo $next_day3['Day']['Icon']; ?>.svg" alt="weather-icon">
                        <div class="flex flex-col items-center gap-4">
                            <p class="font-bold">Min: <?php echo $next_day3['Temperature']['Minimum']['Value'] ?> °C</p>
                            <p class="font-bold">Max: <?php echo $next_day3['Temperature']['Maximum']['Value'] ?> °C</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <img src="/student012/shop/assets/icons/weather-icons/32.svg" alt="wind-icon" class="h-10">
                        <p class="font-bold"><?php echo $next_day3['Day']['Wind']['Speed']['Value']; ?> km/h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    document.getElementById("btnWeather").addEventListener("click", updateWeather);

    function updateWeather() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/student012/shop/api/accuweather/weather_info.php", true);
        xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                showWeather(data);
            }
        };

        xhr.send("{}");
    }

    function showWeather(data) {
        const box = document.getElementById("weatherBox");
        box.classList.remove("hidden");

        const w = data[0];

        box.innerHTML = `
        <h3>Today</h3>
        <div class="flex items-center gap-4">
            <img src="/student012/shop/assets/icons/weather-icons/${w.WeatherIcon}.svg" alt="weather-icon">
            <div class="flex flex-col">
                <h3 class="font-bold text-lg">Maó</h3>
                <p class="font-bold text-2xl">${w.Temperature.Metric.Value} °C</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <img src="/student012/shop/assets/icons/weather-icons/32.svg" alt="wind-icon" class="h-10">
            <p class="font-bold">${w.WindGust.Speed.Metric.Value} km/h</p>
        </div>
        `;
    }
</script>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>
