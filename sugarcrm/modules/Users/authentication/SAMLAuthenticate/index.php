<?php
require 'modules/Users/authentication/SAMLAuthenticate/settings.php';
require 'modules/Users/authentication/SAMLAuthenticate/lib/onelogin/saml.php';
  
  $authrequest = new AuthRequest();
  $authrequest->user_settings = get_user_settings();
  $url = $authrequest->create();

  header("Location: $url");