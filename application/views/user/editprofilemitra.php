<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">

        <?= form_open_multipart('user/editprofilemitra'); ?>
        <div class="row" style=" color:#00264d;">
            <div class=" col-lg-6">
                <div class="form-group row">
                    <div class="col-sm-3">Picture</div>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_mitra" class="col-sm-3 col-form-label">ID Mitra</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="id_mitra" name="id_mitra" value="<?= $mitra['id_mitra']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $mitra['nama_lengkap']; ?>">
                        <?= form_error('nama_lengkap', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_panggilan" class="col-sm-3 col-form-label">Nama Panggilan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_panggilan" name="nama_panggilan" value="<?= $mitra['nama_panggilan']; ?>">
                        <?= form_error('nama_panggilan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $mitra['alamat']; ?>">
                        <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>





            </div>

            <div class="col-lg-6">

                <div class="form-group row">
                    <label for="no_wa" class="col-sm-3 col-form-label">No. Whatsapp</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="no_wa" name="no_wa" value="<?= $mitra['no_wa']; ?>">
                        <?= form_error('no_wa', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_tsel" class="col-sm-3 col-form-label">No. Telkomsel</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="no_tsel" name="no_tsel" value="<?= $mitra['no_tsel']; ?>">
                        <?= form_error('no_tsel', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pekerjaan_utama" class="col-sm-3 col-form-label">Pekerjaan Utama</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="pekerjaan_utama" name="pekerjaan_utama" value="<?= $mitra['pekerjaan_utama']; ?>">
                        <?= form_error('pekerjaan_utama', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kompetensi" class="col-sm-3 col-form-label">Kompetensi</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="kompetensi" name="kompetensi" value="<?= $mitra['kompetensi']; ?>">
                        <?= form_error('kompetensi', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bahasa" class="col-sm-3 col-form-label">Bahasa</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bahasa" name="bahasa" value="<?= $mitra['bahasa']; ?>">
                        <?= form_error('bahasa', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <br>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->