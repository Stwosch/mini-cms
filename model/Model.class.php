<?php

class Model {

    static private function DatabaseConnect() {

        try {

            return new PDO(DB_SERVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);

        } catch(PDOException $e) {

             echo "Caught exception: " .  $e->getMessage() . "\n";
        }
    }

    static private function rememberImgName($pdo, $values) {
        
        $sql = 'SELECT img FROM tiles WHERE id_tiles = :id';

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute($values);

        } catch(PDOException $e) {

            echo "Caught exception: " .  $e->getMessage() . "\n";
        }

        if(!$result || $query->rowCount() !== 1) {

            return false;

        } else {
            
            $tiles = $query->fetch(PDO::FETCH_ASSOC);
            return $tiles['img'];
        }

    }

    static public function saveTileToDB($tile) {

        $pdo = self::DatabaseConnect();

        $sql = "INSERT INTO tiles (title, type, img, img_alt, date, show_date, id_authors) VALUES (:title, :type, :img, :img_alt, :date, :show_date, 1)";

        $values = [
            ":title" => $tile['title'],
            ":type" => $tile['type'],
            ":img" => $tile['img'],
            ":img_alt" => $tile['img_alt'],
            ":date" => $tile['date'],
            ":show_date" => $tile['show_date']
        ];

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute($values);

        } catch(PDOException $e) {

            echo "Caught exception: " .  $e->getMessage() . "\n";
        }

        $pdo = null;

        return $result;
    }

    static public function removeTileFromDB($id) {

        $pdo = self::DatabaseConnect();

        $values = [
            ":id" => $id
        ];

        $img = self::rememberImgName($pdo, $values);

        if(!$img) {
            return false;
        }
        
        $sql = "DELETE FROM tiles WHERE id_tiles = :id";

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute($values);

        } catch(PDOException $e) {

            echo "Caught exception: " .  $e->getMessage() . "\n";
        }


        $pdo = null;

        if($result) {

            return self::removeImg($img);

        } else {

            return false;
        }
    }

    static public function checkIdExists($queries) {

        if(!isset($queries['id'])) {
            return false;
        }

        $id = self::testInput($queries['id']);

        $pdo = self::DatabaseConnect();

        $sql = "SELECT id_tiles FROM tiles WHERE id_tiles = :id";

        $values = [
            ":id" => $id
        ];

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute($values);

        } catch(PDOException $e) {

            echo "Caught exception: " .  $e->getMessage() . "\n";
        }

        $pdo = null;

        if(!$result || $query->rowCount() !== 1) {
            return false;
        } else {
            return $id;
        }
    }

    

    static public function editTile($tile) {

        $pdo = self::DatabaseConnect();
        
        foreach($tile as $key => $val) {

            if($val && $key !== 'id') {

                $fields[$key] = $val;
            }
        }

        $sql = "UPDATE tiles SET ";
        
        if(!isset($fields['date'])) {
            unset($fields['show_date']);
        }
        

        foreach($fields as $key => $val) {

            $sql .= ' ' . $key . '="' . $val . '",';
        }

        $sql = rtrim($sql, ",");

        $sql .= " WHERE id_tiles = :id";

        $values = [
            ":id" => $tile['id']
        ];

        if(isset($fields['img'])) {

            $img = self::rememberImgName($pdo, $values);

            if(!$img) {
                return false;
            }
        }

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute($values);

        } catch(PDOException $e) {

            echo "Caught exception: " .  $e->getMessage() . "\n";
        }

        $pdo = null;

        if($result) {

            if(isset($fields['img'])) {
                return $img;
            } else {
                return true;
            }
            
        } else {
            return false;
        }
    }

    static public function getTiles() {

        $pdo = self::DatabaseConnect();

        $sql = "SELECT t.id_tiles, t.type, t.title, t.img, t.img_alt, t.date, t.show_date, a.icon FROM tiles AS t INNER JOIN authors AS a ON t.id_authors = a.id_authors";

        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute();

        } catch(PDOException $e) {

            $pdo = null;
            echo "Caught exception: " .  $e->getMessage() . "\n";
        }

        $pdo = null;
        
        if(!$result || $query->rowCount() === 0) {
            return false;
        }

        while(($row = $query->fetch(PDO::FETCH_ASSOC))) {
            $tiles[] = $row;
        }

        return $tiles;
    }

    static public function getPartTiles($offset, $rows) {

        $pdo = self::DatabaseConnect();

        $sql = "SELECT t.id_tiles, t.type, t.title, t.img, t.img_alt, t.date, t.show_date, a.icon FROM tiles AS t INNER JOIN authors AS a ON t.id_authors = a.id_authors LIMIT ". $rows ." OFFSET ". $offset;
        
        try {

            $query = $pdo->prepare($sql);
            $result = $query->execute();

        } catch(PDOException $e) {

            $pdo = null;
            echo "Caught exception: " .  $e->getMessage() . "\n";
        }

        $pdo = null;

        if(!$result || $query->rowCount() === 0) {
            return false;
        }

        while(($row = $query->fetch(PDO::FETCH_ASSOC))) {
            $tiles[] = $row;
        }

        return $tiles;
    }

    static public function getQueryString() {

        $parts = parse_url($_SERVER['REQUEST_URI']);

        if(isset($parts['query'])) {

            $queries = explode("&", $parts['query']);

            foreach($queries as $query) {

                $keyVal = explode("=", $query);

                if(count($keyVal) !== 2) {
                    return false;
                }

                $result[$keyVal[0]] = $keyVal[1];
            }

            return $result;

        } else {

            return false;
        }
    }

    static public function getError($queries) {

        if(is_array($queries) && isset($queries['error'])) {

            if(filter_input(INPUT_GET, $queries['error']) !== false) {

                $error = $queries['error'];

            } else {

                $error = null;
            }

        } else {

            $error = null;
        }

        if($error !== null) {

            $error = self::checkError($error);
        } else {

            $error = "";
        }

        return $error; 
    }

    static public function getSuccess($queries) {

        if(is_array($queries) && isset($queries['success'])) {

            if(filter_input(INPUT_GET, $queries['success']) !== false) {
                
                $success = $queries['success'];

            } else {
                
                $success  = null;
            }

        } else {

            $success  = null;
        }

        if($success  !== null) {

            $success  = self::checkSuccess($success);

        } else {
            
            $success  = "";
        }

        return $success;
    }

    static public function removeImg($name) {
        
        return unlink('assets/img/' . $name);
    }

    static public function testInput($input) {

        $input = trim($input);
        $input = stripslashes($input);
        $input = stripslashes($input);
        return $input;
    }

    static public function validationImg() {

        if(!isset($_FILES['img'])) {
            return 1;  
        }

        if($_FILES['img']['error'] === 4) {
            return 4;
        }

        $file_name = $_FILES['img']['name'];
        $file_size = $_FILES['img']['size'];
        $file_tmp = $_FILES['img']['tmp_name'];
        $file_type= $_FILES['img']['type'];
        $file_target = "assets/img/" . $file_name;
        $tmp = explode(".", $file_name);
        $file_ext = strtolower(end($tmp));
        
        $extensions = array("jpeg","jpg","png");
        
        if(file_exists($file_target)) {
            return 2;
        }

        if(!in_array($file_ext, $extensions)) {
            return 3;
        }

        if(move_uploaded_file($file_tmp, $file_target)) {

            return $file_name;

        } else {

            return false;
        }
    }

    static public function validationForm() {

        $title = self::testInput($_POST['title']);
        $img_alt = self::testInput($_POST['img_alt']);
        $type = self::testInput($_POST['type']);
        $date = self::testInput($_POST['date']);

        if(!($type === 'norm' || $type === 'main')) {
            return 5;
        }

        if(strlen($date) === 0) {
            $show_date = "f";
        } else {
            $show_date = "t";

            $ymd = explode("-", $date);

            if(!checkdate($ymd[1], $ymd[2], $ymd[0])) {
                return 6;
            }
        }

        $result['title'] = $title;
        $result['img_alt'] = $img_alt;
        $result['type'] = $type;
        $result['show_date'] = $show_date;
        $result['date'] = $date;

        return $result;
    }

    static public function validationId($id) {
        
        $id = self::testInput($id);

        return intval($id);
    }

    static public function checkError($err) {

        switch($err) {

            case 1: 
                return "You can't upload this image.";
            break;

            case 2: 
                return "File already exists.";
            break;

            case 3:
                return "Only JPG, JPEG, PNG files are allowed.";
            break;

            case 3:
                return "File is not set.";
            break;

            case 5:
                return "Choose proper type.";
            break;

            case 6:
                return "You use bad format of date.";
            break;

            case 7:
                return "This ID doesn't exist in database.";
            break;

            case 8:
                return "Couldn't edit tile.";
            break;

            case 9:
                return "Couldn't remove image from server.";
            break;

            case 10:
                return "Couldn't remove tile. Try again later.";
            break;

            default:
                return "Something went wrong. Try again later.";
        }
    }


    static public function checkSuccess($succ) {

        switch($succ) {

            case 1:
                return "Sucessfull added tile";
            break;

            case 2:
                return "Sucessfull edited tile";
            break;

            case 3:
                return "Sucessfull removed tile";
            break;

            default: 
                return "";
        }
    }

    static public function redirectAddTile($valid) {

        if($valid !== true) {

            header('Location: form?error=' . $valid);

        } else {
            header('Location: form?success=1');
        }
    }
}