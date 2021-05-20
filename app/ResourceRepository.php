<?php


namespace RG;


use RG\Resource;


class ResourceRepository
{
    private $db;

    public function __construct()
    {
        $this->db = new \SQLite3($_ENV['DATABASE']);
    }

    public function list($argv = []): array
    {
        $condition = $argv['1'] ? 'WHERE period = "' . $argv['1'] . '"' : '';
        $query = 'SELECT * FROM resource ' . $condition . ';';

        $response = $this->db->query($query);

        while ($data = $response->fetchArray(SQLITE3_ASSOC)) {
            $result[] = new Resource($data);
        }

        return $result ?? [];
    }
}