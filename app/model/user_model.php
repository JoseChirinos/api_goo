<?php 

namespace App\Model;

use App\Lib\Response,
	App\Lib\Security;

/**
* Modelo usuario
*/
class  UserModel
{
	private $db;
	private $table = 'user';
	private $response;



	public function __CONSTRUCT($db, $db_pdo){
		$this->db 		= $db;
		$this->db_pdo   = $db_pdo;
		$this->response = new Response();
		$this->security = new Security();
	}

	//var $l => 'limit', $p => 'pagina'

	//lista_total
	public function listar(){

		return $data = $this->db->from($this->table)
						 ->orderBy('id DESC')
						 ->fetchAll();
	//  return $data = $this->db_pdo->query('select * from '.$this->table)
	//					 			->fetchAll();				   						 
	}

	//listar paginado
	//parametros de limite, pagina
	public function paginated($l, $p){	
		$p = $p*$l;
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
	public function getUser($id){

		return $data = $this->db->from($this->table, $id)
								->fetch();  						 
	}
	//registrar

	public function insert($data){
		// $data['password'] = md5($data['password']);
		$data['password'] = $this->security->encriptar($data['password']);	

		//$this->db->insertInto($this->table, $data)
		//		 ->execute();
		$this->db_pdo->prepare(" CALL insertUser(	'".$data['name']."',
													'".$data['last_name']."',
													'".$data['email']."',
													'".$data['password']."',
													'".$data['level']."',
													 ".$data['id_picture_user'].",
													 ".$data['mode_online'].",
													 '".$data['data_start']."',
													 ".$data['status'].")")
					  ->execute();

		return $this->response->setResponse(true);
		//  return $data = $this->db_pdo->query('select * from '.$this->table)
		//					 			->fetchAll();
		//call insertUser('Belen','Rodriguez Soliz','elenrodrigu@gmail.com','79302623','1',1,1,'2017-03-03 00:00:00',1);			 
	}
	//actualizar
	public function update($data, $id){

		if (isset($data['password'])) {
			$data['password'] = $this->security->encriptar($data['password']);	
		}

		$this->db->update($this->table, $data, $id)	
				 ->execute();

		return $this->response->setResponse(true);		 
	}
	//eliminar
	public function delete($id){

		$this->db->deleteFrom($this->table, $id)	
				 ->execute();

		return $this->response->setResponse(true);		 
	}


}


 ?>