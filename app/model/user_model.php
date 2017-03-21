<?php 

namespace App\Model;

use App\Lib\Response;

/**
* Modelo usuario
*/
class  UserModel
{
	private $db;
	private $table = 'User';
	private $response;



	public function __CONSTRUCT($db){
		$this->db = $db;
		$this->response = new Response();
	}
	//var $l => 'limit', $p => 'pagina'

	//lista_total
	public function listar(){

		return $data = $this->db->from($this->table)
						 ->orderBy('id DESC')
						 ->fetchAll();  						 
	}

	//listar paginado
	public function listar_paginado($l, $p){	
		$p = $p*5;
		$data = $this->db->from($this->table)
						 ->limit($l)
						 ->offset($p)
						 ->orderBy('id desc')
						 ->fetchAll();

		$total = $this->db->from($this->table)
						  ->select('COUNT(*) Total')
						  ->fetch()
						  ->Total;

		return [
			'data'	=>   $data,
			'total' =>   $total

		];				  						 
	}
	//obtener
	public function obtener($id){

		return $data = $this->db->from($this->table, $id)
								->fetch();  						 
	}
	//registrar

	public function registrar($data){
		$data['password'] = md5($data['password']);	

		$this->db->insertInto($this->table, $data)
				 ->execute();

		return $this->response->setResponse(true);		 
	}
	//actualizar
	public function actualizar($data, $id){

		if (isset($data['password'])) {
			$data['password'] = md5($data['password']);
		}

		$this->db->update($this->table, $data, $id)	
				 ->execute();

		return $this->response->setResponse(true);		 
	}
	//eliminar
	public function eliminar($id){

		$this->db->deleteFrom($this->table, $id)	
				 ->execute();

		return $this->response->setResponse(true);		 
	}


}


 ?>