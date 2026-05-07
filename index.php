<?php
include("check_session.php");
include("config.php");
?>
<?php

$userQuery = "SELECT COUNT(*) AS total_user FROM users";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);
$totaluser = $user['total_user'];

$productQuery = "SELECT COUNT(*) AS total_products FROM products";
$productResult = mysqli_query($conn, $productQuery);
$product = mysqli_fetch_assoc($productResult);
$totalProducts = $product['total_products'];

$categoryquery = "SELECT COUNT(*) AS total_category FROM category";
$categoryResult = mysqli_query($conn, $categoryquery);
$category = mysqli_fetch_assoc($categoryResult);
$totalcategory = $category['total_category'];

$brandquery = "SELECT COUNT(*) AS total_brand FROM brands";
$brandResult = mysqli_query($conn, $brandquery);
$brand = mysqli_fetch_assoc($brandResult);
$totalbrand = $brand['total_brand'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php
    include("navbar.php");
    include("sidebar.php");
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>

            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $totaluser; ?></h3>

                  <p>Users Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo $totalbrand; ?></h3>

                  <p>Brands</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php echo $totaluser; ?></h3>
                  <p>Categories</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php echo $totalProducts; ?></h3>

                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- DONUT CHART -->
          <div class="row mb-2">
            <div class="col-md-6">
              <div class="card card-danger">
                <div class="card-header">
                  <h3 class="card-title">Top Selling Products</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Sales</h3>
                    <a href="sales_reports.php">View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <?php $query = mysqli_query($conn, "select sum(grand_total) as total from invoice where invoice_type='sales'");
                      $row = mysqli_fetch_assoc($query); ?>
                      <span class="text-bold text-lg"><?php echo $row['total']; ?></span>
                      <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 33.1%
                      </span>
                      <span class="text-muted">Since last month</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> Sales
                    </span>
                    <span>
                      <i class="fas fa-square text-gray"></i> Purchase
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
    </div>


  </div>
  </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
  include("footer.php");
  ?>

  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>

  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Moment -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="dist/js/demo.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/adminlte2167.js?v=3.2.0"></script>
  <!-- <script src="dist/js/pages/dashboard3.js"></script> -->
  <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"2437d112162f4ec4b63c3ca0eb38fb20","server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>


  <!-- Tempusdominus -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist\js\adminlte.min2167.js"></script>
  <script>
    var salesChart;
  </script>
  <script>
    $(function() {

      $('.date-filter').on('click', function() {

        let range = $(this).data('range');

        $.ajax({
          url: 'fetch_saleschart.php',
          type: 'GET',
          data: {
            range: range
          },
          dataType: 'json',
          success: function(response) {
            console.log(response);
            console.log(salesChart);
          }
        });

      });

    });
  </script>

  <?php
  $productLabels = [];
  $productSales = [];

  $sql = "
select p.name as product, SUM(id.qty * id.rate) as total_sales
from invoice i
join invoice_details id on id.invoice_id = i.id
join products p on p.id = id.product_id
where i.invoice_type = 'sales'
group by id.product_id
order by total_sales desc
";

  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $productLabels[] = $row['product'];
    $productSales[]  = $row['total_sales'];
  }

  ?>
  <?php
  $chartdata = [];
  $data = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December'
  ];

  $datasales = [];
  $datapurchase = [];

  foreach ($data as $key => $monthname) {

    $month = $key;

    $chartdata[] = $monthname;
    $salesquery = mysqli_query($conn, "select sum(grand_total) as total from invoice where invoice_type='sales' and MONTH(invoice_date)=$month");
    $salesrow = mysqli_fetch_assoc($salesquery);
    $datasales[] = $salesrow['total'];

    $purchasequery = mysqli_query($conn, "select sum(grand_total) as total from invoice where invoice_type='purchase' and MONTH(invoice_date)=$month");
    $purchaserow = mysqli_fetch_assoc($purchasequery);
    $datapurchase[] = $purchaserow['total'];
  }
  ?>

  <script>
    var chartLabels = <?php echo json_encode($chartdata); ?>;
    var salesData = <?php echo json_encode($datasales); ?>;
    var purchaseData = <?php echo json_encode($datapurchase); ?>;
    var donutLabels = <?php echo json_encode($productLabels); ?>;
    var donutSales = <?php echo json_encode($productSales); ?>;
  </script>

  <!-- ChartJS -->
  <!-- <script src="././plugins/chart.js/Chart.min.js"></script> -->
  <script>
    $(function() {

      console.log(chartLabels, salesData, purchaseData);
      console.log(donutLabels, donutSales);


      'use strict'

      var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }

      var mode = 'index'
      var intersect = true

      $salesChart = $('#sales-chart').get(0).getContext('2d');
      salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
          // labels: productLabels.map(row),
          labels: chartLabels,
          datasets: [{
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              data: salesData
            },
            {
              backgroundColor: '#ced4da',
              borderColor: '#ced4da',
              data: purchaseData
            }
          ]
        },

        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })

      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData = {
        labels: donutLabels,
        datasets: [{
          data: donutSales,
          backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#3c8dbc', '#d81b60', '#605ca8', '#39cccc', '#f56954', '#00a65a', '#f39c12', '#00c0ef'],
        }]
      }
      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })
    });

    // lgtm [js/unused-local-variable]
  </script>
</body>

<!-- , Sat, 29 Nov 2025 06:35:23 GMT -->

</html>