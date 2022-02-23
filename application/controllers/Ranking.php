<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ranking extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Ranking_model');
    }

    public function index()
    {
        $data['title'] = 'Ranking';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('ranking/index', $data);
        $this->load->view('template/footer');
    }


    public function kriteria()
    {
        $data['title'] = 'Data Kriteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->hitung_bobot_kriteria('pencacah');
        $this->hitung_bobot_kriteria('pengawas');


        $sql_pengawas = "SELECT * FROM kriteria WHERE target = 'pengawas' ORDER BY prioritas ASC";
        $data['kriteria_pengawas'] = $this->db->query($sql_pengawas)->result_array();
        $sql_pencacah = "SELECT * FROM kriteria WHERE target = 'pencacah' ORDER BY prioritas ASC";
        $data['kriteria_pencacah'] = $this->db->query($sql_pencacah)->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/kriteria', $data);
            $this->load->view('template/footer');
        } else {
            $jmlkriteria = $this->db->get_where('kriteria', ['target' => $this->input->post('target')])->num_rows();
            $prioritas = $jmlkriteria + 1;
            $data = [
                'nama' => $this->input->post('nama'),
                'prioritas' => $prioritas,
                'bobot' => 1,
                'target' => $this->input->post('target'),
                'deskripsi' => $this->input->post('deskripsi'),
            ];
            $this->db->insert('kriteria', $data);
            $this->hitung_bobot_kriteria($this->input->post('target'));

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New kriteria added!</div>');
            redirect('ranking/kriteria');
        }
    }

    public function editkriteria($id)
    {
        $data['title'] = 'Edit Kriteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['kriteria'] = $this->db->get_where('kriteria', ['id' => $id])->row_array();
        $old_prioritas = $data['kriteria']['prioritas'];

        $data['jumlahkriteria'] = $this->db->get_where('kriteria', ['target' => $data['kriteria']['target']])->num_rows();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('prioritas', 'Prioritas', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/edit-kriteria', $data);
            $this->load->view('template/footer');
        } else {
            $nama = $this->input->post('nama');
            $prioritas = $this->input->post('prioritas');
            $target = $data['kriteria']['target'];
            $deskripsi = $this->input->post('deskripsi');

            //menambahkan otomatisasi prioritas
            if ($prioritas > $old_prioritas) {
                $query = "SELECT * FROM kriteria WHERE prioritas > $old_prioritas AND prioritas < $prioritas+1 AND target = '$target' ORDER BY prioritas ASC;";
            } else {
                $query = "SELECT * FROM kriteria WHERE prioritas < $old_prioritas AND prioritas > $prioritas-1 AND target = '$target' ORDER BY prioritas ASC;";
            }
            $cekPrioritas = $this->db->query($query)->result_array();

            foreach ($cekPrioritas as $prior) {
                if ($prioritas > $old_prioritas) {
                    $new_prioritas = $prior['prioritas'] - 1;
                } else {
                    $new_prioritas = $prior['prioritas'] + 1;
                }

                $prior_id = $prior['id'];
                $kueri = "UPDATE kriteria SET prioritas = $new_prioritas  WHERE `kriteria`.`id` = $prior_id;";

                $a = 0;
                for ($i = $new_prioritas; $i <= $data['jumlahkriteria']; $i++) {
                    $a = $a + 1 / $i;
                }
                $bobot = $a / $data['jumlahkriteria'];
                $kueri2 = "UPDATE kriteria SET bobot = $bobot  WHERE `kriteria`.`id` = $prior_id;";
                $this->db->query($kueri);
                $this->db->query($kueri2);
            }

            $b = 0;
            for ($i = $prioritas; $i <= $data['jumlahkriteria']; $i++) {
                $b = $b + 1 / $i;
            }

            $bobot1 = $b / $data['jumlahkriteria'];
            $data['kriteria'] = $this->db->get_where('kriteria', ['id' => $id])->row_array();
            $this->db->set('nama', $nama);
            $this->db->set('prioritas', $prioritas);
            $this->db->set('bobot', $bobot1);
            $this->db->set('deskripsi', $deskripsi);
            $this->db->where('id', $id);
            $this->db->update('kriteria');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kriteria has been updated!</div>');
            redirect('ranking/kriteria');
        }
    }

    function deletekriteria($id)
    {
        $data['kriteria'] = $this->db->get_where('kriteria', ['id' => $id])->row_array();
        $prioritas = $data['kriteria']['prioritas'];
        $target = $data['kriteria']['target'];
        $query = "SELECT * FROM kriteria WHERE prioritas > $prioritas AND target = '$target' ORDER BY prioritas ASC;";
        $cekPrioritas = $this->db->query($query)->result_array();
        foreach ($cekPrioritas as $prior) {
            $new_prioritas = $prior['prioritas'] - 1;
            $prior_id = $prior['id'];
            $kueri = "UPDATE kriteria SET prioritas = $new_prioritas  WHERE `kriteria`.`id` = $prior_id;";
            $this->db->query($kueri);
        }

        $this->Ranking_model->deletekriteria($id);
        $this->hitung_bobot_kriteria('pencacah');
        $this->hitung_bobot_kriteria('pengawas');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kriteria has been deleted!</div>');
        redirect('ranking/kriteria');
    }

    function hitung_bobot_kriteria($target)
    {
        $query = "SELECT * FROM kriteria WHERE target = '$target' ORDER BY prioritas ASC;";
        $kriteria = $this->db->query($query)->result_array();
        $jmlkriteria = $this->db->get_where('kriteria', ['target' => $target])->num_rows();


        foreach ($kriteria as $prior) {
            $kriteria_id = $prior['id'];
            $prioritas = $prior['prioritas'];

            $a = 0;
            for ($i = $prioritas; $i <= $jmlkriteria; $i++) {
                $a = $a + 1 / $i;
            }
            $bobot = $a / $jmlkriteria;
            $kueri2 = "UPDATE kriteria SET bobot = $bobot  WHERE `kriteria`.`id` = $kriteria_id;";
            $this->db->query($kueri2);
        }
    }

    function subkriteria()
    {
        $data['title'] = 'Data Subkriteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql_subkriteria = "SELECT * FROM subkriteria ORDER BY prioritas ASC";
        $data['subkriteria'] = $this->db->query($sql_subkriteria)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('ranking/subkriteria', $data);
        $this->load->view('template/footer');
    }

    function hitung_bobot_subkriteria($prioritas)
    {

        $jumlah_subkriteria = $this->db->get('subkriteria')->num_rows();
        $a = 0;
        for ($i = $prioritas; $i <= $jumlah_subkriteria; $i++) {
            $a = $a + 1 / $i;
        }

        $bobot = $a / $jumlah_subkriteria;

        $this->db->set('bobot', $bobot);
        $this->db->where('prioritas', $prioritas);
        $this->db->update('subkriteria');

        redirect('ranking/subkriteria');
    }

    function pilih_kegiatan()
    {
        $data['title'] = 'Pilih Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT * FROM kegiatan";

        $data['kegiatan'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('ranking/pilih-kegiatan', $data);
        $this->load->view('template/footer');
    }

    function pilih_kegiatan_nilai_akhir()
    {
        $data['title'] = 'Pilih Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT * FROM kegiatan";

        $data['kegiatan'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('ranking/pilih-kegiatan-nilai-akhir', $data);
        $this->load->view('template/footer');
    }

    function data_awal($kegiatan_id)
    {
        $data['title'] = 'Perhitungan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $k_pencacah = "SELECT k_pencacah FROM kegiatan WHERE id = $kegiatan_id";
        $result_k_pencacah = implode($this->db->query($k_pencacah)->row_array());

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $jumlah_penilaian = ((int) $result_k_pencacah) * $jumlah_kriteria;

        $all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id";

        $sql_jumlah_penilaian_sementara = "SELECT * FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($all_kegiatan_pencacah_id)";

        $jumlah_penilaian_sementara = $this->db->query($sql_jumlah_penilaian_sementara)->num_rows();

        // var_dump($jumlah_penilaian);
        // die;

        if ($jumlah_penilaian_sementara == $jumlah_penilaian) {

            $data['kegiatan_id'] = $kegiatan_id;

            $sql_kriteria = "SELECT * FROM kriteria WHERE target = 'pencacah' ORDER BY id";
            $data['kriteria'] = $this->db->query($sql_kriteria)->result();

            $sql_id_mitra = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE kegiatan_id = $kegiatan_id ORDER BY id_mitra";
            $data['id_mitra'] = $this->db->query($sql_id_mitra)->result();

            $hasil = $this->Ranking_model->data_awal($kegiatan_id);
            $data['rekap'] = $hasil['data'];



            // var_dump($data['rekap']);
            // die;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/hitung-data-awal', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Selesaikan penilaian terlebih dahulu!</div>');
            redirect('ranking/pilih_kegiatan');
        }
    }

    function normalized($kegiatan_id)
    {
        $data['title'] = 'Perhitungan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $k_pencacah = "SELECT k_pencacah FROM kegiatan WHERE id = $kegiatan_id";
        $result_k_pencacah = implode($this->db->query($k_pencacah)->row_array());

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $jumlah_penilaian = ((int) $result_k_pencacah) * $jumlah_kriteria;

        $all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id";

        $sql_jumlah_penilaian_sementara = "SELECT * FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($all_kegiatan_pencacah_id)";

        $jumlah_penilaian_sementara = $this->db->query($sql_jumlah_penilaian_sementara)->num_rows();

        // var_dump($jumlah_penilaian);
        // die;

        if ($jumlah_penilaian_sementara == $jumlah_penilaian) {

            $data['kegiatan_id'] = $kegiatan_id;

            $sql_kriteria = "SELECT * FROM kriteria WHERE target = 'pencacah' ORDER BY id";
            $data['kriteria'] = $this->db->query($sql_kriteria)->result();

            $sql_id_mitra = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE kegiatan_id = $kegiatan_id ORDER BY id_mitra";
            $data['id_mitra'] = $this->db->query($sql_id_mitra)->result();

            $hasil = $this->Ranking_model->normalized($kegiatan_id);
            $data['rekap'] = $hasil['data'];



            // var_dump($data['rekap']);
            // die;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/hitung-normalized', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Selesaikan penilaian terlebih dahulu!</div>');
            redirect('ranking/pilih_kegiatan');
        }
    }

    function utility($kegiatan_id)
    {
        $data['title'] = 'Perhitungan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $k_pencacah = "SELECT k_pencacah FROM kegiatan WHERE id = $kegiatan_id";
        $result_k_pencacah = implode($this->db->query($k_pencacah)->row_array());

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $jumlah_penilaian = ((int) $result_k_pencacah) * $jumlah_kriteria;

        $all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id";

        $sql_jumlah_penilaian_sementara = "SELECT * FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($all_kegiatan_pencacah_id)";

        $jumlah_penilaian_sementara = $this->db->query($sql_jumlah_penilaian_sementara)->num_rows();

        if ($jumlah_penilaian_sementara == $jumlah_penilaian) {

            $data['jumlah_kriteria'] = $jumlah_kriteria;

            $data['kegiatan_id'] = $kegiatan_id;

            $sql_kriteria = "SELECT * FROM kriteria WHERE target = 'pencacah' ORDER BY id";
            $data['kriteria'] = $this->db->query($sql_kriteria)->result();

            // $sql_id_mitra = "SELECT all_penilaian.id_mitra, mitra.nama_lengkap, SUM(kriteria.bobot*subkriteria.bobot) as bobot 
            // FROM all_penilaian JOIN mitra ON all_penilaian.id_mitra = mitra.id_mitra JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai
            // WHERE all_penilaian.kegiatan_id = $kegiatan_id GROUP BY all_penilaian.id_mitra ORDER BY all_penilaian.id_mitra";
            // $data['id_mitra'] = $this->db->query($sql_id_mitra)->result();

            $sql_id_mitra = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE kegiatan_id = $kegiatan_id ORDER BY id_mitra";
            $data['id_mitra'] = $this->db->query($sql_id_mitra)->result();

            $hasil = $this->Ranking_model->utility($kegiatan_id);
            $data['rekap'] = $hasil['data'];

            // var_dump($data['rekap']);
            // die;

            // $total_utility = $this->Ranking_model->total_utility($kegiatan_id);
            // $data['total'] = $total_utility;

            // var_dump($data['id_mitra']);
            // die;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/hitung-utility', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Selesaikan penilaian terlebih dahulu!</div>');
            redirect('ranking/pilih_kegiatan');
        }
    }

    function total($kegiatan_id)
    {
        $data['title'] = 'Perhitungan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $k_pencacah = "SELECT k_pencacah FROM kegiatan WHERE id = $kegiatan_id";
        $result_k_pencacah = implode($this->db->query($k_pencacah)->row_array());

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $jumlah_penilaian = ((int) $result_k_pencacah) * $jumlah_kriteria;

        $all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id";

        $sql_jumlah_penilaian_sementara = "SELECT * FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($all_kegiatan_pencacah_id)";

        $jumlah_penilaian_sementara = $this->db->query($sql_jumlah_penilaian_sementara)->num_rows();

        if ($jumlah_penilaian_sementara == $jumlah_penilaian) {

            $data['jumlah_kriteria'] = $jumlah_kriteria;

            $data['kegiatan_id'] = $kegiatan_id;

            $data['pn'] = $result_k_pencacah;

            $sql_kriteria = "SELECT * FROM kriteria WHERE target = 'pencacah' ORDER BY id";
            $data['kriteria'] = $this->db->query($sql_kriteria)->result_array();

            $sql_id_mitra = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap, sum(all_penilaian.t_bobot) as tot FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra JOIN all_penilaian ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE kegiatan_id = $kegiatan_id GROUP BY all_penilaian.all_kegiatan_pencacah_id ORDER BY id_mitra";
            $data['id_mitra'] = $this->db->query($sql_id_mitra)->result_array();

            $hasil = $this->Ranking_model->total($kegiatan_id);
            $data['rekap'] = $hasil['data'];





            // var_dump($data['rekap']);
            // die;
            // $test = "SELECT sum("

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/hitung-total', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Selesaikan penilaian terlebih dahulu!</div>');
            redirect('ranking/pilih_kegiatan');
        }
    }



    function nilai_akhir($kegiatan_id)
    {
        $data['title'] = 'Perhitungan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $k_pencacah = "SELECT k_pencacah FROM kegiatan WHERE id = $kegiatan_id";
        $result_k_pencacah = implode($this->db->query($k_pencacah)->row_array());

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $jumlah_penilaian = ((int) $result_k_pencacah) * $jumlah_kriteria;

        $all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id";

        $sql_jumlah_penilaian_sementara = "SELECT * FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($all_kegiatan_pencacah_id)";

        $jumlah_penilaian_sementara = $this->db->query($sql_jumlah_penilaian_sementara)->num_rows();

        if ($jumlah_penilaian_sementara == $jumlah_penilaian) {

            $hasil = $this->Ranking_model->total($kegiatan_id);
            $data['rekap'] = $hasil['data'];

            $q = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap, sum(all_penilaian.t_bobot) as tot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY all_penilaian.all_kegiatan_pencacah_id ORDER BY tot DESC";



            $data['hq'] = $this->db->query($q)->result_array();
            $data['kegiatan_id'] = $kegiatan_id;
            // var_dump($kegiatan_id);
            // die;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/hitung-nilai-akhir', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Selesaikan penilaian terlebih dahulu!</div>');
            redirect('ranking/pilih_kegiatan');
        }
    }

    function nilai_akhir_ranking($kegiatan_id)
    {
        $data['title'] = 'Ranking';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $k_pencacah = "SELECT k_pencacah FROM kegiatan WHERE id = $kegiatan_id";
        $result_k_pencacah = implode($this->db->query($k_pencacah)->row_array());

        $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();

        $jumlah_penilaian = ((int) $result_k_pencacah) * $jumlah_kriteria;

        $all_kegiatan_pencacah_id = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id";

        $sql_jumlah_penilaian_sementara = "SELECT * FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($all_kegiatan_pencacah_id)";

        $jumlah_penilaian_sementara = $this->db->query($sql_jumlah_penilaian_sementara)->num_rows();

        if ($jumlah_penilaian_sementara == $jumlah_penilaian) {

            $hasil = $this->Ranking_model->total($kegiatan_id);
            $data['rekap'] = $hasil['data'];

            $q = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap, sum(all_penilaian.t_bobot) as tot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY all_penilaian.all_kegiatan_pencacah_id ORDER BY tot DESC";

            $data['hq'] = $this->db->query($q)->result_array();
            $data['kegiatan_id'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('ranking/ranking', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Selesaikan penilaian terlebih dahulu!</div>');
            redirect('ranking/pilih_kegiatan_nilai_akhir');
        }
    }
}
