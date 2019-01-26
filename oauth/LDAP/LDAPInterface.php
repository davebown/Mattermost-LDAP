<?php

/**
 * Class to interact with LDAP
 *
 * @author Denis CLAVIER <clavierd at gmail dot com> 
 */
interface LDAPInterface
{
     /**
     * @param string @user
     * A ldap username or email or sAMAccountName
     * @param string @password
     * An optional password linked to the user, if not provided an anonymous bind is attempted
     * @param string @search_attribute
     * The attribute used on your LDAP to identify user (uid, email, cn, sAMAccountName)      
     * @param string @filter
     * An optional filter to search in LDAP (ex : objectClass = person).
     * @param string @base_dn
     * The LDAP base DN. 
     * @param string @bind_dn
     * The directory name of a service user to bind before search. Must be a user with read permission on LDAP. 
     * @param string @bind_pass
     * The password associated to the service user to bind before search. 
     * 
     * @return 
     * TRUE if the user is identified and can access to the LDAP server
     * and FALSE if it isn't  
     */
    public function checkLogin($user,$password = null,$search_attribute,$filter = null,$base_dn,$bind_dn,$bind_pass);

    /**
     * @param string @base_dn
     * The LDAP base DN. 
     * @param string @filter
     * A filter to get relevant data. Often the user id in ldap (uid or sAMAccountName).
     * @param string @bind_dn
     * The directory name of a service user to bind before search. Must be a user with read permission on LDAP. 
     * @param string @bind_pass
     * The password associated to the service user to bind before search.
     * @param string @search_attribute
     * The attribute used on your LDAP to identify user (uid, email, cn, sAMAccountName)
     * @param string @user
     * A ldap username or email or sAMAccountName
     * @param array @attributes
     * LDAP attribute names used for getting user data  
     * 
     * @return 
     * An array with the user's mail, complete name and directory name.
     */
    public function getDataForMattermost($base_dn, $filter, $bind_dn, $bind_pass, $search_attribute, $user, $attributes);
}
