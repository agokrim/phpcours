<?php 
require_once "class/Message.php";
require_once "class/GestBook.php";
$errors =null;
$success =false;

if (isset($_POST['username'] , $_POST['message']) ){
  $message= new Message($_POST['username'], $_POST['message']);

  $gestbook= new GestBook(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'message');

  if ($message->isValid()){
   
 
    $gestbook->addMessage($message);
    $success = true;
    $_POST =[];
  }else{
    $errors  = $message->geterrors();
  }

  $messages = $gestbook->getMessage();

}



$title="Home";
require "elements/header.php";
?>

<div class="container">


<h2>Gest Book </h2>


  <?php if (!empty($errors)):?>
    <div class="alert alert-danger">
      Formulaire invalid
    </div>
  <?php  endif?>

  <?php if ($success):?>
    <div class="alert alert-success">
      Merci pour votre message
    </div>
  <?php  endif?>



<form action="" method="POST">
  <div class="form-group">
    <label for=" username">Pseudo:</label><br>
    <input type="text" id="username" name="username" value="<?= htmlentities( $_POST['username']??'')?>" class="form-control <?= isset($errors['username'])? 'is-invalid':''?>" />
    <?php if(isset($errors['username'])):?>
      <div class="invalid-feedback">
        <?= $errors['username']?>
      </div>
    <?php endif ?>
  </div>
  <div class="form-group">
    <label for="message">Message:</label><br>
    <textarea rows="4  id="message" name="message"   class="form-control <?= isset($errors['message'])? 'is-invalid':''?>"><?= htmlentities($_POST['message']??'')?></textarea>
  
    <?php if(isset($errors['message'])):?>
      <div class="invalid-feedback">
        <?= $errors['message']?>
      </div>
    <?php endif ?>
  </div>
  
  <input type="submit" value="Submit" class="btn btn-primary"/>
</form> 

<h2>Messages abdou </h2>
<hr>
<?php
if(isset($message)){

 
  foreach($messages as $message):
    
   echo($message->toHtml());
  endforeach;
} 
?>
</div>
<?php 
require "elements/footer.php";
?>
