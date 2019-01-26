<?php
// LDAP parameters
$hostname = getenv('LDAP_HOST');
$port = intval(getenv('LDAP_PORT'));
$ldap_version = 3;

// Attribute use to identify user on LDAP - ex : uid, mail, sAMAccountName	
$search_attribute = getenv('LDAP_SEARCH_ATTR');

// variable use in resource.php 
$base = getenv('LDAP_BASE_DN');
$filter = getenv('LDAP_FILTER');
if (!is_string($filter)) 
{
   $filter = "";
}

// ldap service user to allow search in ldap
$bind_dn = getenv('LDAP_BIND_DN');
$bind_pass = getenv('LDAP_PASS');

$attributes = array(
    "mail" => getenv('LDAP_MAIL_ATTR'),
    "name" => getenv('LDAP_NAME_ATTR'),
    "username" => getenv('LDAP_USERNAME_ATTR')
);
