 <!-- Footer -->
 <footer class="sticky-footer" style="background-color: #b3b3b3;">
     <div class="container my-auto">
         <div class="copyright text-center my-auto" style="color:  #003366">
             <span>Copyright &copy; MSA 2021</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

 <!-- Page level plugins -->
 <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

 <!-- Page level custom scripts -->
 <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>

 <script src="<?= base_url('assets/'); ?>jquery-ui/jquery-ui.js"></script>
 <script src="<?= base_url('assets/'); ?>jquery-ui/jquery-ui.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.5.1/snap.svg-min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.5.0/frappe-gantt.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.5.0/frappe-gantt.min.js.map"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>




 <script>
     $('.alert').alert().delay(2000).slideUp('slow');

     $('.custom-file-input').on('change', function() {
         let fileName = $(this).val().split('\\').pop();
         $(this).next('.custom-file-label').addClass("selected").html(fileName);
     });


     $('.form-access-input').on('click', function() {
         const menuId = $(this).data('menu');
         const roleId = $(this).data('role');

         $.ajax({
             url: "<?= base_url('admin/changeaccess') ?>",
             type: 'post',
             data: {
                 menuId: menuId,
                 roleId: roleId
             },
             success: function() {
                 document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
             }
         });

     });

     $('.form-pencacah-input').on('click', function() {
         const kegiatanId = $(this).data('kegiatan');
         const mitraId = $(this).data('pencacah');

         $.ajax({
             url: "<?= base_url('kegiatan/changepencacah') ?>",
             type: 'post',
             data: {
                 kegiatanId: kegiatanId,
                 mitraId: mitraId
             },
             success: function() {
                 document.location.href = "<?= base_url('kegiatan/tambah_pencacah/'); ?>" + kegiatanId;
             }
         });

     });

     $('.form-pengawas-input').on('click', function() {
         const kegiatanId = $(this).data('kegiatan');
         const nip = $(this).data('pengawas');

         $.ajax({
             url: "<?= base_url('kegiatan/changepengawas') ?>",
             type: 'post',
             data: {
                 kegiatanId: kegiatanId,
                 nip: nip
             },
             success: function() {
                 document.location.href = "<?= base_url('kegiatan/tambah_pengawas/'); ?>" + kegiatanId;
             }
         });

     });

     $('.form-pengawas-mitra-input').on('click', function() {
         const kegiatanId = $(this).data('kegiatan');
         const id_mitra = $(this).data('pengawas');

         $.ajax({
             url: "<?= base_url('kegiatan/changepengawas_mitra') ?>",
             type: 'post',
             data: {
                 kegiatanId: kegiatanId,
                 id_mitra: id_mitra
             },
             success: function() {
                 document.location.href = "<?= base_url('kegiatan/tambah_pengawas_mitra/'); ?>" + kegiatanId;
             }
         });

     });

     $('.form-pencacahpengawas-input').on('click', function() {
         const kegiatanId = $(this).data('kegiatan');
         const nip = $(this).data('pengawas');
         const id_mitra = $(this).data('pencacah');

         $.ajax({
             url: "<?= base_url('kegiatan/changepencacahpengawas') ?>",
             type: 'post',
             data: {
                 kegiatanId: kegiatanId,
                 nip: nip,
                 id_mitra: id_mitra,
             },
             success: function() {
                 document.location.href = "<?= base_url('kegiatan/tambah_pencacah_pengawas/'); ?>" + kegiatanId + '/' + nip;
             }
         });

     });

     $('.form-nilai-input').on('click', function() {
         const allkegiatanpencacahId = $(this).data('all_kegiatan_pencacah_id');
         const kegiatanId = $(this).data('kegiatan_id');
         const mitraId = $(this).data('id_mitra');
         const kriteriaId = $(this).data('kriteria');
         const nilaiId = $(this).data('nilai');

         $.ajax({
             url: "<?= base_url('penilaian/changenilai') ?>",
             type: 'post',
             data: {
                 allkegiatanpencacahId: allkegiatanpencacahId,
                 kriteriaId: kriteriaId,
                 nilaiId: nilaiId

             },
             success: function() {
                 document.location.href = "<?= base_url('penilaian/isi_nilai/'); ?>" + kegiatanId + "/" + mitraId;
             }
         });

     });

     $('.form-nilai-pengawas-input').on('click', function() {
         const allkegiatanpengawasId = $(this).data('all_kegiatan_pengawas_id');
         const kegiatanId = $(this).data('kegiatan_id');
         const pengawasId = $(this).data('nip');
         const penilaiId = $(this).data('id_penilai');
         const kriteriaId = $(this).data('kriteria');
         const nilaiId = $(this).data('nilai');

         $.ajax({
             url: "<?= base_url('penilaian/changenilaipengawas') ?>",
             type: 'post',
             data: {
                 allkegiatanpengawasId: allkegiatanpengawasId,
                 pengawasId: pengawasId,
                 penilaiId: penilaiId,
                 kriteriaId: kriteriaId,
                 nilaiId: nilaiId

             },
             success: function() {
                 document.location.href = "<?= base_url('penilaian/isinilaipengawas/'); ?>" + kegiatanId + "/" + pengawasId;
             }
         });

     });

     //  $('.form-nilai-input').on('click', function() {
     //      const kegiatanId = $(this).data('kegiatan_id');
     //      const mitraId = $(this).data('id_mitra');
     //      const kriteriaId = $(this).data('kriteria');
     //      const nilaiId = $(this).data('nilai');

     //      $.ajax({
     //          url: "<= base_url('penilaian/changenilai') ?>",
     //          type: 'post',
     //          data: {
     //              kegiatanId: kegiatanId,
     //              mitraId: mitraId,
     //              kriteriaId: kriteriaId,
     //              nilaiId: nilaiId

     //          },
     //          success: function() {
     //              document.location.href = "<= base_url('penilaian/isi_nilai/'); ?>" + kegiatanId + "/" + mitraId;
     //          }
     //      });

     //  });
 </script>


 <script>
     $(document).ready(function() {
         $('#mydata').DataTable({
             paging: true,
             searching: true,
             ordering: true,
             pagingType: "full_numbers"
         });
     });
 </script>

 <script type="text/javascript">
     $(function() {
             $(".datepicker").datepicker({
                     format: 'yyyy-mm-dd',
                     autoclose: true,
                     todayHighlight: true,
                 }

             );
         }

     );
 </script>

 <script>
     $('#pencacah').css('border-radius', '0px')
     $('#pencacah').css('border-top-left-radius', '10px')
     $('#pencacah').css('border-top-right-radius', '10px')
     $('#pengawas').css('border-radius', '0px')
     $('#pengawas').css('border-top-left-radius', '10px')
     $('#pengawas').css('border-top-right-radius', '10px')
     $('#pencacah').css('background-color', '#00264d')
     $('#pengawas').css('background-color', '#fff')
     $('#pencacah').click((e) => {
         $('#pengawas').removeClass('active')
         $(e.target).addClass('active')
         $(e.target).css('background-color', '#00264d')
         $('#pengawas').css('background-color', '#fff')
         $('#tabel-pencacah').css('display', 'block')
         $('#tabel-pengawas').css('display', 'none')
     })
     $('#pengawas').click((e) => {
         $('#pencacah').removeClass('active')
         $(e.target).addClass('active')
         $(e.target).css('background-color', '#00264d')
         $('#pencacah').css('background-color', '#fff')
         $('#tabel-pencacah').css('display', 'none')
         $('#tabel-pengawas').css('display', 'block')
     })
 </script>

 <!-- Validasi modal survei dan sensus -->
 <script>
     $(function() {
         $("#modalSurveiSensus").validate({
             rules: {
                 nama: {
                     required: true,
                     minlength: 6
                 },
                 start: {
                     required: true,
                 },
                 finish: {
                     required: true,
                 },
                 k_pengawas: {
                     required: true,
                     min: 1,
                 },
                 k_pencacah: {
                     required: true,
                     min: 1,
                 },
                 target_responden: {
                     required: true,
                     min: 1,
                 },
                 ob: {
                     required: true,
                 },
                 honor: {
                     required: true,
                     max: 3200000
                 },
                 action: "required"
             },
             messages: {
                 nama: {
                     required: "Kolom tidak boleh kosong",
                     minlength: "Minimal 6 karakter"
                 },
                 start: {
                     required: "Kolom tidak boleh kosong",
                 },
                 finish: {
                     required: "Kolom tidak boleh kosong",
                 },
                 k_pengawas: {
                     required: "Kolom tidak boleh kosong",
                     min: "Nilai harus lebih dari 1"
                 },
                 k_pencacah: {
                     required: "Kolom tidak boleh kosong",
                     min: "Nilai harus lebih dari 1"
                 },
                 target_responden: {
                     required: "Kolom tidak boleh kosong",
                     min: "Nilai harus lebih dari 1"
                 },
                 ob: {
                     required: "Kolom tidak boleh kosong",
                 },
                 honor: {
                     required: "Kolom tidak boleh kosong",
                     max: "Maksimal yang dapat diberikan adalah 3,2 juta"
                 },
                 action: "Kolom tidak boleh kosong"
             }
         });
     });
 </script>

 <script>
     $(function() {
         $("#validasi").validate({
             rules: {
                 role: {
                     required: true,
                 },
                 role_id: {
                     required: true,
                 },
                 seksi_id: {
                     required: true,
                 },
                 email: {
                     required: true,
                 },
                 nama_lengkap: {
                     required: true,
                 },
                 nama_panggilan: {
                     required: true,
                 },
                 alamat: {
                     required: true,
                 },
                 no_hp: {
                     required: true,
                 },
                 no_wa: {
                     required: true,
                 },
                 no_tsel: {
                     required: true,
                 },
                 pekerjaan_utama: {
                     required: true,
                 },
                 kompetensi: {
                     required: true,
                 },
                 bahasa: {
                     required: true,
                 },
                 nip: {
                     required: true,
                 },
                 nama: {
                     required: true,
                 },
                 jabatan: {
                     required: true,
                 },
                 menu: {
                     required: true,
                 },
                 url: {
                     required: true,
                 },
                 icon: {
                     required: true,
                 },
                 title: {
                     required: true,
                 },
                 action: "required"
             },
             messages: {
                 role: {
                     required: "Kolom tidak boleh kosong",
                 },
                 role_id: {
                     required: "Kolom tidak boleh kosong",
                 },
                 seksi_id: {
                     required: "Kolom tidak boleh kosong",
                 },
                 email: {
                     required: "Kolom tidak boleh kosong",
                 },
                 nama_lengkap: {
                     required: "Kolom tidak boleh kosong",
                 },
                 nama_panggilan: {
                     required: "Kolom tidak boleh kosong",
                 },
                 alamat: {
                     required: "Kolom tidak boleh kosong",
                 },
                 no_hp: {
                     required: "Kolom tidak boleh kosong",
                 },
                 no_wa: {
                     required: "Kolom tidak boleh kosong",
                 },
                 no_tsel: {
                     required: "Kolom tidak boleh kosong",
                 },
                 pekerjaan_utama: {
                     required: "Kolom tidak boleh kosong",
                 },
                 kompetensi: {
                     required: "Kolom tidak boleh kosong",
                 },
                 bahasa: {
                     required: "Kolom tidak boleh kosong",
                 },
                 nip: {
                     required: "Kolom tidak boleh kosong",
                 },
                 nama: {
                     required: "Kolom tidak boleh kosong",
                 },
                 jabatan: {
                     required: "Kolom tidak boleh kosong",
                 },
                 menu: {
                     required: "Kolom tidak boleh kosong",
                 },
                 url: {
                     required: "Kolom tidak boleh kosong",
                 },
                 icon: {
                     required: "Kolom tidak boleh kosong",
                 },
                 title: {
                     required: "Kolom tidak boleh kosong",
                 },
                 action: "Kolom tidak boleh kosong"
             }
         });
     });
 </script>
 </body>

 </html>