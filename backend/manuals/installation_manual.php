<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php'); ?>

<main class="m-8 flex flex-col gap-8 items-left text-left">
  <h1 class="font-bold text-4xl">Installation Manual</h1>
  <div>
    <h2 class="font-bold text-2xl">Operating System</h2>
    <p>Linux (Ubuntu 20.04 or higher recommended)</p>
  </div>

  <div>
    <h2 class="font-bold text-2xl">Web Server</h2>
    <p>Apache 2.4+</p>
  </div>

  <div>
    <h2 class="font-bold text-2xl">Database</h2>
    <p>MariaDB 10.4+</p>
  </div>

  <div>
    <h2 class="font-bold text-2xl">PHP</h2>
    <p>PHP 8.0 or higher</p>
  </div>

  <div>
    <h2 class="font-bold text-2xl">Required PHP Extensions</h2>
    <ul class="list-disc pl-8">
      <li>mysqli</li>
      <li>fileinfo</li>
      <li>session</li>
    </ul>
  </div>

  <div>
    <h2 class="font-bold text-2xl">Project Installation</h2>
    <p>The project must be copied into the Apache public directory:</p>
    <code class="block bg-gray-100 p-2 rounded mt-2">/var/www/html/student012/shop</code>
  </div>

  <div>
    <h2 class="font-bold text-2xl">Database Configuration</h2>
    <p>Create a new database and import the provided SQL structure. Then, configure the database connection in the following file:</p>
    <code class="block bg-gray-100 p-2 rounded mt-2">/backend/config/db_connect.php</code>
  </div>

  <div>
    <h2 class="font-bold text-2xl">File Permissions</h2>
    <p>The assets directory must have write permissions to allow image uploads:</p>
    <code class="block bg-gray-100 p-2 rounded mt-2">chmod -R 755 assets/</code>
  </div>

  <div>
    <h2 class="font-bold text-2xl">Final Notes</h2>
    <p>Once the installation is complete, the application can be accessed through a web browser. No additional configuration is required.</p>
  </div>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>