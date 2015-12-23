<?php
$errors = [];
$missing = [];
if(isset($_POST['send'])){
  $expected = ['name', 'email', 'msg'];
  $required = ['name', 'msg'];
  $to = 'Mohamud <faaqir1@gmail.com>';
  $subject = 'Feedback from online form';
  $headers = [];
  $headers[] = 'From: webmaster@example.com';
  $headers[] = 'Content-type: text/plain; charset=utf-8';
  $authorized[] = '-mahmood@gmail.com';
  require './incs/process_mail.php';
  if($mailSent) {
      header('Location: thanks.php');
      exit;
}
}
include './incs/header.html';
?>

<div class="container">
  <h2>We Would love to hear from you!</h2>
  <h3>Please fill up the following form</h3>
  <?php if($_POST && $suspect) : ?>
  <?php elseif($errors && ($suspect || isset($errors['mailfail']))) : ?>
  <p class="warning">Sorry, your email couldn't be sent.</p>
  <span class="warning"> Please fix items indicated</span>
  <?php endif; ?>
  <form class="form-horizontal" role="form" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
     <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:
       <?php  if($missing && in_array('name', $missing)) : ?>
        <span class="warning">Please enter your name</span>
        <?php endif; ?>
       </label>
      <div class="col-sm-8">
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full Name"
               <?php
               if($errors || $missing){
                 echo 'value="' . htmlentities($name) . '"';
               }
               ?>
               >
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:
          <?php  if($missing && in_array('email', $missing)) : ?>
        <span class="warning">Please enter your email address</span>
        <?php elseif(isset($errors['$email'])) : ?>
          <span class="warning">Invalid Email Address</span>
        <?php endif; ?>
      </label>
      <div class="col-sm-8">
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email"
               <?php
               if($errors || $missing){
                 echo 'value="' . htmlentities($email) . '"';
               }
               ?>               
               >
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="msg">Message:
        <?php  if($missing && in_array('msg', $missing)) : ?>
        <span class="warning">Please enter your message</span>
        <?php endif; ?>
      </label>
      <div class="col-sm-8">          
        <textarea name="msg" class="form-control" id="msg" placeholder="Enter Your Message"><?php
          if($errors || $missing){
            echo htmlentities($msg);
          }  
          ?></textarea>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit"  class="btn btn-lg btn-success" name="send">Submit</button>
      </div>
    </div>
  </form>
</div>
</body>
</html>