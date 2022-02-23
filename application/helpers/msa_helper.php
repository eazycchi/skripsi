<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function is_logged_in_user()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_pencacah($kegiatan_id, $id_mitra)
{
    $ci = get_instance();

    $ci->db->where('kegiatan_id', $kegiatan_id);
    $ci->db->where('id_mitra', $id_mitra);
    $result = $ci->db->get('all_kegiatan_pencacah');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_pengawas($kegiatan_id, $nip)
{
    $ci = get_instance();

    $ci->db->where('kegiatan_id', $kegiatan_id);
    $ci->db->where('id_pengawas', $nip);
    $result = $ci->db->get('all_kegiatan_pengawas');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}


function check_pencacahpengawas($kegiatan_id, $nip, $id_mitra)
{
    $ci = get_instance();

    $ci->db->where('kegiatan_id', $kegiatan_id);
    $ci->db->where('id_pengawas', $nip);
    $ci->db->where('id_mitra', $id_mitra);
    $result = $ci->db->get('all_kegiatan_pencacah');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_nilai($all_kegiatan_pencacah_id, $kriteria_id, $nilai)
{
    $ci = get_instance();

    $ci->db->where('all_kegiatan_pencacah_id', $all_kegiatan_pencacah_id);
    $ci->db->where('kriteria_id', $kriteria_id);
    $ci->db->where('nilai', $nilai);
    $result = $ci->db->get('all_penilaian');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_nilai_pengawas($all_kegiatan_pengawas_id, $id_pengawas, $id_penilai, $kriteria_id, $nilai)
{
    $ci = get_instance();

    $ci->db->where('all_kegiatan_pengawas_id', $all_kegiatan_pengawas_id);
    $ci->db->where('id_pengawas', $id_pengawas);
    $ci->db->where('id_penilai', $id_penilai);
    $ci->db->where('kriteria_id', $kriteria_id);
    $ci->db->where('nilai', $nilai);
    $result = $ci->db->get('penilaian_pengawas');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

// function check_nilai($kegiatan_id, $id_mitra, $kriteria_id, $nilai)
// {
//     $ci = get_instance();

//     $ci->db->where('kegiatan_id', $kegiatan_id);
//     $ci->db->where('id_mitra', $id_mitra);
//     $ci->db->where('kriteria_id', $kriteria_id);
//     $ci->db->where('nilai', $nilai);
//     $result = $ci->db->get('all_penilaian');

//     if ($result->num_rows() > 0) {
//         return "checked='checked'";
//     }
// }
