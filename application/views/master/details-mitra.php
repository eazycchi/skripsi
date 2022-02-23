<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('message'); ?>
    <div class="row">
        <div class="col-lg-6 mb-5">
            <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                <thead>
                    <tr align=center>

                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <th>Picture</th>
                        <td><img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail" alt="Responsive image" width="100" height="100"></td>
                    </tr>
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
                </tbody>
            </table>
        </div>

        <div class="col-lg-6 mb-5">
            <table class="table table-borderless" style="background-color: #ffffff; color:#00264d;">
                <thead>
                    <tr align=center>

                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <th>No. Whatsapp</th>
                        <td><?= $mitra['no_wa']; ?></td>
                    </tr>
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
                        <th>Status</th>
                        <?php if ($mitra['is_active'] == 1) : ?>
                            <td><i class="fas fa-check" style="color:yellowgreen" title="OK"></i>
                            </td>
                        <?php else : ?>
                            <td><i class="fas fa-times" style="color:red" title="Suspended"></i>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th>Nilai</th>
                        <td><a href="<?= base_url('kegiatan/details_mitra_kegiatan/') . $mitra['id_mitra']; ?>" class="badge badge-primary">Pilih kegiatan</a></td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
    <br>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->