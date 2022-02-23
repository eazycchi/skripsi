<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" aria-current="page" href="#" id="pencacah">Pencacah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" aria-current="page" href="#" id="pengawas">Pegawai</a>
                </li>
            </ul>

            <div class="table-responsive" id="tabel-pencacah">
                <table class="table table-borderless table-hover">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th scope="col">Ranking</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nilai</th>
                            <th scope="col">Akreditasi</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php $i = 1; ?>
                        <?php foreach ($mitra as $m) : ?>
                            <tr align=center>
                                <th><?= $i ?></th>
                                <td><?= $m['nama_lengkap'] ?></td>
                                <td><?= $m['nilai'] ?></td>
                                <?php if ($m['nilai'] > 90) {
                                    echo "<td>Sangat Baik</td>";
                                } elseif ($m['nilai'] > 80) {
                                    echo "<td>Baik</td>";
                                } elseif ($m['nilai'] > 70) {
                                    echo "<td>Cukup</td>";
                                } elseif ($m['nilai'] == 0) {
                                    echo "<td>Belum Ternilai</td>";
                                } else {
                                    echo "<td>Kurang Baik</td>";
                                } ?>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" id="tabel-pengawas" style="display: none;">
                <table class="table table-borderless table-hover">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th scope="col">Ranking</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nilai</th>
                            <th scope="col">Akreditasi</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php $i = 1; ?>
                        <?php foreach ($pegawai as $p) : ?>
                            <tr align=center>
                                <th><?= $i ?></th>
                                <td><?= $p['nama'] ?></td>
                                <td><?= $p['nilai'] ?></td>
                                <?php if ($p['nilai'] > 90) {
                                    echo "<td>Sangat Baik</td>";
                                } elseif ($p['nilai'] > 80) {
                                    echo "<td>Baik</td>";
                                } elseif ($p['nilai'] > 70) {
                                    echo "<td>Cukup</td>";
                                } elseif ($p['nilai'] == 0) {
                                    echo "<td>Belum Ternilai</td>";
                                } else {
                                    echo "<td>Kurang Baik</td>";
                                } ?>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <br>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->