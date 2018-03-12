<?php 

class Authentication{

    private $request;

    public function __construct($request=null){
        $this->user=variable_get('user_name_cxense', "");
        $this->apikey= variable_get('apikey_cxense', "");
        $this->date=date("Y-m-d\TH:i:s.000O");
        $this->signature=hash_hmac("sha256", $this->date, $this->apikey);
        $this->request=isset($request) ? '/'.$request:'';
        $this->endpoint=variable_get('endpoint_cxense', "").$this->request;
    }


    public function getRequest(){
        return $this->request;
    }

    public function setRequest($request){
        return $this->request=$request;
    }

}