<?php

declare(strict_types=1);

namespace Claw\Storage;

use Claw\Entity\SearchResult;

class SearchResultStorage
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Находит все записи результатов.
     *
     * @return array
     */
    public function findAll(): array
    {
        $query = 'SELECT * FROM search_result';

        $records = $this->pdo->query($query)->fetchAll();

        $entities = [];
        foreach ($records as $record) {
            $entities[] = $this->hydrate($record);
        }

        return $entities;
    }

    /**
     * Находит запись по первичному ключу.
     *
     * @param $id
     *
     * @return SearchResult|null
     */
    public function find($id)
    {
        $query = 'SELECT * FROM search_result WHERE id = :id';

        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $record = $statement->fetch();

        return $record !== false ? $this->hydrate($record) : null;
    }

    /**
     * Добавляет новую запись в хранилище.
     *
     * @param SearchResult $result
     */
    public function insert(SearchResult $result)
    {
        $query = 'INSERT INTO search_result(`url`, `type`, `text`, `matches`) VALUES (:url, :type, :text, :matches)';

        $statement = $this->pdo->prepare($query);

        $statement->execute($this->dump($result));

        $result->setId($this->pdo->lastInsertId());
    }

    /**
     * Создает объект SearchResult и заполняет его из массива с данными.
     *
     * @param array $record
     *
     * @return SearchResult
     */
    private function hydrate(array $record): SearchResult
    {
        $entity = new SearchResult();
        $entity->setId(intval($record['id']));
        $entity->setUrl($record['url']);
        $entity->setType($record['type']);
        $entity->setText($record['text']);
        $entity->setMatches(json_decode($record['matches']));

        return $entity;
    }

    /**
     * Создает массив с данными из объекта SearchResult.
     *
     * @param SearchResult $result
     *
     * @return array
     */
    private function dump(SearchResult $result): array
    {
        return [
            'url' => $result->getUrl(),
            'type' => $result->getType(),
            'text' => $result->getText(),
            'matches' => json_encode($result->getMatches()),
        ];
    }
}
