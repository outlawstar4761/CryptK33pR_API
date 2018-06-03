<?php namespace Crypt;

require_once __DIR__ . '/abstraction.php';

class Coin extends Record{

    const TABLE = 'coins';

    public $coin_name;
    public $abbreviation;
    public $icon_path;
    public $user;
    public $created_date;
    public $url;
    public $mining;
    public $staking;
    public $algorithm;
    public $pow;
    public $pos;
    public $invested;
    public $trading;


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
class CoinSnapshot extends Record{

    const TABLE = 'chains_over_time';

    public $coin_name;
    public $block_height;
    public $share_diff;
    public $coinbase_value;
    public $snapshot_value_usd;
    public $algorithm;
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