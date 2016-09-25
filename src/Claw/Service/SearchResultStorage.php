<?php

namespace Claw\Storage;

use Claw\Entity\SearchResult;

class SearchResultStorage
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll()
    {
        $query = 'SELECT * FROM search_result';

        $records = $this->pdo->query($query)->fetchAll();

        $entities = [];
        foreach ($records as $record) {
            $entities[] = $this->hydrate($record);
        }

        return $entities;
    }

    public function find($id)
    {
        $query = 'SELECT * FROM search_result WHERE id = :id';

        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $record = $statement->fetch();

        return $record !== false ? $this->hydrate($record) : null;
    }

    public function insert(SearchResult $result)
    {
        $query = 'INSERT INTO search_result(`url`, `type`, `text`, `matches`) VALUES(:url, :type, :text, :matches)';

        $statement = $this->pdo->prepare($query);

        $statement->execute($this->dump($result));

        $result->setId($this->pdo->lastInsertId());
    }

    private function hydrate(array $record)
    {
        $entity = new SearchResult();
        $entity->setId($record['id']);
        $entity->setUrl($record['url']);
        $entity->setType($record['type']);
        $entity->setText($record['text']);
        $entity->setMatches(json_decode($record['matches']));

        return $entity;
    }

    private function dump(SearchResult $result)
    {
        return [
            'url' => $result->getUrl(),
            'type' => $result->getType(),
            'text' => $result->getText(),
            'matches' => json_encode($result->getMatches()),
        ];
    }
}
