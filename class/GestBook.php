<?php
require_once "Message.php";
class GestBook{

    private $file;

    function __construct(string $file){
        $directory =dirname($file);
        if(!is_dir($directory))
        {
            mkdir($directory,0777,true);
        }
        if(!file_exists($file))
        {
            touch($file);
        }
        $this->file = $file;
    }

    public function addMessage(Message $message)
    {
        
        file_put_contents($this->file , $message->toJSON() . PHP_EOL , FILE_APPEND);
    }

    public function getMessage():array
    {
        $content= trim(file_get_contents($this->file));
        $lines= explode(PHP_EOL,$content);
        $messages =[];
        foreach ($lines as $line)
        {
            $data= json_decode($line,true);
          
            $messages[] = new Message ($data['username'],$data['message'],new DateTime("@".$data['date']));
        } 
        return  array_reverse($messages);

    } 

}