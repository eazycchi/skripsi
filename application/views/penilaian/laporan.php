<!DOCTYPE html>
<html lang="en">
<?php setlocale(LC_ALL, 'id-ID', 'id_ID'); ?>

<head>
    <meta charset="utf-8">
    <title>Laporan Penilaian Kinerja <?= $kegiatan['nama']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Arial";
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

        .tab {
            display: inline-block;
            margin-left: 40px;
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Header Surat -->
        <div class="row">
            <div class="col-2" align="center">
                <img src="<?= base_url('assets/img/BPS.png') ?>" alt="Logo BPS" style="width: 140px;">
            </div>
            <div class="col mx-4 py-2" align="left">
                <h2><b>BADAN PUSAT STATISTIK</b></h2>
                <h3><b>KABUPATEN JEMBER</b></h3>
            </div>
            <hr style="border:0; border-top:3px double #000;">
        </div>
        <div class="row">
            <div class="col" align="right">
                Jember, <?= strftime("%d %B %Y", $kegiatan['finish']); ?>
            </div>
        </div>

        <!-- Isi Surat -->
        <div class="row my-3">
            <h3 align="center">Laporan Penilaian Kinerja Mitra</h3 align=" center">
            <div class="row">
                <div class="col mx-5 mt-3">
                    <p align="justify">
                        <span class="tab"></span>Sehubungan dengan kegiatan <?= $kegiatan['nama']; ?> yang dilaksanakan pada
                        <?= strftime("%d %B %Y", $kegiatan['start']); ?> s/d <?= strftime("%d %B %Y", $kegiatan['finish']); ?>, BPS Kabupaten Jember
                        melaporkan hasil penilaian yang telah dilakukan oleh pengawas kegiatan <?= $kegiatan['nama']; ?> kepada :
                    </p>
                    <table class="mx-5" align="justify">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td>nama mitra</td>
                                <td>: <?= $mitra['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <td>pelaksana</td>
                                <td>: BPS Kabupaten Jember</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="my-2" style="width:40%; margin:auto;">
                        <canvas id="myChart"></canvas>
                    </div>
                    <table class="table" style="width: 75%;">
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
                </div>
            </div>
        </div>

        <!-- Footer Surat -->
        <div class="row">
            <div class="col">
                <table style="width: 80%;" align="center">
                    <tbody align="center">
                        <tr>
                            <th>Pengawas</th>
                            <th>Kepala</th>
                        </tr>
                        <tr>
                            <th><?= $kegiatan['nama']; ?></th>
                            <th>BPS Kabupaten Jember</th>
                        </tr>
                        <tr>
                            <th><br></th>
                            <th><br></th>
                        </tr>
                        <tr>
                            <th><br></th>
                            <th><br></th>
                        </tr>
                        <tr>
                            <th><br></th>
                            <th><br></th>
                        </tr>
                        <tr>
                            <th><br></th>
                            <th><br></th>
                        </tr>
                        <tr>
                            <th><?= $penilai['nama']; ?></th>
                            <th>Arif Joko Sutejo</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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