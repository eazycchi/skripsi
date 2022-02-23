<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col">
            <?= form_error('kriteria', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>
            <div class="row" style="color:#00264d;">
                <div class="col-lg-6">
                    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newKriteriaModal">Add New Kriteria</a>
                </div>
                <div class="col-lg-6" align=right>
                    <a href="<?= base_url('ranking/subkriteria'); ?>" class="btn btn-success mb-3">Subkriteria</a>
                </div>
            </div>

            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active font-weight-bold" aria-current="page" href="#" id="pencacah">Pencacah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" aria-current="page" href="#" id="pengawas">Pengawas</a>
                </li>
            </ul>

            <div class="table-responsive" id="tabel-pencacah">
                <table class="table table-borderless table-hover">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Bobot</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php foreach ($kriteria_pencacah as $k) : ?>
                            <tr align=center>
                                <th><?= $k['prioritas']; ?></th>
                                <td align="left"><?= $k['nama']; ?></td>
                                <td align="left"><?= $k['deskripsi']; ?></td>
                                <td><?= number_format($k['bobot'], 4); ?></td>
                                <td>
                                    <!-- <a href="<= base_url('ranking/hitung_bobot_kriteria/') . $k['prioritas']; ?>" class="badge badge-primary">Perbarui bobot</a> -->
                                    <a href="<?= base_url('ranking/editkriteria/') . $k['id']; ?>" class="badge badge-success">edit</a>
                                    <a href="<?= base_url('ranking/deletekriteria/') . $k['id']; ?>" class="badge badge-danger">delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" id="tabel-pengawas" style="display: none;">
                <table class="table table-borderless table-hover">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th scope="col">Prioritas</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Bobot</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php foreach ($kriteria_pengawas as $k) : ?>
                            <tr align=center>
                                <th><?= $k['prioritas']; ?></th>
                                <td align="left"><?= $k['nama']; ?></td>
                                <td align="left"><?= $k['deskripsi']; ?></td>
                                <td><?= number_format($k['bobot'], 4); ?></td>
                                <td>
                                    <!-- <a href="<= base_url('ranking/hitung_bobot_kriteria/') . $k['prioritas']; ?>" class="badge badge-primary">Perbarui bobot</a> -->
                                    <a href="<?= base_url('ranking/editkriteria/') . $k['id']; ?> ?>" class="badge badge-success">edit</a>
                                    <a href="<?= base_url('ranking/deletekriteria/') . $k['id']; ?>" class="badge badge-danger">delete</a>
                                </td>
                            </tr>
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
<div class="modal fade" id="newKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="newKriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newKriteriaModalLabel">Add New Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('ranking/kriteria') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kriteria">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Kriteria">
                    </div>
                    <div class="form-group">
                        <select name="target" id="target" class="form-control">
                            <option value="pencacah">Pencacah</option>
                            <option value="pengawas">Pengawas</option>
                        </select>
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