<script type="text/javascript">
    $(document).ready(function() {
        $("#id_bulan").change(function() {
            // Put an animated GIF image insight of content         
            var data = {
                id_bulan: $("#id_bulan").val()
            };
            $.ajax({
                type: "POST",
                url: "<?= site_url('select/select_bulan') ?>",
                data: data,
                success: function(msg) {
                    $('#div-order2').html(msg);
                }
            });
        });
    });
</script>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Tiket Per Bulan (<?= $tahun ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Tiket Per Sub Kategori (<?= $tahun ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Tiket Per Prioritas (<?= $tahun ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Ticket Per Status (<?= $tahun ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myDoughnutChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<h4 class="mb-3 font-weight-bold text-gray-800">Laporan Bulanan <?= $tahun ?></h4>
<?= form_dropdown('id_bulan', $dd_bulan, $id_bulan, 'id="id_bulan" class="form-control"'); ?><br>
<div id="div-order2"></div>

<?php
//Inisialisasi nilai variabel awal
$bulan      = "";
$Jticket    = null;

foreach ($stat_bulan as $data) {
    $bul        = $data->bulan;
    $bulan     .= "'$bul'" . ", ";
    $Jumt       = $data->jumtiket;
    $Jticket   .= "$Jumt" . ", ";
}

$Tsub     = "";
$Jsub     = null;

foreach ($stat_sub_tahun as $data) {
    $sub    = $data->nama_sub_kategori;
    $Tsub  .= "'$sub'" . ", ";
    $jum    = $data->totalsub;
    $Jsub  .= "$jum" . ", ";
}

$Tprio     = "";
$BGT       = "";
$Jprio     = null;

foreach ($stat_prio_tahun as $data) {
    if ($data->id_prioritas == 0) {
        $prio    = "Not set yet";
    } else {
        $prio    = $data->nama_prioritas;
    }
    $Tprio  .= "'$prio'" . ", ";
    $bg      = $data->warna;
    $BGT    .= "'$bg'" . ", ";
    $jprio   = $data->jumprioritas;
    $Jprio  .= "$jprio" . ", ";
}

$Tstat     = "";
$BGstat    = "";
$Jstat     = null;

foreach ($stat_status_tahun as $data) {
    if ($data->status == 0) {
        $stat = "Ticket Rejected";
        $bg = "#F36F13";
    } else if ($data->status == 1) {
        $stat = "Ticket Submited";
        $bg = "#946038";
    } else if ($data->status == 2) {
        $stat = "Category Changed";
        $bg = "#FFB701";
    } else if ($data->status == 3) {
        $stat = "Assigned to Technician";
        $bg = "#A2B969";
    } else if ($data->status == 4) {
        $stat = "On Process";
        $bg = "#0D95BC";
    } else if ($data->status == 5) {
        $stat = "Pending";
        $bg = "#023047";
    } else if ($data->status == 6) {
        $stat = "Solve";
        $bg = "#2E6095";
    } else if ($data->status == 7) {
        $stat = "Late Finished";
        $bg = "#C13018";
    }
    $Tstat  .= "'$stat'" . ", ";
    $BGstat .= "'$bg'" . ", ";
    $jstat   = $data->total;
    $Jstat  .= "$jstat" . ", ";
}
?>

<script type="text/javascript">
    var Line = document.getElementById("myAreaChart2");
    var myLineChart = new Chart(Line, {
        type: 'line',
        data: {
            labels: [<?= $bulan; ?>],
            datasets: [{
                label: 'Total Ticket',
                lineTension: 0.3,
                backgroundColor: "transparent",
                borderColor: "#209EEB",
                pointRadius: 3,
                pointBackgroundColor: "#209EEB",
                pointBorderColor: "#209EEB",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [<?= $Jticket; ?>]
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                displayColors: false
            },
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            },
            legend: {
                display: false
            }
        }
    });

    var Bar = document.getElementById("myBarChart");
    var chart = new Chart(Bar, {
        type: 'horizontalBar',
        data: {
            labels: [<?= $Tsub; ?>],
            datasets: [{
                label: 'Total Ticket',
                backgroundColor: "#FC8500",
                hoverBackgroundColor: "#FC8500",
                borderColor: "#4e73df",
                data: [<?= $Jsub; ?>]
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                displayColors: false
            },
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                    maxBarThickness: 25,
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    maxBarThickness: 25
                }]
            },
            legend: {
                display: false
            }
        }
    });

    var Pie = document.getElementById("myDoughnutChart");
    var myPieChart = new Chart(Pie, {
        type: 'doughnut',
        data: {
            labels: [<?= $Tprio; ?>],
            datasets: [{
                data: [<?= $Jprio; ?>],
                backgroundColor: [<?= $BGT; ?>],
                hoverBackgroundColor: [<?= $BGT; ?>],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            legend: {
                position: 'right',
            },
            maintainAspectRatio: false,
            tooltips: {
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                caretPadding: 10,
            },
        },
    });

    var Pie = document.getElementById("myDoughnutChart2");
    var myPieChart = new Chart(Pie, {
        type: 'doughnut',
        data: {
            labels: [<?= $Tstat ?>],
            datasets: [{
                data: [<?= $Jstat; ?>],
                backgroundColor: [<?= $BGstat; ?>],
                hoverBackgroundColor: [<?= $BGstat; ?>],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'right'
            },
            tooltips: {
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                caretPadding: 10,
            },
        },
    });
</script>