<?php

class SearcherTest extends PHPUnit_Framework_TestCase
{
    public function testImageSearch()
    {
        $searcher = new \Claw\Service\Searcher\ImageSearcher();
        $content = $this->getContent();

        $expected = [
            '<img src="" alt="1">',
            '<img src="" alt="2">',
            '<img src="" alt="3">',
        ];

        $this->assertEquals($expected, $searcher->find($content));
    }

    public function testLinkSearch()
    {
        $searcher = new \Claw\Service\Searcher\LinkSearcher();
        $content = $this->getContent();

        $expected = [
            '<a href="">1</a>',
            '<a href="#"><span>text</span></a>',
        ];

        $this->assertEquals($expected, $searcher->find($content));
    }

    public function testTextSearch()
    {
        $searcher = new \Claw\Service\Searcher\TextSearcher('img');
        $content = $this->getContent();

        $expected = [
            'img',
            'img',
            'img',
            'img',
        ];

        $this->assertEquals($expected, $searcher->find($content));
    }

    private function getContent()
    {
        return file_get_contents(__DIR__.'/text.html');
    }
}
