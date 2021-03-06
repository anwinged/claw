<?php

declare(strict_types=1);

namespace Claw\Entity;

class SearchResult
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string[]
     */
    private $matches = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string[]
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param string[] $matches
     */
    public function setMatches(array $matches)
    {
        $this->matches = $matches;
    }

    /**
     * @return int
     */
    public function getMatchCount(): int
    {
        return count($this->matches);
    }

    /**
     * @return bool
     */
    public function hasMatches(): bool
    {
        return (bool) $this->matches;
    }

    /**
     * @return mixed
     */
    public function getTypeName(): string
    {
        return SearchType::getName($this->getType());
    }
}
