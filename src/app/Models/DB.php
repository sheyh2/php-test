<?php

namespace App\Models;

use PDO;

/**
 * Class DB.php
 * @package App\Models
 */
class DB extends PDO
{
    public function __construct()
    {

        $env = parse_ini_file('.env');
        $dns = sprintf('mysql:host=%s;dbname=%s', $env['DB_HOST'], $env['DB_DATABASE']);

        parent::__construct($dns, $env['DB_USERNAME'], $env['DB_PASSWORD']);
    }

    protected string $table;

    protected function getAll(): ?array
    {
        $statement = $this->query(sprintf('SELECT * FROM %s', $this->table));

        $items = [];

        foreach ($statement->fetchAll() as $item) {
            $items[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'comment' => $item['comment'],
                'created_at' => $item['created_at'],
            ];
        }

        if (is_array($items)) {
            return $items;
        }

        return null;
    }

    protected function insertInto($data): bool
    {
        $columns = $this->getColumns(array_keys($data));
        $values = $this->getValues(array_values($data));

//        $statement = $this->prepare(sprintf('INSERT INTO %s (%s) VALUE (%s)', $this->table, $columns, $values));
        $statement = $this->prepare(sprintf('INSERT INTO %s (%s) VALUE (?, ?)', $this->table, $columns));

        $statement->bindParam(1, array_values($data)[0]);
        $statement->bindParam(2, array_values($data)[1]);

        return $statement->execute();
    }

    private function getValues(array $values): string
    {
        $val = sprintf('\'%s\'', $values[0]);

        foreach ($values as $k => $value) {
            if ($k < 1) continue;

            $val = $val . sprintf(', \'%s\'', $value);
        }

        return $val;
    }

    private function getColumns(array $columns): string
    {
        return implode(', ', $columns);
    }
}
