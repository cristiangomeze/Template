<?php

namespace Thepany\Template\Files;

abstract class TemporaryFile
{
    /**
     * @return string
     */
    abstract public function getDirName(): string;

    /**
     * @return string
     */
    abstract public function getBaseName(): string;

    /**
     * @return string
     */
    abstract public function getExtension(): string;

    /**
     * @return string
     */
    abstract public function getFileName(): string;

    /**
     * @return string
     */
    abstract public function getLocalPath(): string;

    /**
     * @return bool
     */
    abstract public function exists(): bool;

    /**
     * @param @param string|resource $contents
     */
    abstract public function put($contents);

    /**
     * @return bool
     */
    abstract public function delete(): bool;

    /**
     * @return resource
     */
    abstract public function readStream();

    /**
     * @return string
     */
    abstract public function contents(): string;

    /**
     * @return TemporaryFile
     */
    public function sync(): TemporaryFile
    {
        return $this;
    }
}
