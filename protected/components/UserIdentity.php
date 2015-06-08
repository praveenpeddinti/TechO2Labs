<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;

    public function authenticate() {
        try{
            $this->_id = 1234567;
            $randomKey = $this->gen_random_string(16);
            $this->setState("s_k", $randomKey);
        } catch (Exception $ex) {
            Yii::log("UserIdentity:authenticate::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

    function gen_random_string($length = 16) {
        try{
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
        } catch (Exception $ex) {
            Yii::log("UserIdentity:gen_random_string::".$ex->getMessage()."--".$ex->getTraceAsString(), 'error', 'application');
        }
    }

}
