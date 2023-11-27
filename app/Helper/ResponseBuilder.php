<?php
class ResponseBuilder{

    private $success;
    private $message;
    private $data;
    private $httpcode;
    private $token;
    private $meta;
    private $link;

    public function __construct($success){

        $this->success=$success;
    }

    public static function success($msg=null,$code=200,$data=null){
        return  self::asSucess()
            ->withData($data)
            ->withMessage($msg)
            ->withHttpCode($code)
            ->build();
    }
    public static function successWithToken($msg=null,$code=200,$token=null,$data=null){
        return  self::asSucess()
            ->withData($data)
            ->withMessage($msg)
            ->withHttpCode($code)
            ->withAuthToken($token)
            ->build();
    }

    public static function successWithPaginate($msg=null,$code=200,$query,$data){
        return self::asSucess()
            ->withData($data)
            ->withMessage($msg)
            ->withHttpCode($code)
            ->withPagination($query)
            ->build();

    }

    public static function fail($msg=null,$code=400,$data=null){
      return  self::asFail()
            ->withData($data)
            ->withMessage($msg)
            ->withHttpCode($code)
            ->build();
    }

   public static function asSucess() : self {
        return new self(true);
   }
    public static function asFail() : self
    {
        return new self(false);
    }

    public function withMessage($message=null){
          $this->message=$message;
        return $this;
    }


    public function withData($data=null){
            $this->data = $data;
            return $this;
    }

    public function withHttpCode($code){
            $this->httpcode = $code;
            return $this;
    }

    public function withAuthToken($token){

        $this->token = $token;
        return $this;
    }

    public function withPagination($query) {
        $this->meta = [
            'total_page' => $query->lastPage(),
            'current_page' => $query->currentPage(),
            'total_item' => $query->total(),
            'per_page' => (int)$query->perPage(),
        ];

        $this->link = [
            'next' => $query->hasMorePages(),
            'prev' => boolval($query->previousPageUrl())
        ];

        return $this;
    }

    public function build(){

                $response['success']=$this->success;
            !is_null($this->message) && $response['message']=$this->message;
            !is_null($this->token) && $response['auth_token'] = $this->token;
            !is_null($this->data) && $response['data'] = $this->data;
            !is_null($this->meta) && $response['meta'] = $this->meta;
            !is_null($this->link) && $response['link'] = $this->link;
                return response($response,$this->httpcode);
    }


 }
