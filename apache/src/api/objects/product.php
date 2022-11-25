<?php

class Product
{
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $volume;
    public $description;
    public $price;
    public $created;

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
            "INSERT INTO $this->table_name (name, volume, description, price, created) VALUES (\"$this->name\", \"$this->volume\", \"$this->description\", \"$this->price\", \"$this->created\")";
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
            $this->volume = $row["volume"];
            $this->description = $row["description"];
            $this->price = $row["price"];
            $this->created = $row["created"];
        }
    }

    public function update(): bool
    {
        $this->clear_fields();
        $query = /** @lang MySQL */
            "UPDATE $this->table_name SET name=\"$this->name\", volume=\"$this->volume\", description=\"$this->description\", price=\"$this->price\" WHERE id=$this->id";
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
        $this->volume = htmlspecialchars(strip_tags($this->volume));
        if ($this->description != null)
            $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        if ($this->created != null)
            $this->created = htmlspecialchars(strip_tags($this->created));
    }
}