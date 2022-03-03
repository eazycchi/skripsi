<style>
    .error {
        color: red;
        font-size: 1rem;
        position: relative;
        line-height: 1;
        width: 100%;
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-lg">
            <?= form_error('sensus', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newsensusModal">Tambahkan Sensus Baru</a>

            <div class="table-responsive">
                <table class="table table-borderless table-hover" id="mydata">
                    <thead style="background-color: #00264d; color:#e6e6e6;">
                        <tr align=center>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Start</th>
                            <th scope="col">Finish</th>
                            <th scope="col">Jumlah Pengawas</th>
                            <th scope="col">Jumlah Pencacah</th>
                            <th scope="col">Action</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff; color: #00264d;">
                        <?php $i = 1; ?>
                        <?php foreach ($sensus as $s) : ?>
                            <?php $now = (time()); ?>
                            <tr align=center>
                                <th scope="row"><?= $i; ?></th>
                                <?php if ($now > $s['start']) : ?>
                                    <td><a href="<?= base_url('kegiatan/detailKegiatan/') . $s['id'] ?>"><?= $s['nama']; ?></a></td>
                                <?php else :  ?>
                                    <td><?= $s['nama']; ?></td>
                                <?php endif;  ?>
                                <td><?= date('d F Y', $s['start']); ?></td>
                                <td><?= date('d F Y', $s['finish']); ?></td>
                                <td><?= $s['k_pengawas']; ?></td>
                                <td><?= $s['k_pencacah']; ?></td>
                                <td>
                                    <?php if ($now > $s['start']) : ?>
                                        <a class="badge badge-secondary">tambah pengawas</a>
                                        <a class="badge badge-secondary">tambah pencacah</a>
                                    <?php else : ?>
                                        <a href="<?= base_url('kegiatan/tambah_pengawas/') . $s['id']; ?>" class="badge badge-success">tambah pengawas</a>
                                        <a href="<?= base_url('kegiatan/tambah_pencacah/') . $s['id']; ?>" class="badge badge-info">tambah pencacah</a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('kegiatan/editsensus/') . $s['id']; ?>" class="badge badge-primary">edit</a>
                                    <a href="<?= base_url('kegiatan/deletesensus/') . $s['id']; ?>" class="badge badge-danger">delete</a>
                                </td>


                                <?php if ($now < $s['start']) : ?>
                                    <td><a class="badge badge-warning">belum mulai</a></td>
                                <?php elseif ($now > $s['finish']) : ?>
                                    <td><a class="badge badge-danger">selesai</a></td>
                                <?php else : ?>
                                    <td><a class="badge badge-primary">sedang berjalan</a></td>
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
<div class="modal fade" id="newsensusModal" tabindex="-1" role="dialog" aria-labelledby="newsensusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsensusModalLabel">Tambahkan Survei Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('kegiatan/sensus') ?>" method="post" id="modalSurveiSensus">
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" id="start" name="start" placeholder="Tanggal Mulai">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" id="finish" name="finish" placeholder="Tanggal Selesai">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="k_pengawas" name="k_pengawas" placeholder="Jumlah Pengawas">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="k_pencacah" name="k_pencacah" placeholder="Jumlah Pencacah">
                    </div>
                    <div class="form-group">
                        <select name="ob" id="ob" class="form-control">
                            <option value="">Satuan Honor</option>
                            <option value="1">Orang Bulan (OB)</option>
                            <option value="0">Selain OB</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="honor" name="honor" placeholder="Nilai Honor">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>