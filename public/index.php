<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);
 
$app->add($cors);

require __DIR__ . '/../src/dependencies.php';
require __DIR__ . '/../src/middleware.php';
require __DIR__ . '/../src/routes.php';

$app->run();

function getMahasiswas() {
    $sql = "select * FROM mahasiswa";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $emp = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
       return json_encode($emp);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function getMahasiswa($request) {
            $id = 0;;
            $id =  $request->getAttribute('id');
            if(empty($id)) {
                        echo '{"error":{"text":"Id is empty"}}';
            }
    try {
                        $db = getConnection();
        $sth = $db->prepare("SELECT * FROM mahasiswa WHERE id=$id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
                        return json_encode($todos);
    } catch(PDOException $e) {
      echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function addMahasiswa($request) {
    //$emp = json_encode($request->getBody());
    $emp = $request->getParsedBody();

    $sql = "INSERT INTO mahasiswa (nama_mahasiswa, nim_mahasiswa, umur_mahasiswa) VALUES (:nama, :nim, :umur)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nama", $emp['nama']);
        $stmt->bindParam("nim", $emp['nim']);
        $stmt->bindParam("umur", $emp['umur']);
        $stmt->execute();
        $emp->id = $db->lastInsertId();
        $db = null;
        echo json_encode($emp);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .$emp->nama.'}}';
    }
}
 
function updateMahasiswa($request) {
    $emp = json_decode($request->getBody());
    $emp = $request->getParsedBody();
            $id = $request->getAttribute('id');
    $sql = "UPDATE mahasiswa SET nama_mahasiswa=:nama, nim_mahasiswa=:nim, umur_mahasiswa=:umur WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nama", $emp['nama']);
        $stmt->bindParam("nim", $emp['nim']);
        $stmt->bindParam("umur", $emp['umur']);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($emp);
    } catch(PDOException $e) {
       echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteMahasiswa($request) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM mahasiswa WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo '{"error":{"text":"successfully! deleted Records"}}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getConnection() {
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="password";
    $dbnama="namadatabase";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbnama", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}