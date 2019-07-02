<?php

class TLTDataModel {

    const DSN_KEY = "dsn";
    const DB_USERNAME_KEY = "DBuser";
    const DB_PASSWORD_KEY = "DBpass";
    const PREPARED_STATEMENT_KEY = "preparedStatement";

    private $titles = array();

    function __construct() {
        //ini_set('memory_limit', '1024M');
        //ini_set('max_execution_time', 3000);

        define("TLT_DATA_MODEL_INI_FILE", "TLTDataModel.ini");
        $this->iniArray = parse_ini_file(TLT_DATA_MODEL_INI_FILE);

        $dsn = "mysql:host=localhost;dbname=" . ($this->iniArray[self::DSN_KEY]);
        $db = new PDO($dsn, $this->iniArray[self::DB_USERNAME_KEY], $this->iniArray[self::DB_PASSWORD_KEY]);

        $query = $this->iniArray[self::PREPARED_STATEMENT_KEY];
        $statement = $db->prepare($query);
        $statement->execute();
        $tempTitles = $statement->fetchAll();
        $statement->closeCursor();

        $newTitles = array();
        foreach($tempTitles as $tempTitle) {
            array_push($newTitles, $tempTitle[0]);
        }
        $this->titles = $newTitles;
    }

    public function getTitles() {
        return $this->titles;
    }

}
