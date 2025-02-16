<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Tiket Per Hari (<?= $bulan ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart3"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Tiket Per Sub Kategori (<?= $bulan ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myBarChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Tiket Per Prioritas (<?= $bulan ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myDoughnutChart3"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold text-primary">
                Ticket Per Status (<?= $bulan ?>)
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myDoughnutChart4"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//Inisialisasi nilai variabel awal
$Thari      = "";
$Jhari      = null;

foreach ($stat_harian as $data) {
    $thari = $data->hari;
    $Thari .= "'$thari'" . ", ";
    $jhari = $data->jumlah;
    $Jhari .= "$jhari" . ", ";
}

$Sbulan     = "";
$Jbulan     = null;

foreach ($stat_sub_bulan as $data) {
    $subul = $data->nama_sub_kategori;
    $Sbulan .= "'$subul'" . ", ";
    $Jumb = $data->total;
    $Jbulan .= "$Jumb" . ", ";
}

$Kbulan  = "";
$BGK     = "";
$Jkon    = null;

foreach ($stat_prio_bulan as $data) {
    if ($data->id_prioritas == 0) {
        $prio = "Not set yet";
    } else {
        $prio    = $data->nama_prioritas;
    }
    $Kbulan .= "'$prio'" . ", ";
    $bg      = $data->warna;
    $BGK    .= "'$bg'" . ", ";
    $jprio   = $data->jumprioritas;
    $Jkon   .= "$jprio" . ", ";
}

$Bstat     = "";
$BGstatB   = "";
$statT     = null;

foreach ($stat_status_bulan as $data) {
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
    $Bstat  .= "'$stat'" . ", ";
    $BGstatB .= "'$bg'" . ", ";
    $jstat   = $data->total;
    $statT  .= "$jstat" . ", ";
}
?>

<script type="text/javascript">
    var Line = document.getElementById("myAreaChart3");
    var myLineChart = new Chart(Line, {
        type: 'line',
        data: {
            labels: [<?= $Thari; ?>],
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
                data: [<?= $Jhari; ?>]
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

    var Bar = document.getElementById("myBarChart2");
    var chart = new Chart(Bar, {
        type: 'horizontalBar',
        data: {
            labels: [<?= $Sbulan; ?>],
            datasets: [{
                label: 'Total Ticket',
                backgroundColor: "#FC8500",
                hoverBackgroundColor: "#FC8500",
                borderColor: "#4e73df",
                data: [<?= $Jbulan; ?>]
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
                    }
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

    var Pie = document.getElementById("myDoughnutChart3");
    var myPieChart = new Chart(Pie, {
        type: 'doughnut',
        data: {
            labels: [<?= $Kbulan; ?>],
            datasets: [{
                data: [<?= $Jkon; ?>],
                backgroundColor: [<?= $BGK; ?>],
                hoverBackgroundColor: [<?= $BGK; ?>],
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

    var Pie = document.getElementById("myDoughnutChart4");
    var myPieChart = new Chart(Pie, {
        type: 'doughnut',
        data: {
            labels: [<?= $Bstat ?>],
            datasets: [{
                data: [<?= $statT; ?>],
                backgroundColor: [<?= $BGstatB; ?>],
                hoverBackgroundColor: [<?= $BGstatB; ?>],
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