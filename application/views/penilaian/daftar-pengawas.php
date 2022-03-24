<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg">

            <?= $this->session->flashdata('message'); ?>
            <div class="row">
                <div class="col-lg-6" style="color:#00264d;">
                    <h2>Kegiatan: <?= $nama_kegiatan['nama']; ?></h2>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover" id="mydata">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>

                            <th scope="col">NIP Pengawas</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">


                        <?php $i = 1; ?>
                        <?php foreach ($kegiatan as $k) : ?>
                            <tr align=center>
                                <td><?= $k['id_pengawas']; ?></td>
                                <td><?= $k['nama']; ?></td>
                                <?php $now = (time()); ?>
                                <td>
                                    <?php if ($now > $nama_kegiatan['finish']) : ?>
                                        <a href="<?= base_url('penilaian/isinilaipengawas/') . $nama_kegiatan['id'] . "/" . $k['id_pengawas'] ?>" class="badge badge-primary">Isi nilai</a>
                                    <?php else : ?>
                                        <a class="badge badge-secondary">Isi nilai</a>
                                    <?php endif; ?>
                                </td>

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