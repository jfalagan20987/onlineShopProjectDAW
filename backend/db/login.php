<?php
require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');

$errors = array();

if(isset($_POST['submit'])){
  
  if(empty($_POST['user'])){
    $errors['user'] = "An username is required";
  }else{
    unset($errors['user']);
    $user = $_POST['user'];
    if(!preg_match('/^[a-zA-Z0-9]/', $user)){
      $errors['user'] = "Not special characters or spaces are allowed";
    }else{
      $errors['user'] = "";
    }
  }
  
  if(empty($_POST['pwd'])){
    $errors['pwd'] = "A password is required";
  }else{
    unset($errors['pwd']);
  }
  
  if(!array_filter($errors)){
    
      $user = $_POST['user'];
      $pwd = $_POST['pwd'];
      
      $sql = "SELECT *
          FROM `012_customers`
          WHERE username = '$user' AND `password` = '$pwd' OR email = '$user' AND `password` = '$pwd';";
      
      require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');
      $result = mysqli_query($conn, $sql);
      $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
      
      $_SESSION['customer_id'] = $customer[0]['customer_id'];
      $_SESSION['username'] = $customer[0]['username'];
      $_SESSION['customer_type'] = $customer[0]['customer_type'];


      //LOG
      if($_SESSION['customer_id'] != null){
        $logDir  = $_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/logs'; //Directory
        $logFile = $logDir . '/log.txt'; //txt File
  
        // Create the directory if it doesn't exist (avoids errors)
        if (!is_dir($logDir)) mkdir($logDir, 0777, true);
  
        //Handle the file: pointer at the bottom -- Open the "connection"
        $handle = fopen($logFile, 'a+');
  
        //Once the handle variable is set, add a new line
        if ($handle) {
            $customer_id = $_SESSION['customer_id'];
            $username = $_SESSION['username'] ?? 'unknown';
  
            //Our timestamp with the desired format
            date_default_timezone_set('Europe/Madrid');
            $date = date('Y-m-d H:i:s');
  
            //Write the new line
            fwrite($handle, "Customer $customer_id ($username) has logged in -- $date\n");
  
            //Close the "connection" with the file
            fclose($handle);
        }
      }

      
      if($customer[0]['customer_type'] == 'admin'){?>
        <script>
          window.location.href="/student012/shop/backend/index.php";
        </script>
      <?php }elseif($customer[0]['customer_type'] == 'customer'){?>
        <script>
          window.location.href="/student012/shop/backend/index.php";
        </script>
      <?php };
    }
  };
?>

<main class="flex items-center justify-center mt-0 bg-anti-flash-white">
  <form class="flex flex-col items-center justify-center m-48 gap-10 border-2 border-solid border-poppy rounded-2xl p-10 w-96" method="POST">
    <h3 class="text-center font-bold text-xl">SIGN IN</h3>
    <p class="flex flex-col">
      Username or Email:
            <input type="text" name="user" id="user" autocomplete="off" class="bg-white border-2 border-onyx rounded pl-1 focus:border-2 focus:outline-0 focus:border-salmon-pink">
            <small class="text-poppy">
              <?php
                if(!empty($errors['user'])){
                    echo $errors['user'];
                    unset($errors['user']);
                  }
              ?>
            </small>
        </p>

        <p class="flex flex-col">
            Password:
            <input type="password" name="pwd" id="pwd" class="bg-white border-2 border-onyx rounded pl-1 focus:border-2 focus:outline-0 focus:border-salmon-pink">
            <small class="text-poppy">
              <?php
                if(!empty($errors['pwd'])){
                    echo $errors['pwd'];
                    unset($errors['pwd']);
                  }
              ?>
            </small>
        </p>
        <input type="submit" name="submit" value="LOGIN" class="bg-poppy p-3 rounded text-anti-flash-white cursor-pointer font-bold hover:scale-110">
    </form>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php'); ?>