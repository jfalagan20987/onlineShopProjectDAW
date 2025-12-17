<?php
    session_start();

    //COOKIES
    $defaultLang = 'en';

    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];

        //Timeout
        $timeout = time() + 10000;

        setcookie('lang', $lang, $timeout, "/");
        $_COOKIE['lang'] = $lang;

        header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;

    }
    $lang = $_GET['lang'] ?? ($_COOKIE['lang'] ?? $defaultLang);

    $customer_id = $_SESSION['customer_id'] ?? null;
    $username = $_SESSION['username'] ?? null;
    $customer_type = $_SESSION['customer_type'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/student012/shop/css/output.css">
    <link rel="stylesheet" href="/student012/shop/css/scrollbar.css">
    <title>Shift & Go</title>
</head>
<body class="m-0 p-0 box-border list-none font-roboto text-onyx h-screen">
    <!--Header con el logo en tres formatos distintos que se usarán según conveniencia-->
    <header class="header-footer sticky top-0 z-3">
        <img id="btn-menu" class="h-6 cursor-pointer lg:hidden lg:ml-1.5" src="/student012/shop/assets/icons/menu_burger.png" alt="menu-burger">
        <img class="logo cursor-pointer h-15 m-0 sm:hidden" src="/student012/shop/assets/logos/logo_small_shift_and_go.png" alt="logo-small">
        <img class="logo cursor-pointer h-15 m-0 hidden sm:flex lg:hidden" src="/student012/shop/assets/logos/logo_long_shift_and_go.png" alt="logo-long">
        <img class="logo cursor-pointer m-0 hidden lg:flex h-20" src="/student012/shop/assets/logos/logo_shift_and_go.png" alt="logo">

        <!--nav que será un desplegable en Mobile y Tablet, pero que estará fijo en Desktop-->
        <nav id="nav-header" class="nav-header">
            <div id="btn-close" class="h-6 absolute top-6 right-6 cursor-pointer lg:hidden">
                <img class="h-6" src="/student012/shop/assets/icons/close_menu.png" alt="close-menu">
            </div>
            <!--Buscador de la versión Desktop, que debe encontrarse dentro del header a diferencia de las versiones Mobile y Tablet-->
            <div class="buscador hidden">
                <input class="h-10 w-full border border-solid border-onyx rounded pl-2 text-onyx font-medium bg-anti-flash-white 
                focus:border-3 focus:border-solid focus:border-salmon-pink focus:outline-0 focus:shadow-salmon-pink focus:shadow-xs" type="search" name="search" placeholder="Search products..." autocomplete="off">
            </div>

            <!--Contenido del nav-->
            <ul class="flex flex-col gap-y-5 w-full m-10 lg:flex-row lg:justify-center lg:items-center lg:w-full lg:gap-20 lg:m-0">
                <li><a class="nav-header-a" id="index" href="../index.html">Home</a></li>
                <li><a class="nav-header-a" id="aboutUs" href="#">About us</a></li>
                <li><a class="nav-header-a" id="settings" href="/student012/shop/backend/index.php">BACKEND - Index</a></li>
                <li class="lg:relative">
                    <div class="flex items-center gap-0.5">
                        <a class="nav-header-a" id="categories" href="#">Manuals</a>

                        <!--Iconos para controlar el submenu en dos colores distintos que controlaremos con data-variant en JavaScript-->
                        <img src="/student012/shop/assets/icons/dropdown.svg" alt="dropdown" class="dropdown cursor-pointer lg:hidden" data-variant="white">
                        <img src="/student012/shop/assets/icons/arrowup.svg" alt="arrowup" class="arrowup cursor-pointer lg:hidden" data-variant="white">

                        <img src="/student012/shop/assets/icons/dropdown-onyx.svg" alt="dropdown" class="dropdown cursor-pointer lg:flex" data-variant="onyx">
                        <img src="/student012/shop/assets/icons/arrowup-onyx.svg" alt="arrowup" class="arrowup cursor-pointer" data-variant="onyx">
                    </div>
                    <ul class="submenu">
                        <li><a class="nav-header-a" href="/student012/shop/backend/manuals/technical_manual.php">Technical Manual</a></li>
                        <li><a class="nav-header-a" href="/student012/shop/backend/manuals/installation_manual.php">Installation Manual</a></li>
                        <li><a class="nav-header-a" href="/student012/shop/backend/manuals/user_manual_shift_&_go.pdf" download>User Manual</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="flex gap-4 items-center lg:w-[300px]">
            <!--SELECT LANGUAGE-->
            <form method="GET" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <div class="relative">
                    <!-- Botón actual -->
                    <button type="button"
                            onclick="document.getElementById('lang-menu').classList.toggle('hidden')"
                            class="w-16 flex items-center gap-2 border border-onyx rounded px-2 py-1 bg-anti-flash-white text-sm cursor-pointer">
                        <?php if ($lang === 'en'): ?>
                            <img src="/student012/shop/assets/lang/uk.png" class="h-4">
                            EN
                        <?php elseif ($lang === 'es'): ?>
                            <img src="/student012/shop/assets/lang/spain.png" class="h-4">
                            ES
                        <?php else: ?>
                            <img src="/student012/shop/assets/lang/catalonia.png" class="h-4">
                            CA
                        <?php endif; ?>
                    </button>

                    <!-- Menú desplegable -->
                    <div id="lang-menu"
                        class="absolute right-0 mt-2 w-18 bg-white border border-onyx rounded shadow hidden">

                        <a href="?lang=en" class="flex items-center gap-2 px-3 py-2 hover:bg-salmon-pink">
                            <img src="/student012/shop/assets/lang/uk.png" class="h-4"> EN
                        </a>

                        <a href="?lang=es" class="flex items-center gap-2 px-3 py-2 hover:bg-salmon-pink">
                            <img src="/student012/shop/assets/lang/spain.png" class="h-4"> ES
                        </a>

                        <a href="?lang=ca" class="flex items-center gap-2 px-3 py-2 hover:bg-salmon-pink">
                            <img src="/student012/shop/assets/lang/catalonia.png" class="h-4"> CA
                        </a>
                    </div>
                </div>
            </form>
            <div class="user">
                <img class="h-8 cursor-pointer" src="/student012/shop/assets/icons/user.png" alt="user">
                <!--Este texto, por cuestiones de espacio, solo se mostrará en Tablet y Desktop-->
                <p class="hidden font-bold text-onyx sm:flex">
                    <?php if(!empty($username)):?>
                        Hello, <?php echo $username;
                    endif;?>
                </p>
            </div>
            <img class="h-8 cursor-pointer" src="/student012/shop/assets/icons/shopping_cart_black.png" alt="shopping-cart">
        </div>
    </header>                    