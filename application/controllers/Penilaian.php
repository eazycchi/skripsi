<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in_user();
        $this->load->model('Penilaian_model');
    }

    public function index()
    {
        $data['title'] = 'Isi Penilaian Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $email = $data['user']['email'];

        $sql_nama = "SELECT nama FROM pegawai WHERE email LIKE '$email' UNION (SELECT nama_lengkap as nama FROM mitra WHERE email LIKE '$email')";
        $data['nama'] = implode($this->db->query($sql_nama)->row_array());

        $sql_nip = "SELECT nip FROM pegawai WHERE email LIKE '$email' UNION (SELECT id_mitra as nip FROM mitra WHERE email LIKE '$email')";
        $nip = implode($this->db->query($sql_nip)->row_array());

        $data['nip'] = $nip;
        // var_dump($nip);
        // die;

        $sqlkegiatan = "SELECT all_kegiatan_pengawas.*, kegiatan.* FROM all_kegiatan_pengawas INNER JOIN kegiatan ON all_kegiatan_pengawas.kegiatan_id = kegiatan.id WHERE all_kegiatan_pengawas.id_pengawas = $nip";
        $data['kegiatan'] = $this->db->query($sqlkegiatan)->result_array();

        // $data['pengawas'] = $nama;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/index', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function penilaianpengawas()
    {
        $data['title'] = 'Isi Penilaian Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $email = $data['user']['email'];

        $sql_nama = "SELECT nama FROM pegawai WHERE email LIKE '$email' UNION (SELECT nama_lengkap as nama FROM mitra WHERE email LIKE '$email')";
        $data['nama'] = implode($this->db->query($sql_nama)->row_array());

        $sql_id_mitra = "SELECT id_mitra FROM mitra WHERE email LIKE '$email' UNION (SELECT nip as id_mitra FROM pegawai WHERE email LIKE '$email')";
        $id_mitra = implode($this->db->query($sql_id_mitra)->row_array());

        $data['id_mitra'] = $id_mitra;

        // var_dump($data['id_mitra']);
        // die;

        $sqlkegiatan = "SELECT all_kegiatan_pencacah.*, kegiatan.* FROM all_kegiatan_pencacah INNER JOIN kegiatan ON all_kegiatan_pencacah.kegiatan_id = kegiatan.id WHERE all_kegiatan_pencacah.id_mitra = $id_mitra";
        $data['kegiatan'] = $this->db->query($sqlkegiatan)->result_array();

        // $data['pengawas'] = $nama;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/penilaian-pengawas', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function penilaianpengawas2()
    {
        $data['title'] = 'Isi Penilaian Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $email = $data['user']['email'];

        $sql_nama = "SELECT nama FROM pegawai WHERE email LIKE '$email' UNION (SELECT nama_lengkap as nama FROM mitra WHERE email LIKE '$email')";
        $data['nama'] = implode($this->db->query($sql_nama)->row_array());

        $sql_id_penilai = "SELECT id_mitra as id_penilai FROM mitra WHERE email LIKE '$email' UNION (SELECT nip as id_penilai FROM pegawai WHERE email LIKE '$email')";
        $id_penilai = implode($this->db->query($sql_id_penilai)->row_array());

        $data['id_penilai'] = $id_penilai;

        // var_dump($data['id_mitra']);
        // die;

        $sqlkegiatan = "SELECT all_kegiatan_pengawas.*, kegiatan.* FROM all_kegiatan_pengawas INNER JOIN kegiatan ON all_kegiatan_pengawas.kegiatan_id = kegiatan.id WHERE all_kegiatan_pengawas.id_pengawas = $id_penilai";
        $data['kegiatan'] = $this->db->query($sqlkegiatan)->result_array();

        // $data['pengawas'] = $nama;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/penilaian-pengawas2', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function penilaianpengawas3()
    {
        $data['title'] = 'Isi Penilaian Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $email = $data['user']['email'];

        $sql_nama = "SELECT nama FROM pegawai WHERE email LIKE '$email'";
        $data['nama'] = implode($this->db->query($sql_nama)->row_array());

        $sql_id_penilai = "SELECT nip as id_penilai FROM pegawai WHERE email LIKE '$email'";
        $id_penilai = implode($this->db->query($sql_id_penilai)->row_array());

        $data['id_penilai'] = $id_penilai;

        // var_dump($data['id_mitra']);
        // die;

        $sqlkegiatan = "SELECT kegiatan.* FROM kegiatan WHERE created_by = $id_penilai";
        $data['kegiatan'] = $this->db->query($sqlkegiatan)->result_array();

        // $data['pengawas'] = $nama;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/penilaian-pengawas2', $data);
        $this->load->view('template/footer');
    }

    public function daftar_pencacah($kegiatan_id, $nip)
    {
        $data['title'] = 'Daftar Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqldaftarpencacah = "SELECT all_kegiatan_pencacah.*, mitra.nama_lengkap FROM all_kegiatan_pencacah INNER JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_pengawas = $nip";
        $data['kegiatan'] = $this->db->query($sqldaftarpencacah)->result_array();

        $data['nama_kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/daftar-pencacah', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function daftar_pengawas($kegiatan_id, $nip)
    {
        $data['title'] = 'Daftar Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqldaftarpengawas = "SELECT all_kegiatan_pencacah.*, pegawai.nama FROM all_kegiatan_pencacah INNER JOIN pegawai ON all_kegiatan_pencacah.id_pengawas = pegawai.nip WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $nip";
        $data['kegiatan'] = $this->db->query($sqldaftarpengawas)->result_array();

        $data['nama_kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/daftar-pengawas', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function daftar_pengawas2($kegiatan_id, $nip)
    {
        $data['title'] = 'Daftar Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqldaftarpengawas = "SELECT all_kegiatan_pengawas.*, pegawai.nama FROM all_kegiatan_pengawas INNER JOIN pegawai ON all_kegiatan_pengawas.id_pengawas = pegawai.nip WHERE all_kegiatan_pengawas.kegiatan_id = $kegiatan_id AND NOT all_kegiatan_pengawas.id_pengawas = $nip";
        $data['kegiatan'] = $this->db->query($sqldaftarpengawas)->result_array();

        $data['nama_kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/daftar-pengawas', $data);
        $this->load->view('template/footer');
    }

    public function isi_nilai($kegiatan_id, $id_mitra)
    {
        $data['title'] = 'Isi Nilai Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $kegiatan_id = $data['kegiatan']['id'];

        $data['mitra'] = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();
        $id_mitra = $data['mitra']['id_mitra'];

        $data['all_kegiatan_pencacah'] = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $kegiatan_id, 'id_mitra' => $id_mitra])->row_array();


        $sql_kriteria = "SELECT * FROM kriteria WHERE target='pencacah' ORDER BY id ASC";
        $data['kriteria'] = $this->db->query($sql_kriteria)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/isi-nilai', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function isinilaipengawas($kegiatan_id, $nip)
    {
        $data['title'] = 'Isi Nilai Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $kegiatan_id = $data['kegiatan']['id'];

        $data['pengawas'] = $this->db->get_where('pegawai', ['nip' => $nip])->row_array();
        $nip = $data['pengawas']['nip'];

        $data['all_kegiatan_pengawas'] = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $kegiatan_id, 'id_pengawas' => $nip])->row_array();


        $sql_kriteria = "SELECT * FROM kriteria WHERE target='pengawas' ORDER BY id ASC";
        $data['kriteria'] = $this->db->query($sql_kriteria)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/isi-nilai-pengawas', $data);
        $this->load->view('template/footer');
    }

    public function changenilai()
    {
        $all_kegiatan_pencacah_id = $this->input->post('allkegiatanpencacahId');
        $kriteria_id = $this->input->post('kriteriaId');
        $nilai = $this->input->post('nilaiId');

        $data = [
            'all_kegiatan_pencacah_id' => $all_kegiatan_pencacah_id,
            'kriteria_id' => $kriteria_id,
            'nilai' => $nilai
        ];

        $data2 = [
            'all_kegiatan_pencacah_id' => $all_kegiatan_pencacah_id,
            'kriteria_id' => $kriteria_id
        ];

        $result = $this->db->get_where('all_penilaian', $data2);

        if ($result->num_rows() < 1) {
            $this->db->insert('all_penilaian', $data);
        } else {
            $query = "UPDATE all_penilaian SET nilai = $nilai WHERE all_kegiatan_pencacah_id = $all_kegiatan_pencacah_id  AND kriteria_id = $kriteria_id";
            $this->db->query($query);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Nilai changed!</div>');

        // $kegiatan_id = $this->input->post('kegiatanId');
        // $id_mitra = $this->input->post('mitraId');
        // $kriteria_id = $this->input->post('kriteriaId');
        // $nilai = $this->input->post('nilaiId');

        // $data = [
        //     'kegiatan_id' => $kegiatan_id,
        //     'id_mitra' => $id_mitra,
        //     'kriteria_id' => $kriteria_id,
        //     'nilai' => $nilai
        // ];

        // $data2 = [
        //     'kegiatan_id' => $kegiatan_id,
        //     'id_mitra' => $id_mitra,
        //     'kriteria_id' => $kriteria_id
        // ];

        // $result = $this->db->get_where('all_penilaian', $data2);

        // if ($result->num_rows() < 1) {
        //     $this->db->insert('all_penilaian', $data);
        // } else {
        //     $query = "UPDATE all_penilaian SET nilai = $nilai WHERE kegiatan_id = $kegiatan_id AND id_mitra = $id_mitra AND kriteria_id = $kriteria_id";
        //     $this->db->query($query);
        // }
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Nilai changed!</div>');
    }

    //tambahan mochi
    public function changenilaipengawas()
    {
        $all_kegiatan_pengawas_id = $this->input->post('allkegiatanpengawasId');
        $id_pengawas = $this->input->post('pengawasId');
        $id_penilai = $this->input->post('penilaiId');
        $kriteria_id = $this->input->post('kriteriaId');
        $nilai = $this->input->post('nilaiId');

        $data = [
            'all_kegiatan_pengawas_id' => $all_kegiatan_pengawas_id,
            'id_pengawas' => $id_pengawas,
            'id_penilai' => $id_penilai,
            'kriteria_id' => $kriteria_id,
            'nilai' => $nilai
        ];

        $data2 = [
            'all_kegiatan_pengawas_id' => $all_kegiatan_pengawas_id,
            'id_penilai' => $id_penilai,
            'kriteria_id' => $kriteria_id
        ];

        $result = $this->db->get_where('penilaian_pengawas', $data2);

        if ($result->num_rows() < 1) {
            $this->db->insert('penilaian_pengawas', $data);
        } else {
            $query = "UPDATE penilaian_pengawas SET nilai = $nilai WHERE all_kegiatan_pengawas_id = $all_kegiatan_pengawas_id  AND id_pengawas = $id_pengawas AND id_penilai = $id_penilai AND kriteria_id = $kriteria_id";
            $this->db->query($query);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Nilai changed!</div>');
    }

    public function pilihkegiatan()
    {
        $data['title'] = 'Cetak Hasil Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        if ($data['user']['role_id'] == 5) {

            $mitra = $this->db->get_where('mitra', ['email' => $this->session->userdata('email')])->row_array();

            $id_mitra = $mitra['id_mitra'];

            $data['id_mitra'] = $id_mitra;

            $sql = "SELECT kegiatan.*, all_kegiatan_pencacah.id_pengawas FROM kegiatan JOIN all_kegiatan_pencacah ON kegiatan.id = all_kegiatan_pencacah.kegiatan_id WHERE all_kegiatan_pencacah.id_mitra = $id_mitra";
            $data['kegiatan'] = $this->db->query($sql)->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('penilaian/cetak-mitra', $data);
            $this->load->view('template/footer');
        } else if ($data['user']['role_id'] == 4) {

            // $nama = $data['user']['nama'];
            $email = $data['user']['email'];

            $sql_nip = "SELECT pegawai.nip FROM pegawai JOIN user WHERE pegawai.email LIKE '$email' UNION (SELECT mitra.id_mitra as nip FROM mitra JOIN user WHERE mitra.email LIKE '$email')";
            $nip = implode($this->db->query($sql_nip)->row_array());

            $data['nip'] = $nip;

            $sql = "SELECT kegiatan.* FROM kegiatan JOIN all_kegiatan_pengawas ON kegiatan.id = all_kegiatan_pengawas.kegiatan_id WHERE all_kegiatan_pengawas.id_pengawas = $nip";

            $data['kegiatan'] = $this->db->query($sql)->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('penilaian/cetak-pilih-kegiatan', $data);
            $this->load->view('template/footer');
        } else {
            $seksi = $data['user']['seksi_id'];
            $email = $data['user']['email'];

            $sql_nip = "SELECT pegawai.nip FROM pegawai JOIN user WHERE pegawai.email LIKE '$email'";
            $nip = implode($this->db->query($sql_nip)->row_array());

            $data['nip'] = $nip;


            $sql = "SELECT kegiatan.* FROM kegiatan WHERE seksi_id = $seksi";

            $data['kegiatan'] = $this->db->query($sql)->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('penilaian/cetak-pilih-kegiatan', $data);
            $this->load->view('template/footer');
        }
    }

    // tambahan mochi
    public function pilihkegiatan2()
    {
        $data['title'] = 'Cetak Hasil Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $role = $this->session->userdata('role_id');
        $cekmitra = $this->db->get_where('mitra', ['email' => $this->session->userdata('email')])->row_array();
        if ($cekmitra > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf halaman "Cetak Hasil Pengawas" tidak dapat dimuat untuk mitra!</div>');
            redirect('penilaian/pilihkegiatan');
        }
        if ($role == 4) {

            $pegawai = $this->db->get_where('pegawai', ['email' => $this->session->userdata('email')])->row_array();

            $id_pegawai = $pegawai['nip'];

            $data['id_pengawas'] = $id_pegawai;

            $sql = "SELECT kegiatan.*, all_kegiatan_pengawas.id_pengawas FROM kegiatan JOIN all_kegiatan_pengawas ON kegiatan.id = all_kegiatan_pengawas.kegiatan_id WHERE all_kegiatan_pengawas.id_pengawas = $id_pegawai";
            $data['kegiatan'] = $this->db->query($sql)->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('penilaian/cetak-pengawas', $data);
            $this->load->view('template/footer');
        } else {
            $seksi = $data['user']['seksi_id'];
            $email = $data['user']['email'];

            $sql_nip = "SELECT pegawai.nip FROM pegawai JOIN user WHERE pegawai.email LIKE '$email' AND user.role_id = $role";
            $nip = implode($this->db->query($sql_nip)->row_array());

            $data['nip'] = $nip;

            $sql = "SELECT kegiatan.* FROM kegiatan WHERE seksi_id = $seksi";

            $data['kegiatan'] = $this->db->query($sql)->result_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('penilaian/cetak-pilih-kegiatan2', $data);
            $this->load->view('template/footer');
        }
    }

    public function pilihmitra($kegiatan_id, $nip)
    {
        $data['title'] = 'Cetak Hasil Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT mitra.* FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_pengawas = $nip";

        $data['nip'] = $nip;
        $data['mitra'] = $this->db->query($sql)->result_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/cetak-pilih-mitra', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function pilihmitra2($kegiatan_id)
    {
        $data['title'] = 'Cetak Hasil Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT mitra.* FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id";

        $data['mitra'] = $this->db->query($sql)->result_array();
        $data['nip'] = "OS";

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/cetak-pilih-mitra', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function pilihpengawas($kegiatan_id)
    {
        $data['title'] = 'Cetak Hasil Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT pegawai.* FROM all_kegiatan_pengawas JOIN pegawai ON all_kegiatan_pengawas.id_pengawas = pegawai.nip WHERE all_kegiatan_pengawas.kegiatan_id = $kegiatan_id";

        // $data['nip'] = $nip;
        $data['pengawas'] = $this->db->query($sql)->result_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/cetak-pilih-pengawas', $data);
        $this->load->view('template/footer');
    }

    public function download($kegiatan_id, $nip, $id_mitra)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // var_dump($nip);
        // die();
        if ($nip == "OS") {
            $sql_nip = "SELECT id_pengawas FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id AND id_mitra=$id_mitra";
            $nip = implode($this->db->query($sql_nip)->row_array());
        }
        $sql_all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id AND id_mitra = $id_mitra";
        $all_kegiatan_pencacah_id = implode($this->db->query($sql_all_kegiatan_pencacah_id)->row_array());

        $sqlpenilaian = "SELECT all_penilaian.*, kriteria.nama, subkriteria.konversi FROM all_penilaian LEFT JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_penilaian.all_kegiatan_pencacah_id = $all_kegiatan_pencacah_id ORDER BY kriteria_id ASC";
        $data['penilaian'] = $this->db->query($sqlpenilaian)->result_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $data['mitra'] = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $sqlpenilai = "SELECT nama, nip FROM pegawai WHERE nip = $nip UNION (SELECT mitra.nama_lengkap as nama, mitra.id_mitra as nip FROM mitra WHERE id_mitra = $nip)";
        $data['penilai'] = $this->db->query($sqlpenilai)->row_array();

        $sqlrow = "SELECT count(*) FROM all_penilaian WHERE all_kegiatan_pencacah_id = $all_kegiatan_pencacah_id";
        $row = implode($this->db->query($sqlrow)->row_array());

        $role_id = $data['user']['role_id'];

        // var_dump($role_id);
        // die;

        if ($row < $jumlah_kriteria) {
            if ($role_id == 5) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Penilaian belum lengkap!</div>');
                redirect('penilaian/pilihkegiatan');
            } elseif ($role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Penilaian belum lengkap!</div>');
                redirect('penilaian/pilihmitra/' . $kegiatan_id . '/' . $nip);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Penilaian belum lengkap!</div>');
                redirect('penilaian/pilihmitra2/' . $kegiatan_id . '/' . $nip);
            }
        } else {
            $this->load->view('penilaian/laporan', $data);
        }
    }

    // tambahan mochi
    public function download2($kegiatan_id, $id_pengawas)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql_all_kegiatan_pengawas_id = "SELECT id FROM all_kegiatan_pengawas WHERE kegiatan_id = $kegiatan_id AND id_pengawas = $id_pengawas";
        $all_kegiatan_pengawas_id = implode($this->db->query($sql_all_kegiatan_pengawas_id)->row_array());

        // menentukan jumlah nilai yang seharusnya diterima pengawas
        $jml_kriteria = $this->db->get_where('kriteria', ['target' => 'pengawas'])->num_rows();
        $jml_mitra = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $kegiatan_id, 'id_pengawas' => $id_pengawas])->num_rows();
        $jml_pgws = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $kegiatan_id])->num_rows(); // sebelum dikurangi diri sendiri
        $jml_pengawas = $jml_pgws - 1; //dikurangi dengan dirinya sendiri
        $os = $this->db->get_where('pegawai', ['nip' => $id_pengawas])->row_array();
        $os_email = $this->db->get_where('user', ['email' => $os['email']])->row_array();
        if ($os_email['role_id'] == 3) {
            $jml_os = 0;
        } else {
            $jml_os = 1;
        }
        $os_pgws = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $kegiatan_id])->result_array();
        foreach ($os_pgws as $op) {
            $os_pgws_nip = $this->db->get_where('pegawai', ['nip' => $op['id_pengawas']])->row_array();
            $os_pgws_email = $this->db->get_where('user', ['email' => $os_pgws_nip['email']])->row_array();
            if ($os_pgws_email['role_id'] == 3) {
                $jml_os = 0;
            }
        }
        $pengali = ($jml_mitra + $jml_pengawas + $jml_os);
        $jml_seharusnya = $jml_kriteria * ($pengali);

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $data['pengawas'] = $this->db->get_where('pegawai', ['nip' => $id_pengawas])->row_array();

        $sqlrow = "SELECT count(*) FROM penilaian_pengawas WHERE all_kegiatan_pengawas_id = $all_kegiatan_pengawas_id";
        $row = implode($this->db->query($sqlrow)->row_array());

        $role_id = $data['user']['role_id'];

        if ($row < $jml_seharusnya) {
            if ($role_id == 4) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Penilaian belum lengkap!</div>');
                redirect('penilaian/pilihkegiatan2');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Penilaian belum lengkap!</div>');
                redirect('penilaian/pilihpengawas/' . $kegiatan_id);
            }
        } else {
            $data['krit'] = $this->db->get_where('kriteria', ['target' => 'pengawas'])->result_array();
            $laporan = $this->nilai_laporan2($id_pengawas, $pengali, $jml_kriteria);
            $data['kriteria'] = $laporan['kriteria'];
            $data['nilai']  = $laporan['nilai'];
            $kegiatan = $data['kegiatan']['nama'];
            $data['penilai'] = "Staff $kegiatan";
            $data['rata2'] = $laporan['rata2'];
            $data['akreditasi'] = $laporan['akreditasi'];

            $this->load->view('penilaian/laporan2', $data);
        }
    }

    // tambahan mochi
    public function nilai_laporan2($id_pengawas, $pengali, $jml_kriteria)
    {
        $kriteria = $this->db->get_where('kriteria', ['target' => 'pengawas'])->result_array();
        $total_nilai = 0;
        foreach ($kriteria as $kr) {
            $id = $kr['id'];
            $nama = $kr['nama'];
            $querynilai = "SELECT SUM(nilai) FROM penilaian_pengawas WHERE id_pengawas = $id_pengawas AND kriteria_id = $id";
            $totalnilai = (int) implode($this->db->query($querynilai)->row_array());
            $nilai5 = $totalnilai / $pengali;
            $queryminsub = "SELECT min(nilai) FROM subkriteria";
            $minsub =  (int) implode($this->db->query($queryminsub)->row_array());
            $querymaxsub = "SELECT max(nilai) FROM subkriteria";
            $maxsub =  (int) implode($this->db->query($querymaxsub)->row_array());
            $nilai =  50 + (50 * ($nilai5 - $minsub) / ($maxsub - $minsub));
            $data['kriteria'][$nama] = $nama;
            $data['nilai'][$id] = round($nilai, 2);
            $data['akreditasi'][$id] = $this->akreditasi($nilai);
            $total_nilai = $total_nilai + $nilai;
        }
        $data['rata2'] = round($total_nilai / $jml_kriteria, 2);
        $data['akreditasi']['rata'] =  $this->akreditasi($total_nilai / $jml_kriteria);
        return $data;
    }

    //tambahan mochi
    public function akreditasi($nilai)
    {
        if ($nilai > 90) {
            return "Sangat Baik";
        } elseif ($nilai > 80) {
            return "Baik";
        } elseif ($nilai > 70) {
            return "Cukup";
        } else {
            return "Kurang Baik";
        }
    }

    public function arsip()
    {
        $data['title'] = 'Arsip';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT * FROM mitra WHERE is_active = '0'";
        $data['mitra'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/arsip', $data);
        $this->load->view('template/footer');
    }

    public function arsip_pilihkegiatan($id_mitra)
    {
        $data['title'] = 'Daftar kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT kegiatan.* FROM kegiatan JOIN all_kegiatan_pencacah ON kegiatan.id = all_kegiatan_pencacah.kegiatan_id WHERE all_kegiatan_pencacah.id_mitra = $id_mitra";
        $data['kegiatan'] = $this->db->query($sql)->result_array();

        $data['id_mitra'] = $id_mitra;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('penilaian/arsip-pilihkegiatan', $data);
        $this->load->view('template/footer');
    }
}
