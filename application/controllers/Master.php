<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Master_model');
    }

    public function index()
    {
        $data['title'] = 'Master';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('master/index', $data);
        $this->load->view('template/footer');
    }

    public function mitra()
    {
        $data['title'] = 'Data Mitra';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['mitra'] = $this->db->get('mitra')->result_array();

        // $this->form_validation->set_rules('id_mitra', 'ID Mitra', 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nama_panggilan', 'Nama Panggilan', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim');
        $this->form_validation->set_rules('no_wa', 'No. Whatsaap', 'required|trim');
        $this->form_validation->set_rules('no_tsel', 'No. Telkomsel', 'required|trim');
        $this->form_validation->set_rules('pekerjaan_utama', 'Pekerjaan Utama', 'required|trim');
        $this->form_validation->set_rules('kompetensi', 'Kompetensi', 'required|trim');
        $this->form_validation->set_rules('bahasa', 'Bahasa', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('master/mitra', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                // 'id_mitra' => $this->input->post('id_mitra'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'nama_panggilan' => $this->input->post('nama_panggilan'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'no_hp' => $this->input->post('no_hp'),
                'no_wa' => $this->input->post('no_wa'),
                'no_tsel' => $this->input->post('no_tsel'),
                'pekerjaan_utama' => $this->input->post('pekerjaan_utama'),
                'kompetensi' => $this->input->post('kompetensi'),
                'bahasa' => $this->input->post('bahasa')
            ];

            $data2 = [

                'email' => $this->input->post('email'),
                'role_id' => '5',
                'date_created' => date("Y-m-d", time())

            ];

            $check = $this->Master_model->check_email($this->input->post('email'));

            if ($check < 1) {
                $this->db->insert('mitra', $data);
                // $this->db->insert('user', $data2);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New mitra added!</div>');
                redirect('master/mitra');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mitra sudah ada!</div>');
                redirect('master/mitra');
            }
        }
    }

    public function import()
    {
        $this->form_validation->set_rules('excel', 'File', 'trim|required');
        if ($_FILES['excel']['name'] == '') {
            $this->session->set_flashdata('msg', 'File harus diisi');
        } else {
            $config['upload_path'] = './assets/excel/';
            $config['allowed_types'] = 'xls|xlsx';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excel')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = $this->upload->data();

                error_reporting(E_ALL);
                date_default_timezone_set('Asia/Jakarta');

                include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

                $inputFileName = './assets/excel/' . $data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                $index = 0;
                foreach ($sheetData as $key => $value) {
                    if ($key != 1) {
                        $check = $this->Master_model->check_email($value['C']);

                        if ($check != 1) {
                            // $resultData[$index]['id_mitra'] = $value['A'];
                            $resultData[$index]['nama_lengkap'] = $value['A'];
                            $resultData[$index]['nama_panggilan'] = $value['B'];
                            $resultData[$index]['email'] = $value['C'];
                            $resultData[$index]['alamat'] = $value['D'];
                            $resultData[$index]['no_hp'] = $value['E'];
                            $resultData[$index]['no_wa'] = $value['F'];
                            $resultData[$index]['no_tsel'] = $value['G'];
                            $resultData[$index]['pekerjaan_utama'] = $value['H'];
                            $resultData[$index]['kompetensi'] = $value['I'];
                            $resultData[$index]['bahasa'] = $value['J'];
                        }
                    }
                    $index++;
                }

                unlink('./assets/excel/' . $data['file_name']);

                if (count($resultData) != 0) {
                    $result = $this->Master_model->insert_batch($resultData);
                    if ($result > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Mitra has been imported!</div>');
                        redirect('master/mitra');
                        echo json_encode($resultData);
                        die;
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import failed!</div>');
                    redirect('master/mitra');
                }
            }
        }
    }

    public function details_mitra($id_mitra)
    {
        $data['title'] = 'Details Mitra';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['mitra'] = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('master/details-mitra', $data);
        $this->load->view('template/footer');
    }

    public function editmitra($id_mitra)
    {
        $data['title'] = 'Edit Mitra';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['mitra'] = $this->db->get_where('mitra', ['id_mitra' => $id_mitra])->row_array();

        // $this->form_validation->set_rules('id_mitra', 'ID Mitra', 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nama_panggilan', 'Nama Panggilan', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim');
        $this->form_validation->set_rules('no_wa', 'No. Whatsaap', 'required|trim');
        $this->form_validation->set_rules('no_tsel', 'No. Telkomsel', 'required|trim');
        $this->form_validation->set_rules('pekerjaan_utama', 'Pekerjaan Utama', 'required|trim');
        $this->form_validation->set_rules('kompetensi', 'Kompetensi', 'required|trim');
        $this->form_validation->set_rules('bahasa', 'Bahasa', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('master/edit-mitra', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                // 'id_mitra' => $this->input->post('id_mitra'),
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'nama_panggilan' => $this->input->post('nama_panggilan'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'no_hp' => $this->input->post('no_hp'),
                'no_wa' => $this->input->post('no_wa'),
                'no_tsel' => $this->input->post('no_tsel'),
                'pekerjaan_utama' => $this->input->post('pekerjaan_utama'),
                'kompetensi' => $this->input->post('kompetensi'),
                'bahasa' => $this->input->post('bahasa')
            ];

            $this->db->set($data);
            $this->db->where('id_mitra', $id_mitra);
            $this->db->update('mitra');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Mitra has been updated!</div>');
            redirect('master/mitra');
        }
    }

    function details_kegiatan_mitra($id_mitra)
    {
        $data['title'] = 'Details Kegiatan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $sql = "SELECT all_kegiatan_pencacah.*, kegiatan.* FROM all_kegiatan_pencacah INNER JOIN kegiatan ON all_kegiatan_pencacah.kegiatan_id = kegiatan.id WHERE all_kegiatan_pencacah.id_mitra = $id_mitra";

        $data['details'] = $this->db->query($sql)->result_array();
        $data['id_mitra'] = $id_mitra;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('master/details-kegiatan-mitra', $data);
        $this->load->view('template/footer');
    }

    function deletemitra($id_mitra)
    {

        $query = "SELECT email FROM mitra WHERE id_mitra = $id_mitra";
        $email = IMPLODE($this->db->query($query)->row_array());
        $this->Master_model->deletemitrafromuser($email, 5);

        $this->Master_model->deletemitra($id_mitra);

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mitra has been deleted!</div>');
        redirect('master/mitra');
    }

    public function deactivated($id_mitra)
    {
        $this->Master_model->deactivated($id_mitra);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Mitra has been deactivated!</div>');
        redirect('master/mitra');
    }

    public function activated($id_mitra)
    {
        $this->Master_model->activated($id_mitra);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Mitra has been activated!</div>');
        redirect('master/mitra');
    }

    public function pegawai()
    {
        $data['title'] = 'Data Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pegawai'] = $this->db->get('pegawai')->result_array();

        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('master/pegawai', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'jabatan' => $this->input->post('jabatan')
            ];

            $this->db->insert('pegawai', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New pegawai added!</div>');
            redirect('master/pegawai');
        }
    }

    public function editpegawai($nip)
    {
        $data['title'] = 'Edit Pegawai';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['pegawai'] = $this->db->get_where('pegawai', ['nip' => $nip])->row_array();

        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('master/edit-pegawai', $data);
            $this->load->view('template/footer');
        } else {
            $data = [
                'nip' => $this->input->post('nip'),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'jabatan' => $this->input->post('jabatan')
            ];

            $this->db->set($data);
            $this->db->where('nip', $nip);
            $this->db->update('pegawai');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pegawai has been updated!</div>');
            redirect('master/pegawai');
        }
    }

    function deletepegawai($nip)
    {
        $query = "SELECT email FROM pegawai WHERE nip = $nip";
        $email = IMPLODE($this->db->query($query)->row_array());
        $this->Master_model->deletepegawaifromuser($email, 4);
        $this->Master_model->deletepegawaifromuser($email, 3);
        $this->Master_model->deletepegawai($nip);

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pegawai has been deleted!</div>');
        redirect('master/pegawai');
    }
}
