<?php

namespace Thepany\Template;

use Illuminate\Support\Facades\Log;
use Thepany\Template\Exceptions\CannotConvertException;
use Thepany\Template\Files\LocalTemporaryFile;

class Converter
{
    protected $docxFile;
    protected $pdfFile;

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
        $shell = $this->execCommand($this->makeCommand());

        if ($shell['return'] != 0) {
            Log::error($shell);
            throw new CannotConvertException;
        }

        return new LocalTemporaryFile($this->getPathConvertedPdfFile());
    }


    private function getPathConvertedPdfFile(): string
    {
        return config('template.temporary_files.local_path').config('template.temporary_files.prefix_folder').'/'.$this->docxFile->getFileName().'.pdf';
    }


    private function makeCommand(): string
    {
        return config('template.command.bin')[config('template.command.default')]
            .' --headless --convert-to pdf '.escapeshellarg($this->docxFile->getLocalPath()).' --outdir '
            .config('template.temporary_files.local_path')
            .config('template.temporary_files.prefix_folder');
    }

    private function execCommand($cmd, $input = ''): array
    {
        $process = proc_open($cmd, [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);

        fwrite($pipes[0], $input);
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $rtn = proc_close($process);

        return [
            'stdout' => $stdout,
            'stderr' => $stderr,
            'return' => $rtn
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
