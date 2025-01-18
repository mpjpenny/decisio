<?php

use PHPHtmlParser\Dom\Tag;

class NodeTagTest extends PHPUnit_Framework_TestCase {

    public function testSelfClosing()
    {
        $tag = new Tag('a');
        $tag->selfClosing();
        $this->assertTrue($tag->isSelfClosing());
    }

    public function testSetAttributes()
    {
        $attr = [
            'href' => [
                'value'       => 'https://google.com',
                'doublequote' => false,
            ],
        ];

        $tag = new Tag('a');
        $tag->setAttributes($attr);
        $this->assertEquals('https://google.com', $tag->getAttribute('href')['value']);
    }

    public function testRemoveAttribute()
    {
        $tag = new Tag('a');
        $tag->setAttribute('href', 'https://google.com');
        $tag->removeAttribute('href');
        $this->assertNull($tag->getAttribute('href')['value']);
    }

    public function testRemoveAllAttributes()
    {
        $attr = [
                'class' => [
                        'value'       => 'clear-fix',
                        'doubleQuote' => true,
                ],
        ];

        $tag = new Tag('a');
        $tag->setAttribute('href', 'https://google.com');
        $tag->setAttribute('class', $attr);
        $tag->removeAllAttributes();
        $this->assertEquals(0, count($tag->getAttributes()));
    }

    public function testSetAttributeNoArray()
    {
        $tag = new Tag('a');
        $tag->setAttribute('href', 'https://google.com');
        $this->assertEquals('https://google.com', $tag->getAttribute('href')['value']);
    }

    public function testSetAttributesNoDoubleArray()
    {
        $attr = [
            'href'  => 'https://google.com',
            'class' => 'funtimes',
        ];

        $tag = new Tag('a');
        $tag->setAttributes($attr);
        $this->assertEquals('funtimes', $tag->class['value']);
    }

    public function testNoise()
    {
        $tag = new Tag('a');
        $this->assertTrue($tag->noise('noise') instanceof Tag);
    }

    public function testGetAttributeMagic()
    {
        $attr = [
            'href' => [
                'value'       => 'https://google.com',
                'doublequote' => false,
            ],
        ];

        $tag = new Tag('a');
        $tag->setAttributes($attr);
        $this->assertEquals('https://google.com', $tag->href['value']);
    }

    public function testSetAttributeMagic()
    {
        $tag = new Tag('a');
        $tag->href = 'https://google.com';
        $this->assertEquals('https://google.com', $tag->href['value']);
    }

    public function testMakeOpeningTag()
    {
        $attr = [
            'href' => [
                'value'       => 'https://google.com',
                'doubleQuote' => true,
            ],
        ];

        $tag = new Tag('a');
        $tag->setAttributes($attr);
        $this->assertEquals('<a href="https://google.com">', $tag->makeOpeningTag());
    }

    public function testMakeOpeningTagEmptyAttr()
    {
        $attr = [
            'href' => [
                'value'       => 'https://google.com',
                'doubleQuote' => true,
            ],
        ];

        $tag = new Tag('a');
        $tag->setAttributes($attr);
        $tag->selected = [
            'value' => null,
        ];
        $this->assertEquals('<a href="https://google.com" selected>', $tag->makeOpeningTag());
    }

    public function testMakeOpeningTagSelfClosing()
    {
        $attr = [
            'class' => [
                'value'       => 'clear-fix',
                'doubleQuote' => true,
            ],
        ];

        $tag = new Tag('div');
        $tag->selfClosing()
            ->setAttributes($attr);
        $this->assertEquals('<div class="clear-fix" />', $tag->makeOpeningTag());
    }

    public function testMakeClosingTag()
    {
        $tag = new Tag('a');
        $this->assertEquals('</a>', $tag->makeClosingTag());
    }

    public function testMakeClosingTagSelfClosing()
    {
        $tag = new Tag('div');
        $tag->selfClosing();
        $this->assertEmpty($tag->makeClosingTag());
    }
}
