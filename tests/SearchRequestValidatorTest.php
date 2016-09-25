<?php

class SearchRequestValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testInvalidUrl()
    {
        $validator = new \Claw\Service\SearchRequestValidator();

        $request = new \Claw\Entity\SearchRequest();
        $request->setUrl('askfhslfh');
        $request->setType(\Claw\Entity\SearchType::LINK);
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
}
