<?php 
use App\Lib\Response,
	App\Lib\Auth,
	App\Validation\UserValidation,
	App\Middleware\AuthMiddleware;


$app->group('/user/',function(){

	$this->get('listar',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->User->listar())
				   	);	
	});

	$this->get('listar-paginado/{l}/{p}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->User->listar_paginado($args['l'], $args['p']))
				   		
				   	);
	});

	$this->get('obtener/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->User->obtener($args['id']))
				   		
				   	);
	});

	$this->post('registrar',function($req, $res, $args){
		$r = UserValidation::validate($req->getParsedBody());

		if(!$r->response){
			return $res->withHeader('Content-type', 'aplication/json')
					   ->withStatus(422)
					   ->write(json_encode($r->errors));
		}

		return $res->withHeader('Content-type', 'aplication/json')
			       -> write(
						json_encode($this->model->User->registrar($req->getParsedBody()))

				   	);
	});

	$this->put('actualizar/{id}',function($req, $res, $args){

		$r = UserValidation::validate($req->getParsedBody());

		if(!$r->response){
			return $res->withHeader('Content-type', 'aplication/json')
					   ->withStatus(422)
					   ->write(json_encode($r->errors));
		}
		
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->User->actualizar($req->getParsedBody(), $args['id'] ))
				   		
				   	);
	});

	$this->delete('eliminar/{id}',function($req, $res, $args){
		return $res->withHeader('Content-type', 'aplication/json')
				   ->write(
				   		json_encode($this->model->User->eliminar($args['id']))
				   		
				   	);

	});
	
})->add(new AuthMiddleware($app));

//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE0OTAxMTU5NTIsImF1ZCI6ImMyY2YzMmZjNjc5ODEwZjZiMjUzNDk1NDk3OGMzODc1ZmFkNmMwNDYiLCJkYXRhIjp7ImlkIjoiMyIsIm5vbWJyZSI6IkJlbmphbWluIENhc3RpbGxvIiwiY29ycmVvIjoiY2FzdGlsbG9lZ3VlemJlbmppQGdtYWlsLmNvbSJ9fQ.jivwyv-ozKyov5p33lIQTpleVx2vjyMjlMO5Lb-1-4g
 ?>