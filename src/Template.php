<?php

namespace Cristiangomeze\Template;

use Cristiangomeze\Template\Files\LocalTemporaryFile;
use Illuminate\Http\Response;
use PhpOffice\PhpWord\TemplateProcessor;

class Template extends TemplateProcessor
{
    protected $converter;

    public function __construct($documentTemplate)
    {
        $this->converter = new Converter();

        parent::__construct($documentTemplate);
    }

    public static function make(string $documentTemplate)
    {
        return new self($documentTemplate);
    }

    public function addValues(array $values)
    {
        $this->setValues($values);

        return $this;
    }

    public function addImages(array $values)
    {
        foreach ($values as $search => $value) {
            $this->setImageValue($search, $value);
        }

        return $this;
    }

    public function addWatermark(string $watermark = '')
    {
        $this->setValue('WATERMARK', $watermark);

        return $this;
    }

    public function preview($fileName = 'document.pdf')
    {
        return new Response($this->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$fileName.'"',
        ]);
    }

    private function output()
    {
        return $this->converter->output(new LocalTemporaryFile($this->save()));
    }
}
