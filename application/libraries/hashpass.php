<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Password hashing library
* Developed for Codeigniter using the tutorial from net-tuts - see URL below
* http://net.tutsplus.com/tutorials/php/understanding-hash-functions-and-keeping-passwords-safe/
*
* hash & salt password with cryptography
*
* @author Joe Misika joe@joemisika.com
* @version 0.1
* @license WFTPL http://sam.zoy.org/wtfpl/
*
*/
class Hashpass{

    /*
    * return a hard to crack password using the myhash and unique_salt functions below
    */
    function hash_password($password)
    {
        $hashpass = $this->myhash($password, $this->unique_salt());
        return $hashpass;
    }

    /*
    * One-way string hashing using the php crypt
    */
    function myhash($password, $unique_salt)
    {
        return crypt($password, '$2a$10$'.$unique_salt);
    }

    /*
    * Calculate the sha1 hash of a string,
    */
    function unique_salt()
    {
        return substr(sha1(mt_rand()),0,22);
    }

    /**
    *Checking password against the hashed string
    */
    public static function check_password($hash, $password)
    {
        $full_salt = substr($hash, 0, 29);

        $new_hash = crypt($password, $full_salt);

        return ($hash == $new_hash);
    }
}
