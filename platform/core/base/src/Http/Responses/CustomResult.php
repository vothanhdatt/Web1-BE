<?php

namespace Botble\Base\Http\Responses;

class CustomResult
{
    protected $isSuccess = false;
    protected $data = NULL;
    protected $error = false;
    // Construct
    function __construct()
    {
        $this->isSuccess = false;
        $this->data = 'Well, some thing wrong !!';
        $this->error = true;
    }
    // Set Data
    public function setData($data){
        $this->isSuccess = true;
        $this->data = $data;
        $this->error = false;
    }
    // Set Error
    public function setError($error){
        $this->isSuccess = false;
        $this->data = NULL;
        $this->error = $error;
    }
    // To response
    public function toResponse(){
        $response = [
            'isSuccess' => $this->isSuccess,
            'data' => $this->data,
            'error' => $this->error
        ];
        return $response;
    }
}
