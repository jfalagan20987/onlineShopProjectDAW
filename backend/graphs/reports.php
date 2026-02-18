<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/header.php');

  require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/config/db_connect.php');

  $sql = "SELECT * FROM `012_products_total_income_view`";
  $result = mysqli_query($conn, $sql);
  $report = mysqli_fetch_all($result, MYSQLI_ASSOC);

  $data = [];
  $data[] = ['Product', 'Total income (€)'];

  foreach($report as $product){
    $data[]=[
      $product['product_name'],
      (float)$product['total_income']
    ];
  }

  //Second graph
  $sql2 = "SELECT * FROM `012_customers_total_income_view`;";
  $result2 = mysqli_query($conn, $sql2);
  $customer_total_income = mysqli_fetch_all($result2, MYSQLI_ASSOC);

  $data2 = [];
  $data2[] = ['Customer', 'Total spent (€)'];

  foreach($customer_total_income as $customer){

    $customer_name = $customer['forename'].' '.$customer['surname'];

    $data2[]=[
      $customer_name,
      (float)$customer['total_income']
    ];
  }
?>

<script>
  google.charts.load('current', {packages:['corechart']});
  google.charts.setOnLoadCallback(drawBarChart);
  google.charts.setOnLoadCallback(drawPieChart);


  function drawBarChart(){

    const data = google.visualization.arrayToDataTable(<?php echo json_encode($data) ?>);

    const options = {
      title: 'Total income per product'
    };

    const chart = new google.visualization.BarChart(document.getElementById('myChart'));
    chart.draw(data, options);

  }

  function drawPieChart(){

    const data = google.visualization.arrayToDataTable(<?php echo json_encode($data2) ?>);
    const options = {
      title: 'Total income per customer',
      is3D: true
    }

    const chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
    chart.draw(data, options);
  }
</script>

<main>
  <div id="myChart" style="max-width:700px; height:400px"></div>

  <div id="myPieChart" style="max-width:700px; height:400px"></div>
</main>

<?php require($_SERVER['DOCUMENT_ROOT'].'/student012/shop/backend/footer.php');?>