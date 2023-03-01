<?php

namespace Saladin;

use PDO;
use PDOException;
use Saladin\Connection;
use Saladin\Database;
use Latte\Engine as latte;

class SqlGenerator extends Skelton
{

    protected function frame()
    {
    }

    protected function action()
    {
    }
    

    public function index()
    {
        $latte = new latte();
        //$latte->setTempDirectory('temp');
        $latte->setAutoRefresh(true);
        $latte->render(
            'app/templates/app.html',
            array(
                'title' => $this->profile->title,
                'parameter' => $this->parameter,

            )
        );
    }

    public function dblist()
    {
        $this->V['dBList'] = [];
        $this->V['error'] = "";

        $arrDB = new Database();
        $pdo = Connection::connectAll($arrDB);
        $stmt = $pdo->query("SHOW DATABASES");
        try {
            $this->V['dBList'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            $this->V['error'] = $e->getMessage();
        }
        echo json_encode([
            'message' => 'success',
            'body' => $this->V['dBList'],
            'error' => $this->V['error']
        ]);
    }

    public function tablelist()
    {
        $this->V['TableList'] = [];
        $this->V['error'] = "";

        $arrDB = new Database();
        $data = json_decode(file_get_contents("php://input"), true);

        $pdo = Connection::connect($arrDB, $data['databasename']);
        $stmt = $pdo->query("SHOW TABLES");
        try {
            $this->V['TableList'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            $this->V['error'] = $e->getMessage();
        }

        echo json_encode([
            'message' => 'success',
            'body' => $this->V['TableList'],
            'error' => $this->V['error']
        ]);
    }
    public function columnlist()
    {
        $this->V['ColumnList'] = [];
        $this->V['error'] = "";

        $arrDB = new Database();
        $data = json_decode(file_get_contents("php://input"), true);

        $pdo = Connection::connect($arrDB, $data['databasename']);
        $stmt = $pdo->query("SHOW COLUMNS FROM " . $data['tablename']);
        try {
            $this->V['ColumnList'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            $this->V['error'] = $e->getMessage();
        }

        echo json_encode([
            'message' => 'success',
            'body' => $this->V['ColumnList'],
            'error' => $this->V['error']
        ]);
    }
    public function process()
    {
        $this->V['QueryString'] = [];
        $this->V['error'] = "";

        $arrDB = new Database();
        $data = json_decode(file_get_contents("php://input"), true);

        $database = ConnectX::setup($arrDB, $data['databasename']);
        if (count($data['columnname']) == 1 && $data['columnname'][0] == "*") {
            $database->select(
                $data['tablename'],
                "*"
            );
        } else {
            $database->select(
                $data['tablename'],
                $data['columnname']
            );
        }

        $this->V['QueryString'] = $database->last();
        echo json_encode([
            'message' => 'success',
            'body' => $this->V['QueryString'],
            'error' => $this->V['error']
        ]);
    }
    public function run()
    {
        $this->V['DataSet'] = [];
        $this->V['error'] = "";

        $arrDB = new Database();
        $data = json_decode(file_get_contents("php://input"), true);

        $database = ConnectX::setup($arrDB, $data['databasename']);
        $this->V['DataSet'] = $database->query($data['query'])->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            'message' => 'success',
            'body' => $this->V['DataSet'],
            'error' => $this->V['error']
        ]);
    }
}
