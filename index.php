<?php
$page_title = "SRS | Dashboard";
include 'includes/header.php';
include 'dashboard/data.php';
?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active"><a>Dashboard</a></li>
                        </ol>
                    </div><!-- /.col-sm-6 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary collapsed-card">
                            <!-- card-header -->
                            <div class="card-header">
                            <h3 class="card-title">SR System <small>Objectives</small></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            </div>
                            <!-- /.card-header -->

                            <!-- card-body -->
                            <div class="card-body">
                                <ul><i class = "fa fa-angle-right" aria-hidden="true"></i> This system purpose is to help the staff or employees make their work faster and efficient by using the system where they can monitor the remaining products in the records where they can view in the database.</ul>
                                <ul><i class = "fa fa-angle-right" aria-hidden="true"></i> The system will provide a good service to the company such as better and smoother transaction process that brings bigger profit.</ul>
                                <ul><i class = "fa fa-angle-right" aria-hidden="true"></i> SR System can fix the problem in managing records for easier monitoring and tracking as well as help the workers to have an efficient and faster way of recording details for each transaction. </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo getProductCount(); ?></h3>
                                <p>Products Registered</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="<?php echo BASE;?>products/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3><?php echo getSupplierCount(); ?></h3>
                                <p>Suppliers Registered</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <a href="<?php echo BASE;?>suppliers/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3><?php echo getTransactionCount(); ?></h3>
                                <p>Current Month Transactions</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <a href="<?php echo BASE;?>transactions/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>RM<?php echo number_format((double)getSalesMonth(), 2, '.', ''); ?></h3>
                                <p>Current Month Sales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-comment-dollar"></i>
                            </div>
                            <a href="<?php echo BASE;?>transactions/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>RM<?php echo number_format((double)getSales(), 2, '.', ''); ?></h3>
                                <p>Annual Total Sales</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-comments-dollar"></i>
                            </div>
                            <a href="<?php echo BASE;?>transactions/" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <p class="card-title">Supplier Product Sold</p>
                            </div>
                            <div class="card-body">
                                <canvas id="donutChart" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <p class="card-title">Montly Sales</p>
                            </div>
                            <div class="card-body">
                                <canvas id="sales-chart" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Main -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
    <div hidden> <!-- Chart Data -->
        <?php
            for($i = 1; $i <= 12; $i++) {
        ?>
            <input hidden type="text" class="monthTextBox" value="<?php echo getSalesForMonth($i); ?>">
        <?php
            }
        ?>

        <?php
            $suSales = getSupplierSales();
            foreach($suSales as $r) { 
        ?>
            <input hidden type="text" class="suTextBox" value="<?php echo $r['su_name']; ?>">
            <input hidden type="text" class="qtySoldTextBox" value="<?php echo $r['qty_sold']; ?>">
        <?php        
            }
        ?>
    </div>  
<?php
include 'includes/footer.php';
?>

<script>
    loadChart();
    function loadChart() {
        var monthlySales = []; 
        for(var i = 0; i < document.getElementsByClassName('monthTextBox').length; i++) {
            monthlySales.push(document.getElementsByClassName('monthTextBox')[i].value);
        }
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var $salesChart = $('#sales-chart')
        var salesChart = new Chart($salesChart, {
            type: 'bar',
            data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
            datasets: [
                {
                backgroundColor: '#007bff',
                borderColor: '#007bff',
                data: monthlySales
                }
            ]
            },
            options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                gridLines: {
                    display: true
                },
                ticks: $.extend({
                    beginAtZero: true,

                    callback: function (value) {
                    if (value >= 1000) {
                        value /= 1000
                        value += 'k'
                    }

                    return 'RM' + value
                    }
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
    }

    loadDonut();
    function loadDonut() {
        var suppArray = [];
        var productSold = []; 
        var color = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];
        var bgColor = [];
        var j = 0;
        for(var i = 0; i < document.getElementsByClassName('suTextBox').length; i++) {
            suppArray.push(document.getElementsByClassName('suTextBox')[i].value);
            productSold.push(document.getElementsByClassName('qtySoldTextBox')[i].value);
            if(i > 5) j = 0;
            bgColor.push(color[j]);
            j++;
        }
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutData        = {
        labels: suppArray,
        datasets: [
            {
            data: productSold,
            backgroundColor : bgColor,
            }
        ]
        }
        var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
        }
        var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
    }
</script>

</body>
</html>