<?php

namespace Onfan\UserBundle\Util;

class CodeGenerator
{
    /**
     * Generate Verification Code
     *
     * @return string 
     */
    static function generateVerificationCode()
    {
            $verificationCode = hash('sha256', uniqid(null, true));
            $verificationCode = substr($verificationCode, 0, 7);
            return $verificationCode;
    }
    
    /**
     * Generate Session Access Token
     * 
     * @return string
     */
    static function generateSessionAccessToken()
    {
        return hash('sha256', uniqid(null, true));
    }
    
    /**
     * Generate Salt
     * 
     * @return string
     */
    static function generateSalt()
    {
        return hash('sha256', uniqid(null, true));
    }
}
