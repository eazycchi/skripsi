<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-6">
            <?= form_error('hitung', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <div class="row" align=center style="color:#00264d;">
                <div class="col-sm">
                   <h3>Kegiatan: <?= $kegiatan_id['nama'];?></h3>
                </div>
                
            </div>
            <hr>

            <h3 style="color: #00264d;">Tabel Ranking</h3>
            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th>Ranking</th>
                            <th>Mitra</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php $i = 1; ?>
                        <?php foreach ($hq as $col) : ?>
                            <tr align=center>
                                <td>
                                    <?= $i; ?>
                                </td>
                                <td>
                                    <?= $col['nama_lengkap']; ?>
                                </td>
                                <td>
                                    <?= number_format($col['tot'], 4); ?>
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