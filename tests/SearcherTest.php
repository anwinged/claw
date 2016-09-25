<?php

class SearcherTest extends PHPUnit_Framework_TestCase
{
    public function testImageSearch()
    {
        $searcher = new \Claw\Service\Searcher\ImageSearcher();
        $content = file_get_contents(__DIR__.'/text.html');

        $this->assertEquals(3, count($searcher->find($content)));
    }

    public function testLinkSearch()
    {
        $searcher = new \Claw\Service\Searcher\LinkSearcher();
        $content = file_get_contents(__DIR__.'/text.html');

        $this->assertEquals(2, count($searcher->find($content)));
    }

    public function testTextSearch()
    {
        $searcher = new \Claw\Service\Searcher\TextSearcher('img');
        $content = file_get_contents(__DIR__.'/text.html');

        $this->assertEquals(4, count($searcher->find($content)));
    }
}
