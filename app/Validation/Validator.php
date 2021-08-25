<?php

namespace App\Validation;

use Respect\Valication\Validator as Respect;
use Respect\Valication\Exceptions\NestedValidationException;

class Validator {
    protected $errors;

    public function validate($request,array $rules){
        foreach($rules as $field => $rule){

            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));

            }catch(NestedValidationException $e){
                $this->errors[$field] = $e->getMessages();
            }

        }

        var_dump($this->errors);
        die();

    }

}