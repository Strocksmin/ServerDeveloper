<?php

class User
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $password;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read(): array
    {
        $result = $this->conn->query(/** @lang MySQL */ "SELECT * FROM $this->table_name");
        $arr = array();
        foreach ($result as $row) {
            $arr[] = $row;
        }
        return $arr;

    }

    public function create(): bool
    {
        $this->clear_fields();
        $query = /** @lang MySQL */
            "INSERT INTO $this->table_name (name, password, role) VALUES (\"$this->name\", \"$this->password\", \"$this->role\")";
        if ($this->conn->query($query)) {
            return true;
        }
        return false;
    }

    public function readOne()
    {
        $query = /** @lang MySQL */
            "SELECT * FROM $this->table_name WHERE $this->table_name.id = $this->id";
        $result = $this->conn->query($query);
        foreach ($result as $row) {
            $this->name = $row["name"];
            $this->password = $row["password"];
            $this->role = $row["role"];
        }
    }

    public function update(): bool
    {
        $this->clear_fields();
        $query = /** @lang MySQL */
            "UPDATE $this->table_name SET name=\"$this->name\", password=\"$this->password\", role=\"$this->role\" WHERE id=$this->id";
        if ($this->conn->query($query)) {
            return true;
        }
        return false;
    }

    public function delete(): bool
    {
        $this->id = htmlspecialchars(strip_tags($this->id));
        $query = /** @lang MySQL */
            "DELETE FROM $this->table_name WHERE id=$this->id";
        if ($this->conn->query($query)) {
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    public function clear_fields(): void
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));
    }
}