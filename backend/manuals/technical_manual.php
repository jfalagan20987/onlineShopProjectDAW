<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main class="m-8 flex flex-col gap-4 items-left text-left">
  <h1 class="font-bold text-4xl">Technical Manual</h1>
  <div>
    <h2 class="font-bold text-2xl">Introduction</h2>
    <p><strong>Project name:</strong> Shift & Go</p>
    <p><strong>Description:</strong> Shift & Go is a web-based e-commerce application focused on selling basketball shoes.</p>
  </div>
  <div>
    <h2 class="font-bold text-2xl">Implemented Features</h2>
    <ul class="list-disc flex flex-col gap-1 pl-8">
      <li>User session management</li>
      <li>Product, customers and orders management system</li>
      <li>Image upload using PHP file handling</li>
      <li>Language selector using cookies</li>
      <li>Dynamic shopping cart using AJAX with POST</li>
      <li>Filter products using AJAX with GET</li>
    </ul>
  </div>
  <div>
    <h2 class="font-bold text-2xl">Pending Features</h2>
    <ul class="list-disc flex flex-col gap-1 pl-8">
      <li>Reviews management system</li>
      <li>Full multilingual content translation</li>
      <li>Advanced form validation</li>
      <li>Error handling for image uploads</li>
      <li>Payment methods and Address management</li>
      <li>Show a message when something has been done</li>
    </ul>
  </div>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>