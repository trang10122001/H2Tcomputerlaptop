<?php
    
    include_once "./partials/header.php";
    
    $sqlGetCountCustomer = "select count(*) as count from customer";
    $dataCountCustomer =  executeGetData($sqlGetCountCustomer);
    $countCustomer = $dataCountCustomer[0]['count'];

    $sqlGetCountCart = "select count(*) as count from cart";
    $dataCountCart =  executeGetData($sqlGetCountCart);
    $countCart = $dataCountCart[0]['count'];

    $sqlGetCountProduct = "select count(*) as count from product";
    $dataCountProduct =  executeGetData($sqlGetCountProduct);
    $countProduct = $dataCountProduct[0]['count'];

    $sqlGetRevenue  = "select sum(total) as total from cart where status = 3";
    $dataRevenue =  executeGetData($sqlGetRevenue);
    $revenue = $dataRevenue[0]['total'];
    $revenue = floor($revenue / 1000000);

?>

     
<div class="content-wrapper">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Tổng quan</h5>
                        </div>
                        <div class="card-body dashboard">
                            <div class="row">
                                
                                <div class="col-xl-3">
                                        <div class="box-info bg-info">
                                            <div class="top">
                                                <div class="content">
                                                    <h4 class="title"><?=$countCart?></h4>
                                                    <p>Đơn hàng</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa-solid fa-bag-shopping"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="box-info bg-success">
                                            <div class="top">
                                                <div class="content">
                                                    <h4 class="title"><?=$countProduct?></h4>
                                                    <p>Sản phẩm</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa-solid fa-book"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="box-info bg-warning">
                                            <div class="top">
                                                <div class="content">
                                                    <h4 class="title"><?=$revenue?></h4>
                                                    <p>Doanh thu (triệu)</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa-solid fa-list"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3">
                                        <div class="box-info bg-danger">
                                            <div class="top">
                                                <div class="content">
                                                    <h4 class="title"><?=$countCustomer?></h4>
                                                    <p>Khách hàng</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fa-solid fa-user-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            <div class="row">
                                <div class="col-xl-8">
                                    <canvas id="revenue-chart"></canvas>
                                </div>
                                <div class="col-xl-4">
                                    <canvas id="best-seller-product-chart"></canvas>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-8">
                                    <canvas id="count-cart-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Close admin-wrapper -->
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>

    const revenueChartElement = document.getElementById('revenue-chart');
    const countCartChartElement = document.getElementById('count-cart-chart')
    const bestSelletProductChartElement = document.getElementById('best-seller-product-chart');

    function handleCartChart() {
        $.ajax({
            url: "./ajax/index.php",
            type: 'get',
            data: {
                action: 'get-data-cart-for-chart',
            },
            dataType: 'json',
            success: function(result) {
                console.log(result)

                let labels = []
                let data= []

                $.each(result, function(index, item) {
                    labels.push(item.date)
                    data.push(item.count)
                })

                const dataChart = {
                    labels: labels,
                    datasets: [{
                        label: 'Số đơn đặt hàng',
                        data: data,
                        fill: true,
                        borderColor: '#ff6384',
                        tension: 0.1,
                        backgroundColor: 'rgba(255, 99, 132, 0.15)'
                    }]
                };
                const config = {
                    type: 'line',
                    data: dataChart,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Số lượng đơn đặt hàng'
                            }
                        }
                    }
                }
                const myChart = new Chart(countCartChartElement, config);
                
            }
        })
    }


    function handleRevenueChart() {
        $.ajax({
            url: "./ajax/index.php",
            type: 'get',
            data: {
                action: 'get-revenue-for-chart',
            },
            dataType: 'json',
            success: function(result) {

                console.log(result)

                let labelsRevenueChart = []
                let dataRevenue = []

                $.each(result, function(index, item) {
                    labelsRevenueChart.push(item.date)
                    dataRevenue.push(item.total)
                })

                const dataRevenueChart = {
                    labels: labelsRevenueChart,
                    datasets: [{
                        label: 'Doanh thu',
                        data: dataRevenue,
                        fill: true,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                };
                const configRevenueChart = {
                    type: 'line',
                    data: dataRevenueChart,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Doanh thu toàn thời gian'
                            }
                        }
                    }
                }
                const myChart = new Chart(revenueChartElement, configRevenueChart);

            }
        })
    }

    function handleBestSellerProductChart() {
        $.ajax({
            url: "./ajax/index.php",
            type: 'get',
            data: {
                action: 'get-data-bestseller-product-for-chart',
            },
            dataType: 'json',
            success: function(result) {
                let labelsBestSellerProductChart = []
                let dataBestSellerProduct = []

                console.log(result)

                $.each(result, function(index, item) {
                    labelsBestSellerProductChart.push(item.name)
                    dataBestSellerProduct.push(item.count)
                })


                const dataBestSellerProductChart = {
                    labels: labelsBestSellerProductChart,
                    datasets: [{
                        label: 'Sản phẩm bán chạy',
                        data: dataBestSellerProduct,
                        backgroundColor: [
                            '#ff6384',
                            '#e8c3b9',
                            '#ffce56',
                            '#8e5ea2'
                        ],
                        hoverOffset: 4
                    }]
                };
                const configBestSellerProductChart = {
                    type: 'pie',
                    data: dataBestSellerProductChart,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Sản phẩm bán chạy',
                            }
                        }
                    }
                }
                const myChart = new Chart(bestSelletProductChartElement, configBestSellerProductChart);
                
            }
        })
    }


      
    handleRevenueChart()
    handleCartChart()
    handleBestSellerProductChart()
  

  </script>
</body>
</html>