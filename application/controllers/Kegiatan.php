<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in_user();
        $this->load->model('Kegiatan_model');
    }

    // public function index()
    // {
    //     $data['title'] = 'Kegiatan';
    //     $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    //     $this->load->view('template/header', $data);
    //     $this->load->view('template/sidebar', $data);
    //     $this->load->view('template/topbar', $data);
    //     $this->load->view('kegiatan/index', $data);
    //     $this->load->view('template/footer');
    // }

    public function survei()
    {
        $data['title'] = 'Survei';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $pegawai = $this->db->get_where('pegawai', ['email' => $this->session->userdata('email')])->row_array();

        $seksi_id = $data['user']['seksi_id'];
        $queryKegiatan = "SELECT * FROM kegiatan WHERE jenis_kegiatan = 1 AND (seksi_id = $seksi_id OR seksi_id = 5)";
        $role_id = $data['user']['role_id'];

        if ($role_id == 1) {
            $data['survei'] = $this->db->get_where('kegiatan', ['jenis_kegiatan' => 1])->result_array();
        } else {
            $data['survei'] = $this->db->query($queryKegiatan)->result_array();
        }

        $data['seksi'] = $this->db->get('seksi')->result_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('start', 'Start', 'required|trim');
        $this->form_validation->set_rules('finish', 'Finish', 'required|trim');
        $this->form_validation->set_rules('k_pengawas', 'Kuota Pengawas', 'required|trim');
        $this->form_validation->set_rules('k_pencacah', 'Kuota Pencacah', 'required|trim');
        $this->form_validation->set_rules('target_responden', 'Target Responden', 'required|trim');
        $this->form_validation->set_rules('ob', 'OB', 'required|trim');
        $this->form_validation->set_rules('honor', 'Honor', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/survei', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'start' => strtotime($this->input->post('start')),
                'finish' => strtotime($this->input->post('finish')),
                'k_pengawas' => $this->input->post('k_pengawas'),
                'k_pencacah' => $this->input->post('k_pencacah'),
                'target_responden' => $this->input->post('target_responden'),
                'jenis_kegiatan' => '1',
                'seksi_id' => $seksi_id,
                'ob' => $this->input->post('ob'),
                'honor' => $this->input->post('honor'),
                'created_by' => $pegawai['nip'],
            ];

            if (strtotime($this->input->post('finish')) > strtotime($this->input->post('start'))) {
                $this->db->insert('kegiatan', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New survei added!</div>');
                redirect('kegiatan/survei');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Waktu kegiatan salah!</div>');
                redirect('kegiatan/survei');
            }
        }
    }

    public function sensus()
    {
        $data['title'] = 'Sensus';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $pegawai = $this->db->get_where('pegawai', ['email' => $this->session->userdata('email')])->row_array();

        $data['sensus'] = $this->db->get_where('kegiatan', ['jenis_kegiatan' => '2'])->result_array();


        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('start', 'Start', 'required|trim');
        $this->form_validation->set_rules('finish', 'Finish', 'required|trim');
        $this->form_validation->set_rules('k_pengawas', 'Kuota Pengawas', 'required|trim');
        $this->form_validation->set_rules('k_pencacah', 'Kuota Pencacah', 'required|trim');
        $this->form_validation->set_rules('target_responden', 'Target Responden', 'required|trim');
        $this->form_validation->set_rules('ob', 'OB', 'required|trim');
        $this->form_validation->set_rules('honor', 'Honor', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/sensus', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'start' => strtotime($this->input->post('start')),
                'finish' => strtotime($this->input->post('finish')),
                'k_pengawas' => $this->input->post('k_pengawas'),
                'k_pencacah' => $this->input->post('k_pencacah'),
                'target_responden' => $this->input->post('target_responden'),
                'jenis_kegiatan' => '2',
                'ob' => $this->input->post('ob'),
                'honor' => $this->input->post('honor'),

                'created_by' => $pegawai['nip'],

            ];
            if (strtotime($this->input->post('finish')) > strtotime($this->input->post('start'))) {
                $this->db->insert('kegiatan', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New survei added!</div>');
                redirect('kegiatan/sensus');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Waktu kegiatan salah!</div>');
                redirect('kegiatan/sensus');
            }
        }
    }

    public function editsurvei($id)
    {
        $data['title'] = 'Edit Survei';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['survei'] = $this->db->get_where('kegiatan', ['id' => $id])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('start', 'Start', 'required|trim');
        $this->form_validation->set_rules('finish', 'Finish', 'required|trim');
        $this->form_validation->set_rules('k_pengawas', 'Kuota Pengawas', 'required|trim');
        $this->form_validation->set_rules('k_pencacah', 'Kuota Pencacah', 'required|trim');
        $this->form_validation->set_rules('target_responden', 'Target Responden', 'required|trim');
        $this->form_validation->set_rules('ob', 'OB', 'required|trim');
        $this->form_validation->set_rules('honor', 'Honor', 'required|trim');



        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/edit-survei', $data);
            $this->load->view('template/footer');
        } else {
            $jmlpengawas = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $id])->num_rows();
            $jmlpencacah = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $id])->num_rows();
            if ($this->input->post('k_pengawas') < $jmlpengawas || $this->input->post('k_pencacah') < $jmlpencacah) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kuota kegiatan tidak benar!</div>');
                redirect('kegiatan/editsurvei/' . $id);
            }
            $data = [
                'nama' => $this->input->post('nama'),
                'start' => strtotime($this->input->post('start')),
                'finish' => strtotime($this->input->post('finish')),
                'k_pengawas' => $this->input->post('k_pengawas'),
                'k_pencacah' => $this->input->post('k_pencacah'),
                'target_responden' => $this->input->post('target_responden'),
                'ob' => $this->input->post('ob'),
                'honor' => $this->input->post('honor'),

            ];

            if (strtotime($this->input->post('finish')) > strtotime($this->input->post('start'))) {
                $this->db->set($data);
                $this->db->where('id', $id);
                $this->db->update('kegiatan');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Survei has been updated!</div>');
                redirect('kegiatan/survei');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Waktu kegiatan salah!</div>');
                redirect('kegiatan/editsurvei/' . $id);
            }
        }
    }

    public function editsensus($id)
    {
        $data['title'] = 'Edit Sensus';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['sensus'] = $this->db->get_where('kegiatan', ['id' => $id])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('start', 'Start', 'required|trim');
        $this->form_validation->set_rules('finish', 'Finish', 'required|trim');
        $this->form_validation->set_rules('k_pengawas', 'Kuota Pengawas', 'required|trim');
        $this->form_validation->set_rules('k_pencacah', 'Kuota Pencacah', 'required|trim');
        $this->form_validation->set_rules('target_responden', 'Target Responden', 'required|trim');
        $this->form_validation->set_rules('ob', 'OB', 'required|trim');
        $this->form_validation->set_rules('honor', 'Honor', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/edit-sensus', $data);
            $this->load->view('template/footer');
        } else {
            $jmlpengawas = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $id])->num_rows();
            $jmlpencacah = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $id])->num_rows();
            if ($this->input->post('k_pengawas') < $jmlpengawas || $this->input->post('k_pencacah') < $jmlpencacah) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kuota kegiatan tidak benar!</div>');
                redirect('kegiatan/editsensus/' . $id);
            }
            $data = [
                'nama' => $this->input->post('nama'),
                'start' => strtotime($this->input->post('start')),
                'finish' => strtotime($this->input->post('finish')),
                'k_pengawas' => $this->input->post('k_pengawas'),
                'k_pencacah' => $this->input->post('k_pencacah'),
                'target_responden' => $this->input->post('target_responden'),
                'ob' => $this->input->post('ob'),
                'honor' => $this->input->post('honor'),

            ];

            if (strtotime($this->input->post('finish')) > strtotime($this->input->post('start'))) {
                $this->db->set($data);
                $this->db->where('id', $id);
                $this->db->update('kegiatan');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Survei has been updated!</div>');
                redirect('kegiatan/sensus');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Waktu kegiatan salah!</div>');
                redirect('kegiatan/editsensus/' . $id);
            }
        }
    }

    function deletesurvei($id)
    {
        $q1 = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $id";

        $q2 = "DELETE FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($q1)";
        $q22 = $this->db->query($q2);

        $this->Kegiatan_model->deletesurvei_all_kegiatan_pencacah($id);
        $this->Kegiatan_model->deletesurvei_all_kegiatan_pengawas($id);

        $this->Kegiatan_model->deletesurvei($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Survei has been deleted!</div>');
        redirect('kegiatan/survei');
    }

    function deletesensus($id)
    {
        $q1 = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $id";

        $q2 = "DELETE FROM all_penilaian WHERE all_kegiatan_pencacah_id IN ($q1)";
        $q22 = $this->db->query($q2);

        $this->Kegiatan_model->deletesensus_all_kegiatan_pencacah($id);
        $this->Kegiatan_model->deletesensus_all_kegiatan_pengawas($id);
        $this->Kegiatan_model->deletesensus($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Sensus has been deleted!</div>');
        redirect('kegiatan/sensus');
    }

    function tambah_pencacah($id)
    {
        $data['title'] = 'Tambah Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql_waktu = "SELECT kegiatan.start, kegiatan.finish FROM kegiatan WHERE kegiatan.id = $id";
        $waktu = $this->db->query($sql_waktu)->row();

        $sql_bentuk_kegiatan = "SELECT kegiatan.ob FROM kegiatan WHERE kegiatan.id = $id";
        $bentuk_kegiatan = implode($this->db->query($sql_bentuk_kegiatan)->row_array());

        if ($bentuk_kegiatan == 1) {
            //jika $id kegiatan ob
            $sql_id_kegiatan = "SELECT kegiatan.id FROM kegiatan WHERE ((kegiatan.start < $waktu->start AND kegiatan.finish < $waktu->start) OR (kegiatan.start > $waktu->finish AND kegiatan.finish > $waktu->finish)) AND kegiatan.id != $id  ";

            $sql_id_mitra = "SELECT mitra.id_mitra FROM mitra JOIN all_kegiatan_pencacah ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id NOT IN ($sql_id_kegiatan) AND mitra.is_active GROUP BY mitra.id_mitra ";

            $sql_id_mitra_pengawas = "SELECT id_pengawas FROM all_kegiatan_pengawas WHERE kegiatan_id = $id";

            $sql_pencacah = "SELECT mitra.* FROM mitra WHERE (mitra.id_mitra NOT IN ($sql_id_mitra)) AND mitra.is_active = '1' AND (mitra.id_mitra NOT IN ($sql_id_mitra_pengawas))";
        } else {
            //jika $id kegiatan non ob
            $sql_id_kegiatan = "SELECT kegiatan.id FROM kegiatan WHERE ((((kegiatan.start < $waktu->start AND kegiatan.finish < $waktu->start) OR (kegiatan.start > $waktu->finish AND kegiatan.finish > $waktu->finish)) AND kegiatan.ob = 1) OR kegiatan.ob != 1) AND kegiatan.id != $id  ";

            $sql_id_mitra = "SELECT mitra.id_mitra FROM mitra JOIN all_kegiatan_pencacah ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id NOT IN ($sql_id_kegiatan) AND mitra.is_active GROUP BY mitra.id_mitra ";

            $sql_id_mitra_pengawas = "SELECT id_pengawas FROM all_kegiatan_pengawas WHERE kegiatan_id = $id";

            $sql_pencacah = "SELECT mitra.* FROM mitra WHERE (mitra.id_mitra NOT IN ($sql_id_mitra)) AND mitra.is_active = '1' AND (mitra.id_mitra NOT IN ($sql_id_mitra_pengawas))";
        }

        $data['pencacah'] = $this->db->query($sql_pencacah)->result_array();
        $sqlkuota = "SELECT count(kegiatan_id) as kegiatan_id FROM all_kegiatan_pencacah WHERE kegiatan_id = $id";
        $data['kuota'] = $this->db->query($sqlkuota)->row_array();
        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $id])->row_array();
        $data['controller'] = $this;


        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/tambah-pencacah', $data);
        $this->load->view('template/footer');
    }

    function mitraterpilih($id)
    {
        $data['title'] = 'Mitra Terpilih';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqlpencacah = "SELECT mitra.* FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $id";
        $data['pencacah'] = $this->db->query($sqlpencacah)->result_array();

        $sqlkuota = "SELECT count(kegiatan_id) as kegiatan_id FROM all_kegiatan_pencacah WHERE kegiatan_id = $id";
        $data['kuota'] = $this->db->query($sqlkuota)->row_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/mitra-terpilih', $data);
        $this->load->view('template/footer');
    }

    function details_kegiatan_mitra($kegiatan_id, $id_mitra)
    {
        $data['title'] = 'Details Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $now = date("Y-m-d", time());

        $sql = "SELECT all_kegiatan_pencacah.*, kegiatan.* FROM all_kegiatan_pencacah INNER JOIN kegiatan ON all_kegiatan_pencacah.kegiatan_id = kegiatan.id WHERE all_kegiatan_pencacah.id_mitra = $id_mitra AND ((kegiatan.start <= $now AND kegiatan.finish >= $now) OR (kegiatan.start > $now)) ORDER BY kegiatan.start";

        $data['details'] = $this->db->query($sql)->result_array();
        $jumlahkegiatan = count($data['details']);

        if ($jumlahkegiatan > 0) {

            $data['id_mitra'] = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/details-kegiatan-mitra', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mitra belum mengikuti kegiatan</div>');
            redirect('kegiatan/tambah_pencacah/' . $kegiatan_id);
        }
    }

    function details_mitra_kegiatan($id_mitra)
    {
        $data['title'] = 'Details Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT kegiatan.* FROM all_kegiatan_pencacah INNER JOIN kegiatan ON all_kegiatan_pencacah.kegiatan_id = kegiatan.id WHERE all_kegiatan_pencacah.id_mitra = $id_mitra";

        $data['id_mitra'] = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();

        $data['details'] = $this->db->query($sql)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/details-mitra-kegiatan', $data);
        $this->load->view('template/footer');
    }

    function details_nilai_perkegiatan($id_mitra, $kegiatan_id)
    {
        $data['title'] = 'Details Nilai Per Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['id_mitra'] = $id_mitra;
        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $data['kriteria'] = $this->db->get('kriteria')->result_array();

        $sqlnilai = "SELECT all_penilaian.*, kriteria.nama FROM all_penilaian LEFT JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id  JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra";
        $data['nilai'] = $this->db->query($sqlnilai)->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/details-nilai-perkegiatan', $data);
        $this->load->view('template/footer');
    }

    public function changepencacah()
    {
        $kegiatan_id = $this->input->post('kegiatanId');
        $id_mitra = $this->input->post('mitraId');

        $kuota = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $intkuota = (int) $kuota['k_pencacah'];


        $cek_kuota = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $kegiatan_id])->num_rows();

        // tambahan mochi
        // $kueri = "SELECT "
        // $cek_kegiatan = $this->db->query($kueri)->num_rows();

        $data = [
            'kegiatan_id' => $kegiatan_id,
            'id_mitra' => $id_mitra
        ];

        $queryemail = "SELECT email FROM mitra WHERE id_mitra = $id_mitra";
        $email = implode($this->db->query($queryemail)->row_array());
        $data2 = [
            'email' => $email,
            'role_id' => '5',
            'date_created' => date("Y-m-d", time())

        ];

        $result = $this->db->get_where('all_kegiatan_pencacah', $data);

        if ($result->num_rows() < 1) {
            if ($cek_kuota < $intkuota) {
                $this->db->insert('all_kegiatan_pencacah', $data);
                $check = $this->Kegiatan_model->check_email($email, 5);
                if ($check < 1) {
                    $this->db->insert('user', $data2);
                }
                // $all_kegiatan_pencacah_id = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $kegiatan_id, 'id_mitra' => $id_mitra])->row_array();
                // $data3 = [

                //     'all_kegiatan_pencacah_id' => $all_kegiatan_pencacah_id['id']

                // ];
                // $this->db->insert('ranking', $data3);

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pencacah changed!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kuota penuh!</div>');
            }
        } else {

            $all_kegiatan_pencacah_id = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $kegiatan_id, 'id_mitra' => $id_mitra])->row_array();
            $data3 = [

                'all_kegiatan_pencacah_id' => $all_kegiatan_pencacah_id['id']

            ];
            // $this->db->delete('ranking', $data3);
            $this->db->delete('all_penilaian', $data3);
            $this->db->delete('all_kegiatan_pencacah', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pencacah changed!</div>');
        }
    }

    function tambah_pengawas($id)
    {
        $data['title'] = 'Tambah Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqlpengawas = "SELECT pegawai.* FROM pegawai";
        $data['pengawas'] = $this->db->query($sqlpengawas)->result_array();

        $sqlkuota = "SELECT count(kegiatan_id) as kegiatan_id FROM all_kegiatan_pengawas WHERE kegiatan_id = $id";
        $data['kuota'] = $this->db->query($sqlkuota)->row_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/tambah-pengawas', $data);
        $this->load->view('template/footer');
    }

    function tambah_pengawas_mitra($id)
    {
        $data['title'] = 'Tambah Pengawas';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email'), 'role_id' => '3'])->row_array();

        $sql_pengawas_mitra = "SELECT id_mitra FROM all_kegiatan_pencacah WHERE kegiatan_id = $id";

        $sqlpengawas = "SELECT mitra.* FROM mitra WHERE id_mitra NOT IN ($sql_pengawas_mitra)";
        $data['pengawas'] = $this->db->query($sqlpengawas)->result_array();

        $sqlkuota = "SELECT count(kegiatan_id) as kegiatan_id FROM all_kegiatan_pengawas WHERE kegiatan_id = $id";
        $data['kuota'] = $this->db->query($sqlkuota)->row_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/tambah-pengawas-dari-mitra', $data);
        $this->load->view('template/footer');
    }

    public function changepengawas()
    {
        $kegiatan_id = $this->input->post('kegiatanId');
        $nip = $this->input->post('nip');

        $kuota = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $intkuota = (int) $kuota['k_pengawas'];


        $cek_kuota = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $kegiatan_id])->num_rows();

        $data = [
            'kegiatan_id' => $kegiatan_id,
            'id_pengawas' => $nip
        ];

        $result = $this->db->get_where('all_kegiatan_pengawas', $data);

        if ($result->num_rows() < 1) {
            if ($cek_kuota < $intkuota) {
                $this->db->insert('all_kegiatan_pengawas', $data);
                redirect('kegiatan/tambah_pengawas_ke_user/' . $nip);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kuota penuh!</div>');
            }
        } else {
            $query = "DELETE FROM all_kegiatan_pengawas WHERE kegiatan_id = $kegiatan_id AND id_pengawas = $nip";
            $this->db->query($query);

            $this->db->delete('all_kegiatan_pengawas', $data);
            $this->db->set('id_pengawas', NULL);
            $this->db->where('id_pengawas', $nip);
            $this->db->update('all_kegiatan_pencacah');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengawas changed!</div>');
        }
    }

    public function changepengawas_mitra()
    {
        $kegiatan_id = $this->input->post('kegiatanId');
        $id_mitra = $this->input->post('id_mitra');

        $kuota = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        $intkuota = (int) $kuota['k_pengawas'];


        $cek_kuota = $this->db->get_where('all_kegiatan_pengawas', ['kegiatan_id' => $kegiatan_id])->num_rows();

        $data = [
            'kegiatan_id' => $kegiatan_id,
            'id_pengawas' => $id_mitra
        ];

        $result = $this->db->get_where('all_kegiatan_pengawas', $data);

        if ($result->num_rows() < 1) {
            if ($cek_kuota < $intkuota) {
                $this->db->insert('all_kegiatan_pengawas', $data);
                redirect('kegiatan/tambah_pengawas_mitra_ke_user/' . $id_mitra);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kuota penuh!</div>');
            }
        } else {
            $query = "DELETE FROM all_kegiatan_pengawas WHERE kegiatan_id = $kegiatan_id AND id_pengawas = $id_mitra";
            $this->db->query($query);

            $this->db->delete('all_kegiatan_pengawas', $data);
            $this->db->set('id_pengawas', NULL);
            $this->db->where('id_pengawas', $id_mitra);
            $this->db->update('all_kegiatan_pencacah');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengawas changed!</div>');
        }
    }

    function pengawasterpilih($kegiatan_id)
    {
        $data['title'] = 'Pengawas Terpilih';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqlpengawas = "SELECT pegawai.nip as nip, pegawai.email as email, pegawai.nama as nama FROM all_kegiatan_pengawas JOIN pegawai ON all_kegiatan_pengawas.id_pengawas = pegawai.nip WHERE all_kegiatan_pengawas.kegiatan_id = $kegiatan_id UNION (SELECT mitra.id_mitra as nip, mitra.email as email, mitra.nama_lengkap as nama FROM all_kegiatan_pengawas JOIN mitra ON all_kegiatan_pengawas.id_pengawas = mitra.id_mitra WHERE all_kegiatan_pengawas.kegiatan_id = $kegiatan_id)";

        $data['pengawas'] = $this->db->query($sqlpengawas)->result_array();

        $sqlkuota = "SELECT count(kegiatan_id) as kegiatan_id FROM all_kegiatan_pengawas WHERE kegiatan_id = $kegiatan_id";
        $data['kuota'] = $this->db->query($sqlkuota)->row_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/pengawas-terpilih', $data);
        $this->load->view('template/footer');
    }

    function tambah_pengawas_ke_user($nip)
    {
        $sqlnamapegawai = "SELECT email FROM pegawai WHERE nip = $nip";
        $emailpegawai = implode($this->db->query($sqlnamapegawai)->row_array());


        $sqlcekpegawai = "SELECT * FROM user WHERE email = '$emailpegawai' AND role_id = '4'";
        $cekpegawai = $this->db->query($sqlcekpegawai);

        $pegawai = $this->db->get_where('pegawai', ['nip' => $nip])->row_array();

        $data2 = [

            'email' => $pegawai['email'],
            'role_id' => '4',
            'date_created' => date("Y-m-d", time())
        ];

        if ($cekpegawai->num_rows() < 1) {
            $this->db->insert('user', $data2);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengawas changed!</div>');
    }

    function tambah_pengawas_mitra_ke_user($id_mitra)
    {
        $sqlnamapegawai = "SELECT email FROM mitra WHERE id_mitra = $id_mitra";
        $emailpegawai = implode($this->db->query($sqlnamapegawai)->row_array());


        $sqlcekpegawai = "SELECT * FROM user WHERE email = '$emailpegawai' AND role_id = '4'";
        $cekpegawai = $this->db->query($sqlcekpegawai);

        $mitra = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();

        $data2 = [

            'email' => $mitra['email'],
            'role_id' => '4',
            'date_created' => date("Y-m-d", time())
        ];

        if ($cekpegawai->num_rows() < 1) {
            $this->db->insert('user', $data2);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengawas changed!</div>');
    }


    function details_kegiatan_pengawas($kegiatan_id, $id)
    {
        $data['title'] = 'Details Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $now = date("Y-m-d", time());

        $sql = "SELECT all_kegiatan_pengawas.*, kegiatan.* FROM all_kegiatan_pengawas INNER JOIN kegiatan ON all_kegiatan_pengawas.kegiatan_id = kegiatan.id WHERE all_kegiatan_pengawas.id_pengawas = $id AND ((kegiatan.start <= $now AND kegiatan.finish >= $now) OR (kegiatan.start > $now)) ORDER BY kegiatan.start";
        $data['details'] = $this->db->query($sql)->result_array();

        $jumlahkegiatan = count($data['details']);

        if ($jumlahkegiatan > 0) {

            $data['pengawas'] = $this->db->get_where('pegawai', ['nip' => $id])->row_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/details-kegiatan-pengawas', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pengawas belum mengikuti kegiatan</div>');
            redirect('kegiatan/tambah_pengawas/' . $kegiatan_id);
        }
    }

    function details_kegiatan_pengawas_mitra($kegiatan_id, $id)
    {
        $data['title'] = 'Details Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $now = date("Y-m-d", time());

        $sql = "SELECT all_kegiatan_pengawas.*, kegiatan.* FROM all_kegiatan_pengawas INNER JOIN kegiatan ON all_kegiatan_pengawas.kegiatan_id = kegiatan.id WHERE all_kegiatan_pengawas.id_pengawas = $id AND ((kegiatan.start <= $now AND kegiatan.finish >= $now) OR (kegiatan.start > $now)) ORDER BY kegiatan.start";
        $data['details'] = $this->db->query($sql)->result_array();

        $jumlahkegiatan = count($data['details']);

        if ($jumlahkegiatan > 0) {

            $data['pengawas'] = $this->db->get_where('pegawai', ['nip' => $id])->row_array();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('kegiatan/details-kegiatan-pengawas', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pengawas belum mengikuti kegiatan</div>');
            redirect('kegiatan/tambah_pengawas_mitra/' . $kegiatan_id);
        }
    }

    function tambah_pencacah_pengawas($kegiatan_id, $nip)
    {
        $data['title'] = 'Plotting Pencacah';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqlpengawas = "SELECT pegawai.nip as nip, pegawai.nama as nama, pegawai.email as email FROM pegawai WHERE nip = $nip UNION (SELECT mitra.id_mitra as nip, mitra.nama_lengkap as nama, mitra.email as email FROM mitra WHERE id_mitra = $nip)";
        $data['pengawas'] = $this->db->query($sqlpengawas)->row_array();

        $sqlpencacah = "SELECT all_kegiatan_pencacah.*, mitra.* FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_pengawas is NULL";
        $data['pencacah'] = $this->db->query($sqlpencacah)->result_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $sqlcount = "SELECT COUNT(*) AS terisi FROM all_kegiatan_pencacah WHERE id_pengawas = $nip and kegiatan_id = $kegiatan_id";
        $data['terisi'] = $this->db->query($sqlcount)->row_array();

        if (fmod($data['kegiatan']['k_pencacah'], $data['kegiatan']['k_pengawas']) == 0) {
            $data['maxkuota'] = ($data['kegiatan']['k_pencacah'] / $data['kegiatan']['k_pengawas']);
        } else {
            $data['maxkuota'] = floor($data['kegiatan']['k_pencacah'] / $data['kegiatan']['k_pengawas']) + 1;
        }


        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/tambah-pencacah-pengawas', $data);
        $this->load->view('template/footer');
    }

    public function changepencacahpengawas()
    {
        $kegiatan_id = $this->input->post('kegiatanId');
        $nip = $this->input->post('nip');
        $id_mitra = $this->input->post('id_mitra');
        $kuota = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();
        if (fmod($kuota['k_pencacah'], $kuota['k_pengawas']) == 0) {
            $maxkuota = $kuota['k_pencacah'] / $kuota['k_pengawas'];
        } else {
            $maxkuota = ($kuota['k_pencacah'] / $kuota['k_pengawas']) + 1;
        }
        $terisi = $this->db->get_where('all_kegiatan_pencacah', ['kegiatan_id' => $kegiatan_id, 'id_pengawas' => $nip])->num_rows();

        $data = [
            'kegiatan_id' => $kegiatan_id,
            'id_pengawas' => $nip,
            'id_mitra' => $id_mitra
        ];

        $result = $this->db->get_where('all_kegiatan_pencacah', $data);

        if ($result->num_rows() < 1) {
            if ($terisi < $maxkuota) {
                $query = "UPDATE all_kegiatan_pencacah SET id_pengawas = $nip WHERE kegiatan_id = $kegiatan_id AND id_mitra = $id_mitra";
                $this->db->query($query);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pencacah changed!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kuota penuh!</div>');
            }
        } else {
            $query = "UPDATE all_kegiatan_pencacah SET id_pengawas = NULL WHERE kegiatan_id = $kegiatan_id AND id_mitra = $id_mitra";
            $this->db->query($query);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pencacah changed!</div>');
        }
    }

    function pencacahterpilih($kegiatan_id, $nip)
    {
        $data['title'] = 'Pencacah Terpilih';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sqlpengawas = "SELECT pegawai.nip as nip, pegawai.nama as nama, pegawai.email as email FROM pegawai WHERE nip = $nip UNION SELECT mitra.id_mitra as nip, mitra.nama_lengkap as nama, mitra.email as email FROM mitra WHERE id_mitra = $nip ";
        $data['pengawas'] = $this->db->query($sqlpengawas)->row_array();

        $sqlpencacah = "SELECT all_kegiatan_pencacah.id_mitra, mitra.nama_lengkap FROM all_kegiatan_pencacah JOIN mitra ON all_kegiatan_pencacah.id_mitra = mitra.id_mitra WHERE (all_kegiatan_pencacah.kegiatan_id = $kegiatan_id) AND (all_kegiatan_pencacah.id_pengawas = $nip)";
        $data['pencacah'] = $this->db->query($sqlpencacah)->result_array();

        $data['kegiatan'] = $this->db->get_where('kegiatan', ['id' => $kegiatan_id])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('kegiatan/pencacah-terpilih', $data);
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function detailKegiatan($id)
    {
        $kegiatan = $this->db->get_where('kegiatan', ['id' => $id])->row_array();
        $operator = $this->db->get_where('pegawai', ['nip' => $kegiatan['created_by']])->row_array();
        $sqlpengawas = "SELECT B.nama as nama FROM all_kegiatan_pengawas AS A JOIN pegawai AS B ON A.id_pengawas = B.nip WHERE A.kegiatan_id = $id UNION SELECT C.nama_lengkap as nama FROM all_kegiatan_pengawas AS A JOIN mitra AS C ON A.id_pengawas = C.id_mitra WHERE A.kegiatan_id = $id";
        $pengawas = $this->db->query($sqlpengawas)->result_array();
        $sqlpencacah = "SELECT B.nama as nama FROM all_kegiatan_pencacah AS A JOIN pegawai AS B ON A.id_mitra = B.nip WHERE A.kegiatan_id = $id UNION SELECT C.nama_lengkap as nama FROM all_kegiatan_pencacah AS A JOIN mitra AS C ON A.id_mitra = C.id_mitra WHERE A.kegiatan_id = $id";
        $pencacah = $this->db->query($sqlpencacah)->result_array();
        $data = [
            'kegiatan' => $kegiatan,
            'operator' => $operator,
            'pengawas' => $pengawas,
            'pencacah' => $pencacah,
        ];

        $this->load->view('kegiatan/detail-kegiatan', $data);
    }

    // tambahan mochi
    public function cekHonor($id, $date)
    {
        $honor = 0;
        $query = "SELECT b.finish AS finis, b.honor AS honor FROM all_kegiatan_pencacah AS a JOIN kegiatan AS b ON a.kegiatan_id = b.id WHERE a.id_mitra = $id";
        $kegiatan = $this->db->query($query)->result_array();
        foreach ($kegiatan as $k) {
            if (date("F", $k['finis']) == date("F", $date)) {
                $honor = $honor + $k['honor'];
            }
        }
        return $honor;
    }
}
