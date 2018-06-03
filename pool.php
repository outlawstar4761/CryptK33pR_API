<?php namespace Crypt;

require_once __DIR__ . '/abstraction.php';

class MiningPool extends Record{
    
    const TABLE = 'pools';

    public $pool_name;
    public $username;
    public $password;
    public $home_url;
    public $pool_url;
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