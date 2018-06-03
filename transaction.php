<?php namespace Crypt;

require_once __DIR__ . '/abstraction.php';

class Transaction extends Record{
    
    const TABLE = 'transactions';

    public $coin;
    public $source;
    public $destination;
    public $amount;
    public $fee;
    public $user;
    public $created;

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