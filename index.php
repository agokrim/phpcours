<?php 
require_once "class/Message.php";
$errors =null;
if (isset($_POST['username'] , $_POST['message']) ){
  $message= new Message($_POST['username'], $_POST['message']);

  

  if (!$message->isValid()){
    $errors  = $message->geterrors();

  }

}
$title="Home";
require "elements/header.php";
?>

<div class="container">


<h2>Gest Book </h2>

<pre>  <?php var_dump($message->geterrors()) ?>  </pre>
<pre>  <?php var_dump($errors) ?>  </pre>

  <?php if (!empty($errors)):?>
    <div class="alert alert-danger">
      Formulaire invalid
    </div>
  <?php  endif?>



<form action="" method="POST">
  <div class="form-group">
    <label for=" username">Pseudo:</label><br>
    <input type="text" id="username" name="username" class="form-control <?= isset($errors['username'])? 'is-invalid':''?>"" />
    <?php if(isset($errors['username'])):?>
      <div class="invalid-feedback">
        <?= $errors['username']?>
      </div>
    <?php endif ?>
  </div>
  <div class="form-group">
    <label for="message">Message:</label><br>
    <textarea rows="4  id="message" name="message" class="form-control <?= isset($errors['message'])? 'is-invalid':''?>"></textarea>
  
    <?php if(isset($errors['message'])):?>
      <div class="invalid-feedback">
        <?= $errors['message']?>
      </div>
    <?php endif ?>
  </div>
  
  <input type="submit" value="Submit" class="btn btn-primary"/>
</form> 

<h2>Messages </h2>
<p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>
</div>
<?php 
require "elements/footer.php";
?>