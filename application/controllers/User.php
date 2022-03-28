<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in_user();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($this->session->userdata('role_id') == 3) {
            $data['jmlPegawai'] = $this->db->count_all_results('pegawai');
            $data['jmlMitra'] = $this->db->count_all_results('mitra');
            $queryKegiatan = "SELECT a.* FROM kegiatan AS a JOIN pegawai AS b ON a.created_by = b.nip WHERE b.email = '$email' ORDER BY a.start ASC";
            $data['kegiatan']['daftar'] = $this->db->query($queryKegiatan)->result_array();
            $data['kegiatan']['current'] = $this->db->get_where('kegiatan', ['start <=' => time(), 'finish >' => time()])->num_rows();
            $data['kegiatan']['next'] = $this->db->get_where('kegiatan', ['start >' => time()])->num_rows();
            $data['kegiatan']['done'] = $this->db->get_where('kegiatan', ['finish <' => time()])->num_rows();
        }
        if ($this->session->userdata('role_id') == 4) {
            $datadiri = $this->db->get_where('pegawai', ['email' => $email])->row_array();
            $data['nilai'] = $datadiri['nilai'];
            $nip = $datadiri['nip'];
            $query1 = "SELECT a.* FROM all_kegiatan_pengawas AS a JOIN pegawai AS b ON a.id_pengawas = b.nip WHERE b.email = '$email'";
            $jmlpgws = $this->db->query($query1)->num_rows();
            $query2 = "SELECT a.* FROM all_kegiatan_pencacah AS a JOIN pegawai AS b ON a.id_mitra = b.nip WHERE b.email = '$email'";
            $jmlpnch = $this->db->query($query2)->num_rows();
            $data['jmlKegiatan'] = $jmlpgws + $jmlpnch;
            $query3 = "SELECT a.* FROM kegiatan AS a JOIN all_kegiatan_pengawas AS b ON a.id = b.kegiatan_id WHERE b.id_pengawas = '$nip' UNION (SELECT a.* FROM kegiatan AS a JOIN all_kegiatan_pencacah AS c ON a.id = c.kegiatan_id WHERE c.id_mitra = '$nip') ORDER BY start ASC";
            $data['kegiatan'] = $this->db->query($query3)->result_array();
        }
        if ($this->session->userdata('role_id') == 5) {
            $datadiri = $this->db->get_where('mitra', ['email' => $email])->row_array();
            $id_mitra = $datadiri['id_mitra'];
            $query = "SELECT a.* FROM kegiatan AS a JOIN all_kegiatan_pencacah AS c ON a.id = c.kegiatan_id WHERE c.id_mitra = '$id_mitra' ORDER BY a.start ASC";
            $data['kegiatan'] = $this->db->query($query)->result_array();
        }
        $sqlpegawai = "SELECT pegawai.nama as nama, pegawai.email as email FROM pegawai WHERE pegawai.email = '$email' UNION (SELECT mitra.nama_lengkap as nama, mitra.email as email FROM mitra WHERE mitra.email = '$email')";
        $data['pegawai'] = $this->db->query($sqlpegawai)->row_array();
        $data['mitra'] = $this->db->get_where('mitra', ['email' => $email])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('template/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $user = explode('@gmail.com', $this->session->userdata('email'));

        $this->form_validation->set_rules('email', 'Email', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('template/footer');
        } else {
            // $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $upload_image = $_FILES['image'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';
                $config['file_name'] = $user[0] . '_profile';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('user');
                }
            }

            $this->db->set('email', $email);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
            redirect('user');
        }
    }

    public function editprofilemitra()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['mitra'] = $this->db->get_where('mitra', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nama_panggilan', 'Nama Panggilan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat');
        $this->form_validation->set_rules('no_wa', 'No. Whatsaap', 'required');
        $this->form_validation->set_rules('no_tsel', 'No. Telkomsel', 'required');
        $this->form_validation->set_rules('pekerjaan_utama', 'Pekerjaan Utama');
        $this->form_validation->set_rules('kompetensi', 'Kompetensi');
        $this->form_validation->set_rules('bahasa', 'Bahasa', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/editprofilemitra', $data);
            $this->load->view('template/footer');
        } else {

            $email = $this->input->post('email');
            $data = [
                // 'id_mitra' => $this->input->post('id_mitra'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'nama_panggilan' => $this->input->post('nama_panggilan'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'no_wa' => $this->input->post('no_wa'),
                'no_tsel' => $this->input->post('no_tsel'),
                'pekerjaan_utama' => $this->input->post('pekerjaan_utama'),
                'kompetensi' => $this->input->post('kompetensi'),
                'bahasa' => $this->input->post('bahasa')
            ];

            $data2 = [
                'email' => $this->input->post('email')
            ];

            $upload_image = $_FILES['image'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('user');
                }
            }

            $this->db->set($data);
            $this->db->where('email', $email);
            $this->db->update('mitra');

            $this->db->set($data2);
            $this->db->where('email', $email);
            $this->db->update('user');



            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated!</div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[8]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[8]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('template/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password changed!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }
    public function ranking()
    {
        $this->refreshRank();
        $mitra = $this->db->order_by('nilai desc')->get('mitra')->result_array();
        $pegawai = $this->db->order_by('nilai desc')->get('pegawai')->result_array();
        $data = [
            'user'  => $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array(),
            'title' => 'Ranking',
            'mitra' => $mitra,
            'pegawai' => $pegawai
        ];

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('template/topbar');
        $this->load->view('user/ranking');
        $this->load->view('template/footer');
    }

    // tambahan mochi
    public function refreshRank()
    {
        $kueriM = "SELECT id_mitra FROM mitra";
        $mitra = $this->db->query($kueriM)->result_array();
        foreach ($mitra as $m) {
            $this->nilaiPencacah($m['id_mitra']);
        }
        $kueriP = "SELECT nip FROM pegawai";
        $pegawai = $this->db->query($kueriP)->result_array();
        foreach ($pegawai as $p) {
            $this->nilaiPengawas($p['nip']);
        }
    }

    // tambahan mochi
    public function nilaiPencacah($id)
    {
        $nilai = (float) 0;
        $queryminsub = "SELECT min(nilai) FROM subkriteria";
        $minsub =  (int) implode($this->db->query($queryminsub)->row_array());
        $querymaxsub = "SELECT max(nilai) FROM subkriteria";
        $maxsub =  (int) implode($this->db->query($querymaxsub)->row_array());
        $kueri = "SELECT COUNT(kegiatan_id) as jml FROM all_kegiatan_pencacah WHERE id_mitra = $id";
        $tampungjml = $this->db->query($kueri)->row_array();
        if ($tampungjml['jml'] > 0) {
            $jmlkegiatan = $tampungjml['jml'];
            $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->num_rows();
            $sqlrow = "SELECT count(*) as r FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.id_mitra = $id";
            $row = (int) implode($this->db->query($sqlrow)->row_array());
            if ($row == ($jumlah_kriteria * $jmlkegiatan)) {
                $kriteria = $this->db->get_where('kriteria', ['target' => 'pencacah'])->result_array();
                foreach ($kriteria as $k) {
                    $krit = $k['id'];
                    $bobot = $k['bobot'];
                    $query = "SELECT SUM(A.nilai) as nilai FROM all_penilaian AS A JOIN all_kegiatan_pencacah AS B ON A.all_kegiatan_pencacah_id = B.id WHERE B.id_mitra = $id AND A.kriteria_id = $krit";
                    $result = $this->db->query($query)->row_array();
                    $rata2 = (float) $result['nilai'] / $jmlkegiatan;
                    $nilai_temp =  50 + (45 * ($rata2 - $minsub) / ($maxsub - $minsub));
                    $nilai_util = $bobot * $nilai_temp;
                    $nilai = $nilai + $nilai_util;
                }
                $kegiatansql = "SELECT COUNT(DISTINCT kegiatan_id) as t FROM all_kegiatan_pencacah";
                $tambahan = (int) implode($this->db->query($kegiatansql)->row_array());
                $nilai = $nilai + (5 * ($jmlkegiatan / $tambahan));
                $this->db->set('nilai', round($nilai, 2));
                $this->db->where('id_mitra', $id);
                $this->db->update('mitra');
            }
        }
    }

    // tambahan mochi
    public function nilaiPengawas($nip)
    {
        $nilai = 0;
        $queryminsub = "SELECT min(nilai) FROM subkriteria";
        $minsub =  (int) implode($this->db->query($queryminsub)->row_array());
        $querymaxsub = "SELECT max(nilai) FROM subkriteria";
        $maxsub =  (int) implode($this->db->query($querymaxsub)->row_array());
        $kueri = "SELECT COUNT(kegiatan_id) as jml FROM all_kegiatan_pengawas WHERE id_pengawas = $nip";
        $tampungjml = $this->db->query($kueri)->row_array();
        if ($tampungjml['jml'] > 0) {
            $jmlkegiatan = $tampungjml['jml'];
            $jumlah_kriteria = $this->db->get_where('kriteria', ['target' => 'pengawas'])->num_rows();
            $sqlrow = "SELECT count(*) FROM penilaian_pengawas AS A JOIN all_kegiatan_pengawas AS B ON A.all_kegiatan_pengawas_id = B.id WHERE B.id_pengawas = $nip";
            $row = (int) implode($this->db->query($sqlrow)->row_array());

            // jumlah seharusnya
            $jml_mitra = $this->db->get_where('all_kegiatan_pencacah', ['id_pengawas' => $nip])->num_rows();
            $sqlpgws = "SELECT COUNT(*) FROM all_kegiatan_pengawas WHERE kegiatan_id IN (SELECT kegiatan_id FROM all_kegiatan_pengawas WHERE id_pengawas = $nip) AND  NOT id_pengawas = $nip";
            $jml_pengawas = (int) implode($this->db->query($sqlpgws)->row_array());

            $sqlos = "SELECT COUNT(*) FROM pegawai AS p JOIN user AS u ON p.email=u.email WHERE p.nip = $nip AND u.role_id = 3";
            $os_email = (int) implode($this->db->query($sqlos)->row_array());
            if ($os_email > 0) {
                $os = "SELECT COUNT(*) FROM `all_kegiatan_pengawas` AS A JOIN kegiatan AS B ON A.kegiatan_id=B.id WHERE B.created_by = $nip AND A.id_pengawas= $nip";
                $banyak_os = (int) implode($this->db->query($os)->row_array());
                $jml_os = $jmlkegiatan - $banyak_os;
            } else {
                $jml_os = $jmlkegiatan;
            }
            $pengali = ($jml_mitra + $jml_pengawas + $jml_os);

            if ($row == ($jumlah_kriteria * $pengali)) {
                $kriteria = $this->db->get_where('kriteria', ['target' => 'pengawas'])->result_array();
                foreach ($kriteria as $k) {
                    $krit = $k['id'];
                    $bobot = $k['bobot'];
                    $query = "SELECT SUM(A.nilai) as nilai FROM penilaian_pengawas AS A JOIN all_kegiatan_pengawas AS B ON A.all_kegiatan_pengawas_id = B.id WHERE B.id_pengawas = $nip AND A.kriteria_id = $krit";
                    $result = $this->db->query($query)->row_array();
                    $rata2 = (float) $result['nilai'] / $pengali;
                    $nilai_temp =  50 + (45 * ($rata2 - $minsub) / ($maxsub - $minsub));
                    $nilai_util = $bobot * $nilai_temp;
                    $nilai = $nilai + $nilai_util;
                }
                $kegiatansql = "SELECT COUNT(DISTINCT kegiatan_id) FROM all_kegiatan_pengawas";
                $tambahan = (int) implode($this->db->query($kegiatansql)->row_array());
                $nilai = $nilai + (5 * ($jmlkegiatan / $tambahan));
                $this->db->set('nilai', round($nilai, 2));
                $this->db->where('nip', $nip);
                $this->db->update('pegawai');
            }
        }
    }
}
