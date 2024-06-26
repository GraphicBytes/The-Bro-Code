<?php
class tokens {

   var $tokens = "";
   var $md5_tokens = "";

   function set_tokens($tokens) {
     $this->tokens = unserialize($tokens);
   }

   function set_spam_tokens($tokens) {
     $this->md5_tokens = unserialize($tokens);
   }

   function get_token(){
     global $crypt;
     $current_token = $this->tokens[0];
     $current_token = $crypt->encrypt($current_token);
     $current_token = substr($current_token, 0, -2);
     return $current_token;
   }

   function check_token($token){

     global $crypt;
     $valid = 0;
     $this_token = $token."==";

     $this_token_length = strlen($this_token);
     if ($this_token_length > 24) {
       $this_token = $crypt->decrypt($this_token);
       foreach ($this->tokens as $key => $valid_token) {
         if ($this_token == $valid_token) {$valid = 1;}
       }
     }

     return $valid;

   }



   function get_spam_token(){
     $current_token = $this->md5_tokens[0];
     $current_token = md5($current_token);
     return $current_token;
   }

   function check_spam_token($this_token){
      $valid = 0;
      foreach ($this->md5_tokens as $key => $valid_token) {
        if ($this_token == md5($valid_token)) {$valid = 1;}
      }
     return $valid;
   }

}

?>
