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

    public static function fromJSON(string $json): Message
    {
        $data= json_decode($json,true);
          
        return new self ($data['username'],$data['message'],new DateTime("@".$data['date']));

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
        $this->date->setTimezone(new DatetimeZone('Europe/Paris'));
        $username = htmlentities($this->username);
        $message = htmlentities($this->message);
        $date = $this->date->format('d/m/Y à H:i');
        return <<<HTML
        <div>
            <p><strong>{$username}</strong>-<span><span>{$date} </p>
            <blockquote>{$message}</blockquote>
        </div>
        HTML;
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