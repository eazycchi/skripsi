<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ranking_model extends CI_Model
{

    public function deletekriteria($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('kriteria');
    }

    public function data_awal($kegiatan_id)
    {

        $query = "SELECT all_kegiatan_pencacah.kegiatan_id as kegiatan_id, all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        $temp = $this->db->query($query)->result();
        // var_dump($temp);
        // die;

        $result['data'] = array();
        foreach ($temp as $data) {
            $data->nilai = $this->nilai($data->kegiatan_id, $data->id_mitra, $data->kriteria_id);
            $result['data'][] = $data;
        }
        return $result;
    }

    public function nilai($kegiatan_id, $id_mitra, $kriteria_id)
    {
        $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";
        $result = $this->db->query($query)->result();

        // var_dump($result);
        // die;
        return $result;
    }

    public function normalized($kegiatan_id)
    {

        $query = "SELECT all_kegiatan_pencacah.kegiatan_id as kegiatan_id, all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        $temp = $this->db->query($query)->result();
        // var_dump($temp);
        // die;

        $result['data'] = array();
        foreach ($temp as $data) {
            $data->bobotsk = $this->bobot_sk($data->kegiatan_id, $data->id_mitra, $data->kriteria_id);
            $result['data'][] = $data;
        }
        return $result;
    }

    public function bobot_sk($kegiatan_id, $id_mitra, $kriteria_id)
    {
        $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai, subkriteria.bobot as bobotsk FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";
        $result = $this->db->query($query)->result();

        // var_dump($result);
        // die;
        return $result;
    }

    public function utility($kegiatan_id)
    {


        $query = "SELECT all_kegiatan_pencacah.kegiatan_id as kegiatan_id, all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        // $query = "SELECT kegiatan_id, id_mitra, kriteria_id, nilai FROM all_penilaian WHERE kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        $temp = $this->db->query($query)->result();
        $result['data'] = array();
        foreach ($temp as $data) {
            $data->bobot = $this->bobot($data->kegiatan_id, $data->id_mitra, $data->kriteria_id, $data->nilai);
            $result['data'][] = $data;
        }
        return $result;
    }

    public function bobot($kegiatan_id, $id_mitra, $kriteria_id, $nilai)
    {
        $queryminbobot = "SELECT min(subkriteria.bobot) as minbobot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_penilaian.kriteria_id = $kriteria_id";
        // $ut = $this->db->query($queryminbobot)->result();
        // return $ut;

        $querymaxbobot = "SELECT max(subkriteria.bobot) as maxbobot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_penilaian.kriteria_id = $kriteria_id";

        $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai, subkriteria.bobot as bobotsk, ((subkriteria.bobot - ($queryminbobot))/(($querymaxbobot) - ($queryminbobot))) as ut FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id  WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";

        // bener
        // $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai, kriteria.bobot*subkriteria.bobot as bobot FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";

        // $query = "SELECT all_penilaian.id_mitra, all_penilaian.kriteria_id, all_penilaian.nilai, kriteria.bobot*subkriteria.bobot as bobot FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai WHERE all_penilaian.kegiatan_id = $kegiatan_id AND all_penilaian.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY all_penilaian.id_mitra, all_penilaian.kriteria_id ORDER BY all_penilaian.id_mitra, all_penilaian.kriteria_id ";
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function total($kegiatan_id)
    {
        $query = "SELECT all_kegiatan_pencacah.kegiatan_id as kegiatan_id, all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        $temp = $this->db->query($query)->result_array();
        // $result['data'] = array();
        foreach ($temp as $data) {
            $data['bobot'] = $this->totalakhir($data['kegiatan_id'], $data['id_mitra'], $data['kriteria_id'], $data['nilai']);
            $result['data'][] = $data;
        }
        return $result;
    }

    public function totalakhir($kegiatan_id, $id_mitra, $kriteria_id, $nilai)
    {
        $queryminbobot = "SELECT min(subkriteria.bobot) as minbobot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_penilaian.kriteria_id = $kriteria_id";

        $querymaxbobot = "SELECT max(subkriteria.bobot) as maxbobot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_penilaian.kriteria_id = $kriteria_id";

        $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai, subkriteria.bobot as bobotsk, kriteria.bobot*((subkriteria.bobot - ($queryminbobot))/(($querymaxbobot) - ($queryminbobot))) as ut FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id  WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";

        $result = $this->db->query($query)->result_array();

        $ut =  $result[0]['ut'];
        // var_dump($ut);
        // die;
        $q1 = "SELECT id FROM all_kegiatan_pencacah WHERE kegiatan_id = $kegiatan_id AND id_mitra = $id_mitra";
        $hq1 = implode($this->db->query($q1)->row_array());
        $q = "UPDATE all_penilaian SET t_bobot = '$ut' WHERE all_kegiatan_pencacah_id = $hq1 AND kriteria_id = $kriteria_id";
        $this->db->query($q);

        // var_dump($result);
        // die;
        return $result;
    }

    // public function total_utility($kegiatan_id)
    // {
    //     $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, SUM(kriteria.bobot*subkriteria.bobot) as bobot
    //     FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id
    //     WHERE all_penilaian.kegiatan_id = $kegiatan_id
    //     GROUP BY all_penilaian.id_mitra
    //     ORDER BY all_penilaian.id_mitra";

    //     // $query = "SELECT all_penilaian.id_mitra as id_mitra, SUM(kriteria.bobot*subkriteria.bobot) as bobot
    //     // FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai
    //     // WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id
    //     // GROUP BY id_mitra
    //     // ORDER BY id_mitra";

    //     $result = $this->db->query($query)->result();
    //     return $result;
    // }
    public function ranking($kegiatan_id)
    {


        $query = "SELECT all_kegiatan_pencacah.kegiatan_id as kegiatan_id, all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        // $query = "SELECT kegiatan_id, id_mitra, kriteria_id, nilai FROM all_penilaian WHERE kegiatan_id = $kegiatan_id GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id";

        $temp = $this->db->query($query)->result();
        $result['data'] = array();
        foreach ($temp as $data) {
            $data->bobot = $this->akhir($data->kegiatan_id, $data->id_mitra, $data->kriteria_id, $data->nilai);
            $result['data'][] = $data;
        }
        return $result;
    }

    public function akhir($kegiatan_id, $id_mitra, $kriteria_id, $nilai)
    {
        $queryminbobot = "SELECT min(subkriteria.bobot) as minbobot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_penilaian.kriteria_id = $kriteria_id";
        // $ut = $this->db->query($queryminbobot)->result();
        // return $ut;

        $querymaxbobot = "SELECT max(subkriteria.bobot) as maxbobot FROM all_penilaian JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id JOIN subkriteria ON all_penilaian.nilai = subkriteria.nilai WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_penilaian.kriteria_id = $kriteria_id";

        $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai, subkriteria.bobot as bobotsk, kriteria.bobot*((subkriteria.bobot - ($queryminbobot))/(($querymaxbobot) - ($queryminbobot))) as ut FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id  WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";

        // bener
        // $query = "SELECT all_kegiatan_pencacah.id_mitra as id_mitra, all_penilaian.kriteria_id as kriteria_id, all_penilaian.nilai as nilai, kriteria.bobot*subkriteria.bobot as bobot FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai JOIN all_kegiatan_pencacah ON all_penilaian.all_kegiatan_pencacah_id = all_kegiatan_pencacah.id WHERE all_kegiatan_pencacah.kegiatan_id = $kegiatan_id AND all_kegiatan_pencacah.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY id_mitra, kriteria_id ORDER BY id_mitra, kriteria_id ";

        // $query = "SELECT all_penilaian.id_mitra, all_penilaian.kriteria_id, all_penilaian.nilai, kriteria.bobot*subkriteria.bobot as bobot FROM all_penilaian JOIN kriteria ON all_penilaian.kriteria_id = kriteria.id JOIN subkriteria  ON all_penilaian.nilai = subkriteria.nilai WHERE all_penilaian.kegiatan_id = $kegiatan_id AND all_penilaian.id_mitra = $id_mitra AND all_penilaian.kriteria_id = $kriteria_id AND all_penilaian.nilai = $nilai GROUP BY all_penilaian.id_mitra, all_penilaian.kriteria_id ORDER BY all_penilaian.id_mitra, all_penilaian.kriteria_id ";
        $result = $this->db->query($query)->result();
        return $result;
    }
}
