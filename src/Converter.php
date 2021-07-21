<?php

namespace Cristiangomeze\Template;

use Cristiangomeze\Template\Files\LocalTemporaryFile;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Converter
{
    protected $docxFile;
    protected $pdfFile;
    protected $timeout = 2000;

    public function __destruct()
    {
        $this->removeTemporaryFiles();
    }

    public function output(LocalTemporaryFile $docxFile)
    {
        $this->docxFile = $docxFile;

        $this->pdfFile = $this->convert();

        return $this->pdfFile->contents();
    }

    public function convert(): LocalTemporaryFile
    {
        $this->execCommand();

        return new LocalTemporaryFile($this->getPathConvertedPdfFile());
    }

    private function getPathConvertedPdfFile(): string
    {
        return config('template.temporary_files.local_path').config('template.temporary_files.prefix_folder').'/'.$this->docxFile->getFileName().'.pdf';
    }

    private function execCommand()
    {
        $process = (new Process($this->makeCommand()))->setTimeout($this->timeout);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function makeCommand(): array
    {
        $bin = config('template.command.bin')[config('template.command.default')];
        $tempDir = $this->docxFile->getLocalPath();
        $outDir = config('template.temporary_files.local_path').config('template.temporary_files.prefix_folder');

        return [
            $bin,
            '--headless',
            '--convert-to',
            'pdf',
            $tempDir,
            '--outdir',
            $outDir
        ];
    }

    protected function removeTemporaryFiles()
    {
        if ($this->docxFile instanceof LocalTemporaryFile) {

            $this->docxFile->delete();
        }

        if ($this->pdfFile instanceof LocalTemporaryFile
            && config('template.temporary_files.delete_after_rendering')) {

            $this->pdfFile->delete();
        }
    }
}
