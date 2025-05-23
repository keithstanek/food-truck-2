<?php
class GenericCrud {
    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // Create a new record
    public function create($table, $data) {
        $fields = array_keys($data);
        $placeholders = array_map(fn($f) => ":$f", $fields);
        $sql = "INSERT INTO `$table` (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Read records (optionally by primary key or where clause)
    public function read($table, $where = [], $fields = ['*']) {
        $sql = "SELECT " . implode(',', $fields) . " FROM `$table`";
        if ($where) {
            $conditions = [];
            foreach ($where as $k => $v) {
                $conditions[] = "`$k` = :$k";
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $stmt = $this->db->prepare($sql);
        foreach ($where as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update records by where clause
    public function update($table, $data, $where) {
        $set = [];
        foreach ($data as $k => $v) {
            $set[] = "`$k` = :set_$k";
        }
        $conditions = [];
        foreach ($where as $k => $v) {
            $conditions[] = "`$k` = :where_$k";
        }
        $sql = "UPDATE `$table` SET " . implode(',', $set) . " WHERE " . implode(' AND ', $conditions);
        $stmt = $this->db->prepare($sql);
        foreach ($data as $k => $v) {
            $stmt->bindValue(":set_$k", $v);
        }
        foreach ($where as $k => $v) {
            $stmt->bindValue(":where_$k", $v);
        }
        return $stmt->execute();
    }

    // Delete records by where clause
    public function delete($table, $where) {
        $conditions = [];
        foreach ($where as $k => $v) {
            $conditions[] = "`$k` = :$k";
        }
        $sql = "DELETE FROM `$table` WHERE " . implode(' AND ', $conditions);
        $stmt = $this->db->prepare($sql);
        foreach ($where as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        return $stmt->execute();
    }
}