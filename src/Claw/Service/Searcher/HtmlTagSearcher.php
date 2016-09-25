<?php

declare(strict_types=1);

namespace Claw\Service\Searcher;

class HtmlTagSearcher implements SearcherInterface
{
    /**
     * @var string
     */
    private $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function find(string $content)
    {
        // Workaround for DOMDocument encoding:
        // https://gist.github.com/Xeoncross/9401853

        libxml_use_internal_errors(true);

        $doc = new \DOMDocument('1.0', 'UTF-8');
        $convertedContent = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
        $loadResult = $doc->loadHTML($convertedContent);

        if ($loadResult === false) {
            $message = sprintf(
                'DOMDocument can\'t load content: %s',
                $this->handleLibXmlErrors(libxml_get_errors())
            );
            libxml_clear_errors();
            throw new \RuntimeException($message);
        }

        $nodes = $doc->getElementsByTagName($this->tag);

        $matches = [];

        foreach ($nodes as $node) {
            /* @var \DOMNode $node */
            $matches[] = $doc->saveHTML($node);
        }

        return $matches;
    }

    private function handleLibXmlErrors(array $errors)
    {
        $messages = [];
        foreach ($errors as $error) {
            /* @var \LibXMLError $error */
            $messages[] = $error->message;
        }

        return implode('; ', $messages);
    }
}
