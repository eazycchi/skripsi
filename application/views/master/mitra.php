<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg">
            <?= form_error('mitra', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <div class="row" align=left style="color:#00264d;">
                <div class="col-sm-4">
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMitraModal">Add New Mitra</a>
                </div>
                <div class="col-sm-4">
                    <a href="" class="btn btn-success mb-3" data-toggle="modal" data-target="#importModal"><i class="fas fa-file-upload"></i> Import Data Mitra</a>
                </div>
                <div class="col-sm-4">
                    <a href="<?= base_url('excel/data_mitra.xlsx') ?>" class="btn btn-danger mb-3"><i class="fas fa-file-download"></i> Download Format Import</a>
                </div>
            </div>



            <div class="table-responsive">
                <table class="table table-borderless table-hover" id="mydata">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th scope="col">#</th>
                            <th scope="col">ID Mitra</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No. Whatsapp</th>
                            <th scope="col">Action</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php $i = 1; ?>
                        <?php foreach ($mitra as $m) : ?>
                            <tr align=center>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $m['id_mitra']; ?></td>
                                <td><?= $m['nama_lengkap']; ?></td>
                                <td><?= $m['email']; ?></td>
                                <td><?= $m['alamat']; ?></td>
                                <td><?= $m['no_wa']; ?></td>
                                <td>
                                    <a href="<?= base_url('master/details_mitra/') . $m['id_mitra']; ?>" class="badge badge-primary">details</a>
                                    <a href="<?= base_url('master/editmitra/') . $m['id_mitra']; ?>" class="badge badge-success">edit</a>
                                    <a href="<?= base_url('master/deletemitra/') . $m['id_mitra']; ?>" class="badge badge-danger">delete</a>
                                </td>
                                <?php if ($m['is_active'] == 1) : ?>
                                    <td>
                                        <i class="fas fa-check" style="color:yellowgreen" title="Active"></i>
                                        <a> | </a>
                                        <a href="<?= base_url('master/deactivated/') . $m['id_mitra']; ?>" class="badge badge-danger">deactivated?</a>

                                    </td>
                                <?php else : ?>
                                    <td>
                                        <i class="fas fa-times" style="color:red" title="Nonactive"></i>
                                        <a> | </a>
                                        <a href="<?= base_url('master/activated/') . $m['id_mitra']; ?>" class="badge badge-success">activated?</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach ?>
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


<!-- Modal -->
<div class="modal fade" id="newMitraModal" tabindex="-1" role="dialog" aria-labelledby="newMitraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMitraModalLabel">Add New Mitra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/mitra') ?>" method="post" id="validasi">
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <input type="text" class="form-control" id="id_mitra" name="id_mitra" placeholder="ID Mitra">
                    </div> -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" placeholder="Nama Panggilan">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_wa" name="no_wa" placeholder="No. Whatsapp">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_tsel" name="no_tsel" placeholder="No. Telkomsel">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="pekerjaan_utama" name="pekerjaan_utama" placeholder="Pekerjaan Utama">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="kompetensi" name="kompetensi" placeholder="Kompetensi">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="bahasa" name="bahasa" placeholder="Bahasa">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Mitra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/import') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="file" class="form-control" name="excel" aria-describedby="sizing-addon2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>