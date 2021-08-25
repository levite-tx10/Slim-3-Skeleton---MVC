<?php

namespace App\Controllers;

// Database PDO
use PDO;
use PDOException;

// validation
use Respect\Validation\Validator as v;

// Model
use App\Models\UserTest;

class UserController extends BaseController{

    /* get all the data from the database */
    public function read($request, $response){

        $Objuser = new UserTest();
        $Objuser->dbh = $this->c->db;
        $modelResponse = $Objuser->read();

        /* logging Data */
        $logger = $this->c->logger;
        $logger->info("Logger Working");

        $code = 200;
        $payload = array('code'=>"$code",'status'=>"success",'message'=>"Data Found",'data' => $modelResponse);
        return $response->withJson($payload);



    }

    /* insert data */
    public function create($request,$response,$args){

        /* validation check for the post parameters */
        $validate = $this->c->validator;
        $validator = $validate->validate($request, [
            'email' => v::noWhitespace()->notEmpty(),
            'name' => v::notEmpty()
        ]);

        if ($validator->isValid()) {

            // pass data to model
            $Objuser = new UserTest();
            $Objuser->dbh = $this->c->db;
            $Objuser->name = $request->getParam('name');
            $Objuser->email = $request->getParam('email');
            $Objuser->date_created = date("Y-m-d H:i:s");
            $modelResponse = $Objuser->create();
            if ($modelResponse === 1) {
                //$data = $this->getUserById($last_inserted_id);
                $payload = array('status' => "success", 'Message' => "User Created");
                return $response->withJson($payload);
            } elseif ($modelResponse === 2) {
                $error_payload = array('status' => "failed", 'error-message' => "Record Exits");
                return $response->withStatus(400)->withJson($error_payload);

            }else {
                $error_payload = array('status' => "failed", 'error-message' => $modelResponse);
                return $response->withStatus(400)->withJson($error_payload);
            }

        } else {
            $errors = $validator->getErrors();
            $payload = array('status'=>"failed",'Message'=>"Parameter Missing",'Error' => $errors);
            return $response->withStatus(400)->withJson($payload);
        }


    }

    /* update data */
    public function update($request,$response,$args){

        $Objuser = new UserTest();
        $Objuser->dbh = $this->c->db;
        $Objuser->id = $args['id'];
        $Objuser->name = $request->getParam('name');
        $Objuser->email = $request->getParam('email');
        $Objuser->date_updated = date("Y-m-d H:i:s");
        $modelResponse = $Objuser->update();
        if($modelResponse === 1){
            $payload = array('status'=>"success",'Message'=>"User Updated");
            return $response->withJson($payload);
        }else{
            $error_payload = array('status'=>"failed",'error-message'=>$modelResponse);
            return $response->withStatus(400)->withJson($error_payload);
        }

    }

    /* delete data*/
    public function delete($request,$response,$args){
        // get parameters
        $id = $args['id'];

        // check if the user exists
        if($this->getUserById($id) === null){
            $payload = "User Does Not Exists";
            return $response->withStatus(404)->withJson($payload);
        }

        // submit data to model
        $Objuser = new UserTest();
        $Objuser->dbh = $this->c->db;
        $Objuser->id = $id;
        $modelResponse = $Objuser->delete();
        if($modelResponse === 1){
            $payload = array('status'=>"success",'Message'=>"User Deleted");
            return $response->withJson($payload);
        }else{
            $error_payload = array('status'=>"failed",'error-message'=>$modelResponse);
            return $response->withStatus(400)->withJson($error_payload);
        }
    }

    /* get data by id */
    public function show($request,$response,$args){

        $user = $this->getUserById($args['id']);

        /* check if user exists */
        if($user === null){

            $payload = array('status'=>"failed",'message'=>"Data Not Found");
            return $response->withStatus(404)->withJson($payload);
        }

        return $response->withJson($user);

    }

    /* fetch data from the database using the id
     * reusable function
    */
    protected function getUserById($id){
        $Objuser = new UserTest();
        $Objuser->dbh = $this->c->db;
        $Objuser->id = $id;
        $modelResponse = $Objuser->getUserById();
        return $modelResponse;

    }





}