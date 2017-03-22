<?php 

namespace App\Model;

use App\Lib\Response,
	App\Lib\Auth;

/**
* Modelo usuario
*/
class  AuthModel
{
	private $db;
	private $table = 'user';
	private $response;



	public function __CONSTRUCT($db){
		$this->db = $db;
		$this->response = new Response();
	}
	
	public function autenticar($correo, $password){

		$user = $this->db->from($this->table)
							 ->where('correo', $correo)
							 ->where('password', md5($password))
							 ->fetch();

		if(is_object($user)){
			//obtener el primer nombre
			$nombre = explode(' ', $user->nombre)[0];


			$token = Auth::SignIn([
				'id'      => $user->id,
				'nombre'  => $user->nombre,
				'correo'  =>$user->correo	
			]);

			$this->response->result = $token;
			return $this->response->setResponse(true);

		}else{
			return $this->response->setResponse(false, "Credenciales no validas");
		}					 
	}



}


 ?>