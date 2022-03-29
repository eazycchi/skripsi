<!DOCTYPE html>
<html lang="en">
<?php setlocale(LC_ALL, 'id-ID', 'id_ID'); ?>

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?= base_url('assets/img/BPS.png'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Laporan Kegiatan <?= $kegiatan['nama']; ?></title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            color: #000000;
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
            <h3 align="center">Laporan <?= $kegiatan['nama']; ?></h3 align=" center">
            <div class="row">
                <div class="col mx-5 mt-3">
                    <p align="justify">
                        <span class="tab"></span>Berhubungan dengan berakhirnya kegiatan <?= $kegiatan['nama']; ?>, BPS Kabupaten Jember
                        melampirkan pihak-pihak yang terlibat dalam kegiatan yang dilaksanakan pada :
                    </p>
                    <table class="mx-5" align="justify">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td>tanggal mulai</td>
                                <td>: <?= strftime("%d %B %Y", $kegiatan['start']); ?></td>
                            </tr>
                            <tr>
                                <td>tanggal selesai</td>
                                <td>: <?= strftime("%d %B %Y", $kegiatan['finish']); ?></td>
                            </tr>
                            <tr>
                                <td>wilayah</td>
                                <td>: Kabupaten Jember</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <p align="justify">
                        <span class="tab"></span>Demikian lampiran ini kami sampaikan. Atas perhatian dan keterlibatan Saudara, kami ucapkan terima kasih.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Posisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <!-- Operator seksi -->
                            <tr align="center">
                                <td><?= $i;
                                    $i++ ?></td>
                                <td align="left"><?= $operator['nama']; ?></td>
                                <td>Ketua Pelaksana</td>
                            </tr>
                            <!-- Pengawas -->
                            <?php foreach ($pengawas as $p) : ?>
                                <tr align="center">
                                    <td><?= $i ?></td>
                                    <td align="left"><?= $p['nama']; ?></td>
                                    <td>Pengawas</td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                            <!-- Pencacah -->
                            <?php foreach ($pencacah as $p) : ?>
                                <tr align="center">
                                    <td><?= $i ?></td>
                                    <td align="left"><?= $p['nama']; ?></td>
                                    <td>Pencacah</td>
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
                <table style="width: 85%;" align="center">
                    <tbody align="center">
                        <tr>
                            <th>Ketua Pelaksana</th>
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
                            <th><?= $operator['nama']; ?></th>
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
    window.print();
</script>