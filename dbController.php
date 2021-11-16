<?
class dbController {
    private $PDO;
    private $driver = "mysql";
    private $host = "localhost";
    private $dbname = "data";
    private $user = "root";
    private $pwd = "root";


    public function __construct(){
        $dsn = "$this->driver:host=$this->host;dbname=$this->dbname;charset=UTF8";
        try {
            $this->PDO = new PDO($dsn, $this->user, $this->pwd);
        } catch (PDOException $e) {
            print "Error!: ".$e->getMessage();
        }
    }

    public function __destruct(){
        $this->PDO = null;
    }
}
?>