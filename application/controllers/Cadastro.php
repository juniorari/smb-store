<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cadastro extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('cadastro_model', 'cadastro');

    }
    public function index() {
        $this->load->view('template/header');
        $this->load->view('cadastro/index');
        $this->load->view('template/footer');
    }
    function buscaTodos() {
        $query = $this->cadastro->buscaTodos();
        if ($query) {
            $result['cadastros'] = $this->cadastro->buscaTodos();
        }
        echo json_encode($result);
    }
    function adicionaCadastro() {
        $config = array(
            array('field' => 'nome',
                'label' => 'Nome',
                'rules' => 'trim|required',
            ),
            array('field' => 'sobrenome',
                'label' => 'Sobrenome',
                'rules' => 'trim|required',
            ),
            array('field' => 'sexo',
                'label' => 'Sexo',
                'rules' => 'required',
            ),
            array('field' => 'nascimento',
                'label' => 'Nascimento',
                'rules' => 'trim|required',
            ),
            array('field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'fone',
                'label' => 'Fone',
                'rules' => 'trim|required',
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE || !count($_FILES) || $_FILES['imagem']['error']) {
            $result['error'] = true;
            $result['msg'] = array(
                'nome' => form_error('nome'),
                'sobrenome' => form_error('sobrenome'),
                'sexo' => form_error('sexo'),
                'nascimento' => form_error('nascimento'),
                'email' => form_error('email'),
                'fone' => form_error('fone'),
                'imagem' => 'Imagem é ' . (!count($_FILES) ? 'obrigatória' : 'inválida'),
            );

        } else {

			$cnfimg['upload_path'] = './uploads/';
			$cnfimg['allowed_types'] = 'gif|jpg|png';
			$cnfimg['max_size'] = 4096; // 4MB
			$cnfimg['encrypt_name'] = TRUE;

			$this->load->library('upload', $cnfimg);
			if (!$this->upload->do_upload('imagem')) {
				$result['error'] = true;
				$result['msg'] = array(
					'nome' => form_error('nome'),
					'sobrenome' => form_error('sobrenome'),
					'sexo' => form_error('sexo'),
					'nascimento' => form_error('nascimento'),
					'email' => form_error('email'),
					'fone' => form_error('fone'),
					'imagem' => strip_tags($this->upload->display_errors()),
				);
				echo json_encode($result);
				return true;
			}
			$uploadData = $this->upload->data();

            $data = array(
                'nome' => $this->input->post('nome'),
                'sobrenome' => $this->input->post('sobrenome'),
                'sexo' => $this->input->post('sexo'),
                'nascimento' => $this->input->post('nascimento'),
                'email' => $this->input->post('email'),
                'fone' => $this->input->post('fone'),
            );
			if (isset($uploadData)) {
				$data['foto'] = 'uploads/' . $uploadData['file_name'];
			}
            if ($this->cadastro->adicionaCadastro($data)) {
                $result['error'] = false;
                $result['msg'] = 'Cadastro adicionado com sucesso!';
                $result['files'] = $_FILES;
            }

        }
        echo json_encode($result);
    }

    function atualizaCadastro() {
        $config = array(
            array('field' => 'nome',
                'label' => 'Nome',
                'rules' => 'trim|required',
            ),
            array('field' => 'sobrenome',
                'label' => 'Sobrenome',
                'rules' => 'trim|required',
            ),
            array('field' => 'sexo',
                'label' => 'Sexo',
                'rules' => 'required',
            ),
            array('field' => 'nascimento',
                'label' => 'Nascimento',
                'rules' => 'trim|required',
            ),
            array('field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required',
            ),
            array(
                'field' => 'fone',
                'label' => 'Fone',
                'rules' => 'trim|required',
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE || (count($_FILES) && $_FILES['imagem']['error'])) {
            $result['error'] = true;
            $result['msg'] = array(
                'nome' => form_error('nome'),
                'sobrenome' => form_error('sobrenome'),
                'sexo' => form_error('sexo'),
                'nascimento' => form_error('nascimento'),
                'email' => form_error('email'),
                'fone' => form_error('fone'),
                'imagem' => "Imagem inválida!",
            );

        } else {

			if (count($_FILES) && !$_FILES['imagem']['error']) {

				$cnfimg['upload_path'] = './uploads/';
				$cnfimg['allowed_types'] = 'gif|jpg|png';
				$cnfimg['max_size'] = 4096; // 4MB
				$cnfimg['encrypt_name'] = TRUE;

				$this->load->library('upload', $cnfimg);
				if (!$this->upload->do_upload('imagem')) {
					$result['error'] = true;
					$result['msg'] = array(
						'nome' => form_error('nome'),
						'sobrenome' => form_error('sobrenome'),
						'sexo' => form_error('sexo'),
						'nascimento' => form_error('nascimento'),
						'email' => form_error('email'),
						'fone' => form_error('fone'),
						'imagem' => strip_tags($this->upload->display_errors()),
					);
					echo json_encode($result);
					return true;
				} else {
					$uploadData = $this->upload->data();
				}

			}


			$id = $this->input->post('id');
            $data = array(
                'nome' => $this->input->post('nome'),
                'sobrenome' => $this->input->post('sobrenome'),
                'sexo' => $this->input->post('sexo'),
                'nascimento' => $this->input->post('nascimento'),
                'email' => $this->input->post('email'),
                'fone' => $this->input->post('fone'),
            );
			if (isset($uploadData)) {
				$data['foto'] = 'uploads/' . $uploadData['file_name'];
			}
            if ($this->cadastro->atualizaCadastro($id, $data)) {
                $result['error'] = false;
//                $result['foto'] = base_url('uploads/' . $uploadData['file_name']);
                $result['success'] = 'Cadastro atualizado com sucesso!';
            }

        }
		$result['file'] = $_FILES;
        echo json_encode($result);
    }

    function removeCadastro() {
        $id = $this->input->post('id');
        if ($this->cadastro->removeCadastro($id)) {
            $msg['error'] = false;
            $msg['success'] = 'Cadastro apagado com sucesso!';
        } else {
            $msg['error'] = true;
        }
        echo json_encode($msg);

    }
    function searchCadastro() {

		$campo = $this->input->get('campo') ?? 'nome';
		$value = $this->input->post('text');
		if ($campo == 'email') {
			$value = $this->input->post('email');
		}
        $query = $this->cadastro->searchCadastro($value, $campo);
        if ($query) {
            $result['cadastros'] = $query;
        }

        echo json_encode($result);

    }
}
