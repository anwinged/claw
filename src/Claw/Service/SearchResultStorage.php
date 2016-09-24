<?php

namespace Claw\Storage;

use Claw\Entity\SearchResult;

class SearchResultStorage
{
    private $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=claw';

        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->pdo = new \PDO($dsn, 'claw', 'claw', $opt);
    }

    public function findAll()
    {
        $query = 'SELECT * FROM search_result';

        $records = $this->pdo->query($query)->fetchAll();

        $entities = [];
        foreach ($records as $record) {
            $entity = new SearchResult();
            $entity->setId($record['id']);
            $entity->setUrl($record['url']);
            $entity->setType($record['type']);
            $entity->setText($record['text']);
            $entity->setMatches(json_decode($record['matches']));
            $entities[] = $entity;
        }

        return $entities;
    }

    public function find($id)
    {
        $query = 'SELECT * FROM search_result WHERE id = :id';

        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $record = $statement->fetch();

        $entity = new SearchResult();
        $entity->setId($record['id']);
        $entity->setUrl($record['url']);
        $entity->setType($record['type']);
        $entity->setText($record['text']);
        $entity->setMatches(json_decode($record['matches']));

        return $entity;
    }

    public function insert(SearchResult $result)
    {
        $query = 'INSERT INTO search_result(`url`, `type`, `text`, `matches`) VALUES(:url, :type, :text, :matches)';

        $statement = $this->pdo->prepare($query);

        $statement->execute([
            'url' => $result->getUrl(),
            'type' => $result->getType(),
            'text' => $result->getText(),
            'matches' => json_encode($result->getMatches()),
        ]);

        $result->setId($this->pdo->lastInsertId());
    }
}
