<?php

class SearchRequestValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider validUrlProvider
     *
     * @param $url
     */
    public function testValidUrl($url)
    {
        $validator = new \Claw\Service\SearchRequestValidator();

        $request = new \Claw\Entity\SearchRequest();
        $request->setType(\Claw\Entity\SearchType::LINK);
        $request->setUrl($url);
        $request->setText('');

        $this->assertArrayNotHasKey('url', $validator->validate($request));
    }

    /**
     * @dataProvider invalidUrlProvider
     *
     * @param $url
     */
    public function testInvalidUrl($url)
    {
        $validator = new \Claw\Service\SearchRequestValidator();

        $request = new \Claw\Entity\SearchRequest();
        $request->setType(\Claw\Entity\SearchType::LINK);
        $request->setUrl($url);
        $request->setText('');

        $this->assertArrayHasKey('url', $validator->validate($request));
    }

    public function testEmptyText()
    {
        $validator = new \Claw\Service\SearchRequestValidator();

        $request = new \Claw\Entity\SearchRequest();
        $request->setUrl('http://example.com');
        $request->setType(\Claw\Entity\SearchType::TEXT);
        $request->setText('');

        $this->assertArrayHasKey('text', $validator->validate($request));
    }

    public function testInvalidType()
    {
        $validator = new \Claw\Service\SearchRequestValidator();

        $request = new \Claw\Entity\SearchRequest();
        $request->setUrl('http://example.com');
        $request->setType('invalid_type');
        $request->setText('');

        $this->assertArrayHasKey('type', $validator->validate($request));
    }

    public function testValidType()
    {
        $validator = new \Claw\Service\SearchRequestValidator();

        $request = new \Claw\Entity\SearchRequest();
        $request->setUrl('http://example.com');
        $request->setType(\Claw\Entity\SearchType::IMAGE);
        $request->setText(null);

        $this->assertCount(0, $validator->validate($request));
    }

    public function validUrlProvider()
    {
        return [
            ['http://example.com'],
            ['https://example.com'],
            ['http://кириллический-домен.рф'],
        ];
    }

    public function invalidUrlProvider()
    {
        return [
            ['ftp://example.com'],
            ['something really wrong'],
        ];
    }
}
