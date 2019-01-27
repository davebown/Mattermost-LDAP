Mattermost-LDAP Docker container
================================

This docker container provides an external LDAP authentication in Mattermost for the Team Edition (free).

## Overview

Currently, LDAP authentication in Mattermost is not featured in the Team Edition (only in the Enterprise Edition). Thus, the only way to get LDAP authentication in Mattermost is to install Gitlab and use its Single Sign On (SSO) feature. Gitlab allows LDAP authentication and transmits user data to Mattermost. So, anyone who wishes to use LDAP with Mattermost must run Gitlab, even if he does not use it, for the SSO feature. 

However, although Gitlab is a nice software, it is resources-consuming and a bit complicated to manage if you just want the SSO feature. That's the reason why, this module provides an oauth server to only reproduce the Gitlab SSO feature and allows a simple and secure LDAP authentication to Mattermost.

The Mattermost-LDAP project uses the Gitlab authentication feature from Mattermost and substitute Gitlab to LDAP interaction. The main advantage of this module is to provide a light and easy to use LDAP connector for Mattermost not to need Gitlab.

## Module Description

This container runs an Oauth2 server implemented in php, a LDAP connector for PHP and some files for automatic configuration. Once installed and configured with Mattermost, the module allows LDAP authentication by replacing Gitlab SSO. This module allows many configuration settings to try to comply with your settings and configuration. Mattermost-LDAP can be used with the PostgreSQL database.

## Setup 


### Init Script

You need to create a database for the oauth server. For this purpose, you can use the script "init_postgres.sh" or "init_mysql.sh". These scripts try to configure your database automatically, by creating a new user and a new database associated for the oauth server. Scripts also create all tables necessary for the module. If script failed, please report here, and try to configure manually your database by adapting command in scripts. Before running the script you can change the default settings by editing the config_init.sh file and modifying configuration variables. For postgresql, you can copy and paste following lines :
```
nano config_init.sh # Now edit the settings
./init_postgres.sh # Run the script
```

This script will automatically create and add a new client in the oauth server, returning a client id and a client secret. You need to keep these two token to configure Mattermost. Please be sure the client secret remained secret. The redirect url in the script must comply with the hostname of your Mattermost server, else Mattermost could not get data from the Oauth server.

* Init script configuration :
#### oauth_user
Oauth user in the database. This user must have right on the oauth database to store oauth tokens. By default : oauth	
#### oauth_pass
Oauth user password in the database. By default, oauth_secure-pass
#### ip
Hostname or IP address of the database. By default : 127.0.0.1 		
#### port
The port to connect to the database. By default : 5432 (postgres) 		
#### oauth_db_name
Database name for oauth server. By default	: oauth_db	
#### client_id	
The application ID shared with mattermost. This ID should be a random token. You can use openssl to generate this token (openssl rand -hex 32). By default, this variable contain the openssl command, which use the openssl package. The token will be printed at the end of the script. 
#### client_secret
The application secret shared with mattermost. This secret should be a random token. You can use openssl to generate this token (openssl rand -hex 32). By default, this variable contain the openssl command, which use the openssl package. The token will be printed at the end of the script. Secret must be different of the client ID.
#### redirect_uri
The callback address where oauth will send tokens to Mattermost. Normally it should be http://mattermost.company.com/signup/gitlab/complete
#### grant_types
The type of authentification use by Mattermost. It should be "authorization_code".
#### scope
The scope of authentification use by Mattermost. It should be "api".
#### user_id
The username of the user who create the Mattermost client in Oauth. This field has no impact, and could be used as a commentary field. By default this field is empty.


### Mattermost Configuration
Active Gitlab authentication in system console > Gitlab (or config.json on server) and fill application id and secret with the two token got during install section. For the next fields use this :
```
User API Endpoint : http://HOSTNAME/oauth/resource.php
Auth Endpoint: http://HOSTNAME/oauth/authorize.php
Token Endpoint: http://HOSTNAME/oauth/token.php
```
Change HOSTNAME by hostname or ip of the server where you have installed Mattermost-LDAP module.

In Mattermost 4.9, these fields are disable  in admin panel, so you need to edit directly the configuration file config.json. 

### Docker container configuration
To run the docker container with the default configuration (probably not useful) type: `docker run -d --name mattermost-ldap davebown/mattermost-ldap`

The container is configured using environment variables which can be passed into the `docker run` command using the -e (-env) parameter before the image name e.g. `docker run -d --name mattermost-ldap -e LDAP_HOST=ldaps://ldap.exmple.com davebown/mattermost-ldap`

* Database credentials
Set the following environment variables:

#### DB_HOST
Hostname or IP address of the database. (ex : localhost).
#### DB_PORT
The port of your database to connect. (ex : 5432 for postgres)
#### DB_NAME
Database name for oauth server. If you use init script make sure to use the same database name. (ex : oauth_db) 
#### DB_TYPE
Database type to adapt PDO to your database server. Should be mysql or pgsql. (defaults to pgsql)
#### DB_USER
Oauth user in the database. This user must have right on the oauth database to store oauth tokens. If you use init script make sure to use the same database user. (ex : oauth)
#### DB_PASS
Oauth user password in the database. If you use init script make sure to use the same database user. (ex : oauth_secure-pass)

* LDAP config
Set environment variables as follows:
1. Provide your ldap address, port and version.
2. Change the base directory name ($base) and the filter ($filter) to comply with your LDAP configuration.
3. Change the user ID attribute ($ldap_attribute) to comply with your LDAP configuration (uid, sAMAccountName, email, cn ..).
4. If necessary, you can provide a LDAP account to allow search in LDAP (only restrictive LDAP).  

#### LDAP_HOST
Your LDAP hostname or LDAP IP, to connect to the LDAP server. If you want to use TLS then automatically prefix the hostname with ldaps:// protocol specifier e.g. ldaps://ldap.example.com
#### LDAP_PORT
Your LDAP port, to connect to the LDAP server. By default : 389.
#### LDAP_SEARCH_ATTR
The attribute used to identify user on your LDAP. Should be uid, email, cn or sAMAccountName.
#### LDAP_BASE_DN
The base directory name of your LDAP server. (ex : ou=People,o=Company)
#### LDAP_FILTER
Additional filters to search in LDAP (used to get user informations). (ex : objectClass=person)
#### LDAP_BIND_DN
The LDAP Directory Name of an service account to allow LDAP search. This ption is required if your LDAP is restrictive, else put an empty string (""). (ex : cn=mattermost_ldap,dc=Example,dc=com)
#### LDAP_PASS
The password associated to the service account to allow LDAP search. This ption is required if your LDAP you provide an bind user, else put an empty string ("").
#### LDAP_MAIL_ATTR
The ldap attribute used to lookup the e-mail address e.g. mail
#### LDAP_NAME_ATTR
The ldap attribute used to lookup the name of the user e.g. name
##### LDAP_USERNAME_ATTR
The ldap attribute used to lookup the username of the user e.g. uid

Configuring LDAP is certainly the most difficult step.

## Usage
If you have succeeded previous step you only have to go to the login page of your Mattermost server and click on the Gitlab Button. You will be redirected to a form asking for your LDAP credentials. If your credentials are valid, you will be asked to authorize Oauth to give your information to Mattermost. After authorizing you should be redirected on Mattermost connected with your account.

Keep in mind this will create a new account on your Mattermost server with information from LDAP. The process will fail if an existing user already use your LDAP email. To bind a user to the LDAP authentication, sign in mattermost with this user account, go in account settings > security > sign-in method and "switch to using Gitlab SSO".


## Limitation
This module has been tested on Centos 7, Fedora and Ubuntu with PostgreSQL and Mattermost Community Edition version 4.1, 4.9 and 5.0.1. Mattermost-LDAP is compliant with Mattermost Team Edition 4.x.x and 5.x.x.

MySQL has not really been tested so it is possible there is some bugs with it.


## To do list
 * Add CSS to make a beautiful interface for Oauth server
 * Create an associated Puppet module
 * Change Gitlab button
 * Security audit

## Thanks
Thanks to Brent Shaffer for his Oauth-server-php project and its documentation.


## Known issues
 * LDAP authentication failed
 Try to restart httpd service. If this persists verify your LDAP configuration or your credentials.

 * PHP date timezone error
 Edit php.ini to set up date.timezone option and restart httpd service, or use the date_default_timezone_set() function in config_db.php

 * Token request failed
 Try to add a new rule in your firewall (or use iptables -F on both Mattermost server and Oauth server)

 * .htaccess does not work
 Add following lines to your httpd.conf and restart httpd service.
 ```
 <Directory "/var/www/html/oauth">
    AllowOverride All
</Directory>
 ```



