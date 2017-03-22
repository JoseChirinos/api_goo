<?php 
use App\Lib\Response,
	App\Validation\UserValidation;



$app->group('/auth/',function(){

	$this->post('autenticar',function($req, $res, $args){

		$parametros = $req->getParsedBody();

		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->Auth->autenticar($parametros['correo'], $parametros['password']))
				   	);	
	});
	
});


 ?>