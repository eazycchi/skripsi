<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan <?= $kegiatan['nama']; ?></title>
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
        <h2 align="center">Laporan <?= $kegiatan['nama']; ?></h2>
        <h2 align="center">BPS Kota Jember</h2>
        <hr>
        <p>Berikut adalah daftar pegawai dan mitra yang terlibat dalam <?= $kegiatan['nama']; ?></p>
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
                    <td><?= $i ?></td>
                    <td align="left"><?= $operator['nama']; ?></td>
                    <td>Kepala Survei</td>
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
</body>

</html>

<script>
    window.print();
</script>