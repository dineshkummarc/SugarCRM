<?php
  // these are account wide configuration settings

  // the URL where to the SAML Response/SAML Assertion will be posted
  define('const_assertion_consumer_service_url', $GLOBALS['sugar_config']['site_url']. "/index.php?module=Users&action=Authenticate");
  // name of this application
  define('const_issuer', "php-saml");
  // tells the IdP to return the email address of the current user
   define('const_name_identifier_format', "urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress");

  function get_user_settings() {
    // this function should be modified to return the SAML settings for the current user

    $settings                           = new Settings();
    // when using Service Provider Initiated SSO (starting at index.php), this URL asks the IdP to authenticate the user. 
    $settings->idp_sso_target_url       = $GLOBALS['sugar_config']['SAML_loginurl'];
    
    // the certificate for the users account in the IdP
    $settings->x509certificate          = $GLOBALS['sugar_config']['SAML_X509Cert'];

    return $settings;
  }
  
?>
