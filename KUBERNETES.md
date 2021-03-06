Mattermost-LDAP using Kubernetes
================================

# Create configMap with database and ldap configuration in

## Active Directory example

kubectl create configmap mattermost-ldap    \
 --from-literal="db_host=host.example.com"        \
 --from-literal="db_port=5432"        \
 --from-literal="db_name=mattermostldap"        \
 --from-literal="ldap_host=ldaps://host.example.com"        \
 --from-literal="ldap_port=636"        \
 --from-literal="ldap_base_dn=dc=org"        \
 --from-literal="ldap_filter="        \
 --from-literal="ldap_mail_attr=mail"        \
 --from-literal="ldap_name_attr=name"        \
 --from-literal="ldap_username_attr=sAMAccountName"        \
 --from-literal="ldap_search_attr=sAMAccountName"

 ## Regular LDAP example

kubectl create configmap mattermost-ldap    \
 --from-literal="db_host=host.example.com"        \
 --from-literal="db_port=5432"        \
 --from-literal="db_name=mattermostldap"        \
 --from-literal="ldap_host=ldaps://host.example.com"        \
 --from-literal="ldap_port=636"        \
 --from-literal="ldap_base_dn=dc=org"        \
 --from-literal="ldap_filter="        \
 --from-literal="ldap_mail_attr=mail"        \
 --from-literal="ldap_name_attr=cn"        \
 --from-literal="ldap_username_attr=uid"        \
 --from-literal="ldap_search_attr=uid"

# Create secret with database and ldap credentials in

kubectl create secret generic mattermost-ldap   \
--from-literal="db_user=${DB_USER}"             \
--from-literal="db_pass=${DB_PASS}"             \
--from-literal="ldap_bind_dn=${LDAP_BIND_DN}"   \
--from-literal="ldap_pass=${LDAP_PASS}"