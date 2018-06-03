<?php namespace Crypt;

require_once __DIR__ . '/abstraction.php';

class Wallet extends Record{
    
    const TABLE = 'wallets';

    public $coin;
    public $address;
    public $user;
    public $created;
    public $personal_use;
    public $protected_use;
    public $mining;
    public $market;
    public $local_storage;
    public $web_storage;
    public $market_id;
    public $pool_id;

    public function __construct($UID = null)
    {
        parent__construct(self::TABLE,$UID);
    }
    public static function getAllByUser($username){
        $data = array();
        $results = $GLOBALS['db']
                ->database(parent::DB)
                ->table(self::TABLE)
                ->select(parent::PRIMARYKEY)
                ->where("user","=","'" . $username . "'")
                ->get();
        while($row = mysqli_fetch_assoc($results)){
            $data[] = new self($row[parent::PRIMARYKEY]);
        }
        return $data;
    }    
}