<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Candidate extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Candidate_model');
    }

    public function index()
    {
        $this->load->helper('url');
        $data['list'] = $this->Candidate_model->get_rows();
        $this->load->view('candidate/list', $data);
    }

    public function ajax_list()
    {
        $list = $this->Candidate_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $candidate) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $candidate->nama;
            $row[] = $candidate->jabatan;
            $row[] = $candidate->jenis_kelamin;
            $row[] = $candidate->alamat;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="editCandidate('."'".$candidate->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="deleteCandidate('."'".$candidate->id."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';
            $data[] = $row;
        }
        $output = array(
                        "recordsTotal" => $this->Candidate_model->count_all(),
                        "recordsFiltered" => $this->Candidate_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->Candidate_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $this->_validate();
        $data = array(
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat' => $this->input->post('alamat')
            );
        $insert = $this->Candidate_model->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'alamat' => $this->input->post('alamat')
            );
        $this->Candidate_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->Candidate_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_list_delete()
     {
         $list_id = $this->input->post('id');
         foreach ($list_id as $id) {
             $this->Candidate_model->delete_by_id($id);
         }
         echo json_encode(array("status" => TRUE));
     }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('nama') == '')
        {
            $data['inputerror'][] = 'nama';
            $data['error_string'][] = 'Nama tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if($this->input->post('jabatan') == '')
        {
            $data['inputerror'][] = 'jabatan';
            $data['error_string'][] = 'Jabatan tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if($this->input->post('alamat') == '')
        {
            $data['inputerror'][] = 'alamat';
            $data['error_string'][] = 'Alamat tidak boleh kosong.';
            $data['status'] = FALSE;
        }

        if($this->input->post('jenis_kelamin') == '')
        {
            $data['inputerror'][] = 'jenis_kelamin';
            $data['error_string'][] = 'Jenis kelamin tidak boleh kosong ';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function import_data()
    {
      $url = $this->input->post('url');

      if($this->input->post('url') == '')
      {
          $data['inputerror'][] = 'url';
          $data['error_string'][] = 'URL tidak boleh kosong ';
          $data['status'] = FALSE;
      }

      $json = file_get_contents($url);
    
      // Decode the JSON file
      $json_data = json_decode($json,true);
      
      $data = array();
      foreach ($json_data as $key => $value) {
          $data['nama'] = $value['nama'];
          $data['jabatan'] = $value['jabatan'];
          $data['jenis_kelamin'] = $value['jenis_kelamin'];
          $data['alamat'] = $value['alamat'];
          $insert = $this->Candidate_model->save($data);
      }

      if($insert){
        $data['status'] = true;
        echo json_encode($data);
      }
      
    }
}
