<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6">

            <?= $this->session->flashdata('message'); ?>
            <div class="row" style="color:#00264d;">
                <div class="col-lg-6">
                    <h4>Kegiatan: <?= $kegiatan['nama']; ?></h4>
                    <h4>Mitra: <?= $id_mitra ?></h4>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover" id="mydata">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>

                            <th scope="col">Kriteria</th>
                            <th scope="col">Nilai</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">


                        <?php $i = 1; ?>
                        <?php foreach ($nilai as $n) : ?>
                            <tr align=center>
                                <td align="left"><?= $n['nama']; ?></td>

                                <?php if ($n['nilai'] == 5) : ?>
                                    <td> 90 </td>
                                <?php elseif ($n['nilai'] == 4) : ?>
                                    <td> 80 </td>
                                <?php elseif ($n['nilai'] == 3) : ?>
                                    <td> 70 </td>
                                <?php elseif ($n['nilai'] == 2) : ?>
                                    <td> 60 </td>
                                <?php else : ?>
                                    <td> 50 </td>
                                <?php endif; ?>

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