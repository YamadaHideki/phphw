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

    public function getFormTableToId($table, $id) {
        try {
            $query = $this->PDO->prepare("SELECT name FROM $table WHERE id = ?");
            $query->execute([$id]);
            if ($row = $query->fetch()) {
                return $row['name'];
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function getItem($id) {
        try {
            $result = array();
            $query = $this->PDO->prepare("SELECT * FROM products WHERE id = ?");
            $query->execute([$id]);
            if ($row = $query->fetch()) {
                $result = $row;
                $result['vendor'] = self::getFormTableToId("vendors", $row['vendor_type_id']);
                $result['type_of_product'] = self::getFormTableToId("type_of_products", $row['product_type_id']);
                return $result;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function getRate ($user_id, $product_id) {
        try {
            $query = $this->PDO->prepare("SELECT * FROM rating WHERE user_id = ? AND product_id = ?");
            $query->execute([$user_id, $product_id]);
            if ($row = $query->fetch()) {
                return $row;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function getMiddleRate ($product_id) {
        try {
            $query = $this->PDO->prepare("SELECT AVG(rate) FROM rating WHERE product_id = ?");
            $query->execute([$product_id]);
            if ($row = $query->fetch()) {
                return $row['AVG(rate)'];
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
        }
    }

    public function addNewRate ($user_id, $product_id, $rate) {
        try {
            $query = $this->PDO->prepare("SELECT id FROM rating WHERE user_id = ? AND product_id = ?");
            $query->execute([$user_id, $product_id]);
            if ($row = $this->getRate($user_id, $product_id)) {
                $update = $this->PDO->prepare("UPDATE rating SET user_id = ?, product_id = ?, rate = ? WHERE id = ?");
                $update->execute([$user_id, $product_id, $rate, $row['id']]);
            } else {
                $insert = $this->PDO->prepare("INSERT INTO rating (user_id, product_id, rate) VALUES (?, ?, ?)");
                $insert->execute([$user_id, $product_id, $rate]);
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