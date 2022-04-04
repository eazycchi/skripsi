<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    <?php if ($user['role_id'] == 5) : ?>
        <div class="row">
            <div class="card col mx-2 shadow" style="background-color: #ffffff; ">
                <div class=" row">
                    <div class="col-lg-2 mb-2 mt-2" align=center>
                        <br>
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail" width="100" height="100">
                        <hr>
                        <p class="card-text"><small class="text-muted">User since <?= date("d F Y", strtotime($user['date_created'])); ?></small></p>
                    </div>
                    <div class="col-lg-5 mb-2 mt-2">
                        <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                            <thead>
                                <tr align=center>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>ID Mitra</th>
                                    <td><?= $mitra['id_mitra']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td><?= $mitra['nama_lengkap']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Panggilan</th>
                                    <td><?= $mitra['nama_panggilan']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $mitra['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?= $mitra['alamat']; ?></td>
                                </tr>
                                <tr>
                                    <th>No. Whatsapp</th>
                                    <td><?= $mitra['no_wa']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-5 mb-2 mt-2">
                        <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                            <thead>
                                <tr align=center>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>No. Telkomsel</th>
                                    <td><?= $mitra['no_tsel']; ?></td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan Utama</th>
                                    <td><?= $mitra['pekerjaan_utama']; ?></td>
                                </tr>
                                <tr>
                                    <th>Kompetensi</th>
                                    <td><?= $mitra['kompetensi']; ?></td>
                                </tr>
                                <tr>
                                    <th>Bahasa</th>
                                    <td><?= $mitra['bahasa']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nilai Setiap Kegiatan</th>
                                    <td><a href="<?= base_url('kegiatan/details_mitra_kegiatan/') . $mitra['id_mitra']; ?>" class="badge badge-primary">Pilih kegiatan</a></td>
                                </tr>
                                <tr>
                                    <th>Nilai Keseluruhan</th>
                                    <td><b><?= $mitra['nilai']; ?></b>
                                        <?php if ($mitra['nilai'] == 0) {
                                            echo " (Belum ternilai)";
                                        }
                                        ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-3">
            <div class="card mx-2 col p-2" style="background-color: #ffffff; color:#00264d;">
                <h4 align=center>Daftar Kegiatan yang Diikuti oleh <?= $mitra['nama_lengkap']; ?></h4>
                <hr>
                <div class=" table-responsive">
                    <table class="table table-borderless table-hover" id="mydata">
                        <thead style="background-color: #00264d; color:#e6e6e6;">
                            <tr align=center>
                                <th scope="col">No.</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #ffffff; color: #00264d;">
                            <?php $now = (time());
                            $i = 1; ?>
                            <?php foreach ($kegiatan as $k) : ?>
                                <tr align=center>
                                    <td><?= $i ?></th>
                                    <td><?= $k['nama'] ?></td>
                                    <td><?= date("d F Y", $k['start']) ?></td>
                                    <td><?= date("d F Y", $k['finish']) ?></td>
                                    <?php if ($now < $k['start']) : ?>
                                        <td><a class="badge badge-warning">belum mulai</a></td>
                                    <?php elseif ($now > $k['finish']) : ?>
                                        <td><a class="badge badge-danger">selesai</a></td>
                                    <?php else : ?>
                                        <td><a class="badge badge-primary">sedang berjalan</a></td>
                                    <?php endif; ?>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php elseif ($user['role_id'] == 4) : ?>
        <div class="row">
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <div class="row">
                    <div class="col-lg-2 mt-2" align=center>
                        <hr>
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail" width="100" height="100">
                        <hr>
                    </div>
                    <div class="col-lg-10 mt-2">
                        <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                            <thead>
                                <tr align=center>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td><?= $pegawai['nama']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $user['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Since</th>
                                    <td><?= date("d F Y", strtotime($user['date_created'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                    <tbody align="center">
                        <tr>
                            <th>Jumlah Kegiatan</th>
                            <th>Nilai Rata-rata</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="h1 mb-0 font-weight-bold text-gray-800"><?= $jmlKegiatan; ?></div>
                            </td>
                            <td>
                                <div class="h1 mb-0 font-weight-bold text-gray-800"><?= $nilai; ?></div>
                                <?php if ($nilai == 0) {
                                    echo "<br>(Belum ternilai)";
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row my-3">
            <div class="card mx-2 col p-2" style="background-color: #ffffff; color:#00264d;">
                <h4 align=center>Daftar Kegiatan yang Diikuti oleh <?= $pegawai['nama']; ?></h4>
                <hr>
                <div class=" table-responsive">
                    <table class="table table-borderless table-hover" id="mydata">
                        <thead style="background-color: #00264d; color:#e6e6e6;">
                            <tr align=center>
                                <th scope="col">No.</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #ffffff; color: #00264d;">
                            <?php $now = (time());
                            $i = 1; ?>
                            <?php foreach ($kegiatan as $k) : ?>
                                <tr align=center>
                                    <td><?= $i ?></th>
                                    <td><?= $k['nama'] ?></td>
                                    <td><?= date("d F Y", $k['start']) ?></td>
                                    <td><?= date("d F Y", $k['finish']) ?></td>
                                    <?php if ($now < $k['start']) : ?>
                                        <td><a class="badge badge-warning">belum mulai</a></td>
                                    <?php elseif ($now > $k['finish']) : ?>
                                        <td><a class="badge badge-danger">selesai</a></td>
                                    <?php else : ?>
                                        <td><a class="badge badge-primary">sedang berjalan</a></td>
                                    <?php endif; ?>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php elseif ($user['role_id'] == 3) : ?>
        <div class="row">
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <div class="row">
                    <div class="col-lg-2 mt-2" align=center>
                        <hr>
                        <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail" width="100" height="100">
                        <hr>
                    </div>
                    <div class="col-lg-10 mt-2">
                        <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                            <thead>
                                <tr align=center>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td><?= $pegawai['nama']; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $user['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>Since</th>
                                    <td><?= date("d F Y", strtotime($user['date_created'])); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                    <tbody align="center">
                        <tr>
                            <th>Jumlah Pegawai</th>
                            <th>Jumlah Mitra</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="h1 mb-0 font-weight-bold text-gray-800"><?= $jmlPegawai; ?></div>
                            </td>
                            <td>
                                <div class="h1 mb-0 font-weight-bold text-gray-800"><?= $jmlMitra; ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row my-3">
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                    <tbody align="center">
                        <tr>
                            <th>Jumlah Kegiatan Berlangsung</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $kegiatan['current']; ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                    <tbody align="center">
                        <tr>
                            <th>Jumlah Kegiatan Selesai</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $kegiatan['done']; ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card shadow mx-2 col" style="background-color: #ffffff; color:#00264d;">
                <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                    <tbody align="center">
                        <tr>
                            <th>Jumlah Kegiatan Akan Datang</th>
                        </tr>
                        <tr>
                            <td>
                                <div class="h3 mb-0 font-weight-bold text-gray-800"><?= $kegiatan['next']; ?></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="card mx-2 col p-2" style="background-color: #ffffff; color:#00264d;">
                <h4 align=center>Daftar Kegiatan yang Dibuat oleh <?= $pegawai['nama']; ?></h4>
                <hr>
                <div class=" table-responsive">
                    <table class="table table-borderless table-hover" id="mydata">
                        <thead style="background-color: #00264d; color:#e6e6e6;">
                            <tr align=center>
                                <th scope="col">No.</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Jumlah<br>Pengawas</th>
                                <th scope="col">Jumlah<br>Mitra</th>
                                <th scope="col">Target<br>Responden</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #ffffff; color: #00264d;">
                            <?php $now = (time());
                            $i = 1; ?>
                            <?php foreach ($kegiatan['daftar'] as $k) : ?>
                                <tr align=center>
                                    <td><?= $i ?></th>
                                    <td><?php if ($now > $k['finish']) : ?>
                                            <a href="<?= base_url('kegiatan/detailKegiatan/') . $k['id'] ?>"><?= $k['nama']; ?></a>
                                        <?php else :  ?>
                                            <?= $k['nama']; ?>
                                        <?php endif;  ?>
                                    </td>
                                    <td><?= $k['k_pengawas'] ?></td>
                                    <td><?= $k['k_pencacah'] ?></td>
                                    <td><?= $k['target_responden'] ?></td>
                                    <td><?= date("d F Y", $k['start']) ?></td>
                                    <td><?= date("d F Y", $k['finish']) ?></td>
                                    <?php if ($now < $k['start']) : ?>
                                        <td><a class="badge badge-warning">belum mulai</a></td>
                                    <?php elseif ($now > $k['finish']) : ?>
                                        <td><a class="badge badge-danger">selesai</a></td>
                                    <?php else : ?>
                                        <td><a class="badge badge-primary">sedang berjalan</a></td>
                                    <?php endif; ?>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->