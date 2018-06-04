<?php

require_once __DIR__ . '/api.php';
require_once __DIR__ . '/quickLink.php';
require_once __DIR__ . '/coin.php';
require_once __DIR__ . '/market.php';
require_once __DIR__ . '/pool.php';
require_once __DIR__ . '/wallet.php';

class EndPoint extends API{
    
    const ACCOUNTS = "http://accounts.attlocal.net/";
    
    protected $user;

    public function __construct($request,$origin,$remoteHost)
    {
        parent::__construct($request);
        if(!isset($this->headers['auth_token'])){
            throw new \Exception('Access Denied. No Token Present.');
        }
        if(!$this->_verifyToken()){
            throw new \Exception('Access Denied. Invalid Token');
        }
    }
    private function _verifyToken(){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,self::ACCOUNTS . "verify/");
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('auth_token: ' . $this->headers['auth_token']));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $output = json_decode(curl_exec($ch));
        curl_close($ch);
        if(isset($output->error)){
            return false;
        }
        $this->user = $output;
        return true;
    }
    protected function example(){
        return array("endPoint"=>$this->endpoint,"verb"=>$this->verb,"args"=>$this->args,"request"=>$this->request);
    }
    protected function _parseVerb(){
        throw new \Exception('Verbs is unsupported');
    }
    protected function quicklink(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\QuickLink();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\QuickLink::getAllByUser($this->user->username);
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\QuickLink($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\QuickLink($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function coin(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\Coin();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\Coin::getAllByUser($this->user->username);
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\Coin($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\Coin($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function chain(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\CoinSnapshot();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\CoinSnapshot::getAll();
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\CoinSnapshot($this->args[0]);
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\CoinSnapshot($this->args[0]);
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function market(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\Market();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\Market::getAllByUser($this->user->username);
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\Market($this->args[0]);
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\Market($this->args[0]);
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function market_history(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\MarketSnapshot();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\MarketSnapshot::getAll();
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\MarketSnapshot($this->args[0]);
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\MarketSnapshot($this->args[0]);
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function transaction(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\Transaction();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\Transaction::getAllByUser($this->user->username);
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\Transaction($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\Transaction($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function pool(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\MiningPool();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\MiningPool::getAllByUser($this->user->username);
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\MiningPool($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\MiningPool($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
    protected function wallet(){
        $data = null;
        if(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'POST'){ //create
            $data = new \Crypt\Wallet();
            $data->setFields($this->request)->create();
        }elseif(!isset($this->verb) && !isset($this->args[0]) && $this->method == 'GET'){ //get all
            $data = \Crypt\Wallet::getAllByUser($this->user->username);
        }elseif(!isset($this->verb) &&(int)$this->args[0] && $this->method == 'GET'){
            $data = new \Crypt\Wallet($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
        }elseif((int)$this->args[0] && $this->method == 'PUT'){ //update by id
            $data = new \Crypt\Wallet($this->args[0]);
            if($data->user != $this->user->username){
                throw new Exception('Trying to access resetricted resource');
            }
            $data->setFields($this->file)->update();
        }elseif(isset($this->verb)){
            $data = $this->_parseVerb();
        }else{
            throw new \Exception('Malformed Request');
        }
        return $data;        
    }
}
