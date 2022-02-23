<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg-10" style="color:#00264d;">
            <form action="" method="post">
                <div class="form-group row">
                    <label for="id_mitra" class="col-sm-2 col-form-label">ID Mitra</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id_mitra" name="id_mitra" value="<?= $mitra['id_mitra']; ?>" readonly>
                        <?= form_error('id_mitra', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $mitra['nama_lengkap']; ?>">
                        <?= form_error('nama_lengkap', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_panggilan" class="col-sm-2 col-form-label">Nama panggilan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="<?= $mitra['nama_panggilan']; ?>">
                        <?= form_error('nama_panggilan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="email" value="<?= $mitra['email']; ?>" readonly>
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $mitra['alamat']; ?>">
                        <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_hp" class="col-sm-2 col-form-label">No. HP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $mitra['no_hp']; ?>">
                        <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_wa" class="col-sm-2 col-form-label">No. WA</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_wa" name="no_wa" value="<?= $mitra['no_wa']; ?>">
                        <?= form_error('no_wa', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_tsel" class="col-sm-2 col-form-label">No. Telkomsel</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="no_tsel" name="no_tsel" value="<?= $mitra['no_tsel']; ?>">
                        <?= form_error('no_tsel', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_utama" class="col-sm-2 col-form-label">Pekerjaan utama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pekerjaan_utama" name="pekerjaan_utama" value="<?= $mitra['pekerjaan_utama']; ?>">
                        <?= form_error('pekerjaan_utama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kompetensi" class="col-sm-2 col-form-label">Kompetensi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kompetensi" name="kompetensi" value="<?= $mitra['kompetensi']; ?>">
                        <?= form_error('kompetensi', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bahasa" class="col-sm-2 col-form-label">Bahasa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bahasa" name="bahasa" value="<?= $mitra['bahasa']; ?>">
                        <?= form_error('bahasa', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->