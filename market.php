<?php namespace Crypt;

require_once __DIR__ . '/abstraction.php';

class Market extends Record{
    
    const TABLE = 'markets';

    public $market_name;
    public $username;
    public $password;
    public $home_url;
    public $user;
    public $created_date;

    public function __construct($UID = null)
    {
        parent::__construct(self::TABLE,$UID);
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
class MarketSnapshot extends Record{
    
    const TABLE = 'markets_over_time';

    public $market;
    public $bid;
    public $ask;
    public $high;
    public $low;
    public $volume;
    public $baseVolume;
    public $openSellOrders;
    public $openBuyOrders;
    public $source;
    public $created_date;

    public function __construct($UID = null)
    {
        parent::__construct(self::TABLE,$UID);
    }
    public static function getAll(){
        $data = array();
        $results = $GLOBALS['db']
                ->database(parent::DB)
                ->table(self::TABLE)
                ->select(parent::PRIMARYKEY)
                ->get();
        while($row = mysqli_fetch_assoc($results)){
            $data[] = new self($row[parent::PRIMARYKEY]);
        }
        return $data;
    }    
}