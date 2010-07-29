<?php
  // these are account wide configuration settings

  // the URL where to the SAML Response/SAML Assertion will be posted
  define('const_assertion_consumer_service_url', "http://localhost:8888/builds/Mango/ent/sugarcrm/index.php?module=Users&action=Authenticate");
  // name of this application
  define('const_issuer', "php-saml");
  // tells the IdP to return the email address of the current user
   define('const_name_identifier_format', "urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress");

  function get_user_settings() {
    // this function should be modified to return the SAML settings for the current user

    $settings                           = new Settings();
    // when using Service Provider Initiated SSO (starting at index.php), this URL asks the IdP to authenticate the user. 
    $settings->idp_sso_target_url       = "https://app.onelogin.com/saml/signon/6774";
    // the certificate for the users account in the IdP
    $settings->x509certificate          = "-----BEGIN CERTIFICATE-----
MIIBrTCCAaGgAwIBAgIBATADBgEAMGcxCzAJBgNVBAYTAlVTMRMwEQYDVQQIDApD
YWxpZm9ybmlhMRUwEwYDVQQHDAxTYW50YSBNb25pY2ExETAPBgNVBAoMCE9uZUxv
Z2luMRkwFwYDVQQDDBBhcHAub25lbG9naW4uY29tMB4XDTEwMDYwMTIxNTY0MFoX
DTE1MDYwMTIxNTY0MFowZzELMAkGA1UEBhMCVVMxEzARBgNVBAgMCkNhbGlmb3Ju
aWExFTATBgNVBAcMDFNhbnRhIE1vbmljYTERMA8GA1UECgwIT25lTG9naW4xGTAX
BgNVBAMMEGFwcC5vbmVsb2dpbi5jb20wgZ8wDQYJKoZIhvcNAQEBBQADgY0AMIGJ
AoGBAOKM1kQspmj0fyIN1i9mWEjXLUD0ZkLgMqGHVI9Ni7w+4YKB3fQV4UWg6Geq
E+UUgR9Ogu/wsxfUcFGk0X9oQaueUgtQp6s9cdx07ZXZT93CuKwvgebDH1BbWXJY
TFtExwgSpVafozcm+d6W6JWW97qEL47nG0hkXUjzloXn+hzjAgMBAAEwAwYBAAMB
AA==
-----END CERTIFICATE-----";

    return $settings;
  }
  
?>