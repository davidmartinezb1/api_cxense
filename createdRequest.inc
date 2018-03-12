<?php

function createdRequest($request=null,$payload=null){
    module_load_include('inc', 'cxenseApi', 'autentification');
        
    $auth = new Authentication($request);
    $propGetter = Closure::bind(function($prop){return $this->$prop;}, $auth, $auth );
    
    $user=$propGetter('user');
    $date=$propGetter('date');
    $signature=$propGetter('signature');
    $endpoint=$propGetter('endpoint');
    $plainjson_payload=isset($payload) ? $payload: '';

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
                        "X-cXense-Authentication: username=$user date=$date hmac-sha256-hex=$signature\r\n",
            'method'  => 'POST',
            'content' => $plainjson_payload ,
        ),
    );

    $context  = stream_context_create($options);
    $response = json_decode(file_get_contents($endpoint, false, $context));
    return $response;
}