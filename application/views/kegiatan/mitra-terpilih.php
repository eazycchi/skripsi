<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <div class="row" style="color:#00264d;">
                <div class="col-lg-4" align=left>
                    <h2><?= $kegiatan['nama']; ?></h2>
                </div>
                <div class="col-lg-4" align=center>
                    <h2>Jumlah = <?= $kuota['kegiatan_id']; ?> / <?= $kegiatan['k_pencacah']; ?></h2>
                </div>
                <div class="col-lg-4" align=right>
                    <a href="<?= base_url('kegiatan/tambah_pencacah/') . $kegiatan['id'] ?>" class="btn btn-primary">Tambah Pencacah</a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <?= form_error('tambah-pencacah', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <div>


                <form method="post" action="">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover" id="mydata">
                            <thead style="background-color: #00264d; color:#e6e6e6;">
                                <tr align=center>
                                    <th scope="col">#</th>
                                    <th scope="col">ID Mitra</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Kompetensi</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody style="background-color: #ffffff; color: #00264d;">
                                <?php $i = 1; ?>
                                <?php foreach ($pencacah as $p) : ?>
                                    <tr align=center>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-pencacah-input" type="checkbox" <?= check_pencacah($kegiatan['id'], $p['id_mitra']); ?> data-kegiatan="<?= $kegiatan['id']; ?>" data-pencacah="<?= $p['id_mitra']; ?>">
                                            </div>
                                        </td>
                                        <td><?= $p['id_mitra']; ?></td>
                                        <td><?= $p['nama_lengkap']; ?></td>
                                        <td><?= $p['alamat']; ?></td>
                                        <td><?= $p['kompetensi']; ?></td>

                                        <td>
                                            <a href="<?= base_url('kegiatan/details_kegiatan_mitra/') . $kegiatan['id'] . '/' . $p['id_mitra']; ?>" class="badge badge-primary">kegiatan yang diikuti</a>
                                        </td>

                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>

        </div>

    </div>

    <br>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->