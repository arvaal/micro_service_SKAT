<?php



class Users
{

    private $db;

    public function __construct($database)
    {

        $exists = $database->query("SHOW TABLES LIKE '%" . "users%'")->rows;

        if (empty($exists)) {
            $this->createTable();
        }

        $this->db = $database;
    }

    public function getAllUsers()
    {
        return $this->db->query("SELECT * FROM `users`")->rows;
    }

    public function addUser($json)
    {
        $data = json_decode($json, true);

        if (!empty($data)){
            $this->db->query("INSERT INTO `users` SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', phon = '" . $this->db->escape($data['phon']) . "', status = '" . (int) $data['status'] . "'");
        }
    }

    private function createTable()
    {
        $this->db->query("CREATE TABLE `users` (
             `id` int NOT NULL AUTO_INCREMENT,
             `name` varchar(64) COLLATE utf8mb4_0900_as_ci NOT NULL,
             `email` varchar(64) COLLATE utf8mb4_0900_as_ci NOT NULL,
             `phon` varchar(12) COLLATE utf8mb4_0900_as_ci NOT NULL,
             `status` int NOT NULL,
             PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_as_ci");
    }
}