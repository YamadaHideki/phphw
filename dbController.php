<?
class dbController {
    private $PDO;
    private $driver = "mysql";
    private $host = "localhost";
    private $dbname = "data";
    private $user = "root";
    private $pwd = "root";


    public function __construct() {
        $dsn = "$this->driver:host=$this->host;dbname=$this->dbname;charset=UTF8";
        try {
            $this->PDO = new PDO($dsn, $this->user, $this->pwd);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function registration($username, $pwd, $role) {
        try {
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $this->PDO->prepare($sql)->execute([$username, $pwd, $role]);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function login($username, $pwd) {
        try {
            $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
            $query = $this->PDO->prepare($sql);
            $query->execute([$username, $pwd]);
            return $query->fetch();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function getRowsInDb($table) {
        try {
            $result = array();
            $query = $this->PDO->query("SELECT * FROM $table");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $result[] =  $row;
            }
            return $result;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function addItem($type, $title, $description, $vendor, $price, $img) {
        try {
            $checkType = $this->PDO->prepare("SELECT count(*) FROM type_of_products WHERE id = ?");
            $checkType->execute([$type]);
            $result = $checkType->fetch(PDO::FETCH_ASSOC);
            if ($result['count(*)'] > 0) {
                $sql = "INSERT INTO products (product_type_id, title, description, vendor_type_id, img, price) VALUES (?, ?, ?, ?, ?, ?)";
                $query = $this->PDO->prepare($sql);
                $query->execute([$type, $title, $description, $vendor, $img, $price]);
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function __destruct() {
        $this->PDO = null;
    }
}
?>