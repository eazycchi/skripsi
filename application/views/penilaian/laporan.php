<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $kegiatan['nama']; ?> - <?= $mitra['nama_lengkap']; ?> - Laporan Penilaian Kinerja</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 10mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }


        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        table {
            border-collapse: collapse;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page">
        <h2 align="center">Laporan Penilaian Kinerja Mitra</h2>
        <br>
        <h3 align="left">Kegiatan : <?= $kegiatan['nama']; ?> <br> Nama : <?= $mitra['nama_lengkap']; ?></h3>

        <div style="width:40%; margin:auto;">
            <canvas id="myChart"></canvas>
        </div>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kriteria</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($penilaian as $p) : ?>
                    <tr align=center>
                        <td><?= $i ?></td>
                        <td align="left"><?= $p['nama']; ?></td>
                        <td><?= $p['konversi']; ?></td>
                    </tr>
                    <?php $i++; ?>

                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
        <table style="width: 100%;">
            <tr>
                <th align=center>Penilai
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $penilai['nama']; ?>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th align=center>Yang dinilai
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $mitra['nama_lengkap']; ?>
                </th>
            </tr>
        </table>
        <!-- <br>
        <br>
        <br>
        <br>
        <table style="width: 60%;">
            <tr>
                <th align=center><?= $penilai['nama']; ?></th>
                <th align=center><?= $mitra['nama_lengkap']; ?></th>
            </tr>
        </table> -->
    </div>
</body>

</html>

<script>
    var ctx = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [
                <?php
                if (count($penilaian) > 0) {
                    foreach ($penilaian as $data) {
                        echo "'" . $data['nama'] . "',";
                    }
                }
                ?>
            ],
            datasets: [{
                label: 'Kinerja Mitra',
                data: [<?php
                        if (count($penilaian) > 0) {
                            foreach ($penilaian as $data) {

                                echo $data['konversi'] . ", ";
                            }
                        }
                        ?>],
                fill: true,
                backgroundColor: 'rgba(179, 209, 255, 0.4)',
                borderColor: 'rgb(0, 102, 255)',
                pointBackgroundColor: 'rgb(0, 102, 255)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(255, 99, 132)'
            }]
        },
        options: {
            elements: {
                line: {
                    borderWidth: 3
                }
            },
            scales: {
                r: {
                    ticks: {
                        display: true,
                        maxTicksLimit: 6,
                        minTicksLimit: 5
                    },
                    angleLines: {
                        display: false
                    },
                    min: 50,
                    max: 100
                }
            },
            bezierCurve: false,
            animation: false

        },


    });

    window.print();
</script>