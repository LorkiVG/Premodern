<?php

namespace backend\lib;

class ReCaptcha
{


    public function verify($secret,$remoteIp, $response)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$response.'&remoteip='.$remoteIp;
        $response_serv = file_get_contents($url);
        $answers = json_decode($response_serv, true);
        return $answers;
    }
}

?>