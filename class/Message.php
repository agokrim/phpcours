<?php
class Message{

    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;   
    

    public function __construct(string $username, string $message, ?DateTime $date=null)
    {
        $this->username = $username;
        $this->message = $message;

    }

    public function isValid(): bool
    {
       
 
        return  empty($this->getErrors());
    }

     public function geterrors():array
    {
        $errors =  [];
      
        if ( strlen($this->username) < self::LIMIT_USERNAME)
        {
            $errors['username'] = "username court" ;   
        }

        if ( strlen($this->message) < self::LIMIT_MESSAGE)
        {
            $errors['message'] = "message court"  ;  
        }

        return  $errors ;
    }
/*
    public function toHtml():string
    {

    }

    public function toJSON():string
    {

    }

    public function message():Message
    {

    }    */
}