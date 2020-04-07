<?php

namespace Thepany\Template\Tests\Unit;

use Thepany\Template\Template;
use Thepany\Template\Tests\TestCase;

class TemplateTest extends TestCase
{
    /** @test */
    function it_can_pass_word_template()
    {
        $object = Template::make(__DIR__.'/../_files/template.docx');

        $this->assertInstanceOf(Template::class, $object);
        $this->assertCount(3, $object->getVariableCount());
        $this->assertEquals([
            'name',
            'last_name',
            'content'
        ], $object->getVariables());
    }

    /** @test */
    function it_can_preview_template()
    {
        $this->assertInstanceOf('Illuminate\Http\Response', Template::make(__DIR__.'/../_files/template.docx')->preview());
    }
}
