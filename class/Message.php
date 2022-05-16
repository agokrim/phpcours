<?php
class Message{

    const LIMIT_USERNAME = 3;
    const LIMIT_MESSAGE = 10;
    private $username;
    private $message;
    private $date;    
    

    public function __construct(string $username, string $message, ?DateTime $date=null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date??new DateTime();


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

    public function toHtml(): string
    {
        return '';
    }

    public function toJSON(): string
    {
        return json_encode([
            'username'=>$this->username,
            'message'=>$this->message,
            'date' => $this->date->getTimestamp()
        ]);

    }

   /* public function message():Message
    {

    }    */
}