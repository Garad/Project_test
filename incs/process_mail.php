<?php
$mailSent = false;
$suspect = false;
$pattern = '/Content-type:|Bcc:|Cc:/i';
function isSupect($value, $pattern, &$suspect){
  if(is_array($value)){
    foreach ($value as $item){
      isSuspect($item, pattern, $suspect);
    }
  }else {
    if(preg_match($pattern, $value)){
      $suspect = true;
    }
  }
}

//isSuspect($_POST, $pattern, $suspect);
if(!$suspect) :
foreach ($_POST as $key => $value){
  $value = is_array($value) ? $value : trim($value);
  if(empty($value) && in_array($key, $required)){
    $missing[] = $key;
    $$key = '';
  } elseif(in_array($key, $expected)){
    $$key = $value;
  }
}
//validate email user
  if(!$missing && !empty($email)) :
    $validemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if($validemail){
      $headers[] = "Reply-to: $validemail";
    }else {
      $errors['email'] = true;
    }
  endif;
//if no errors create headers and not missing
  if(!$errors && !$missing) :
  $headers = implode("\r\n", $headers);
$message = '';
foreach ($expected as $field) :
	if(isset($$field) && !empty($$field)){
		$val = $$field;
	}else {
		$val = 'Not selected';
	}
// if an array expand to a comma-separated string
	if(is_array($val)){
          $val = implode(', ', $val);
        }
        $field = str_replace('_', '', $field);
        $message .=ucfirst($field) . ": $val\r\n\r\n";
    endforeach;
    $message = wordwrap($message, 70);
    $mailSent = mail($to, $subject, $message, $headers, $authorized);
    if(!mailSent){
        $errors['mailfail'] = true;
    }
  endif;
endif;