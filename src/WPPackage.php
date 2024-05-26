<?php

namespace RenVentura\WPPackageParser;

use RenVentura\WPPackageParser\Parsers;
use ZipArchive;

/**
 * Class for interacting with WordPress packages (plugins and themes)
 */
class WPPackage
{
    /**
     * Metadata.
     *
     * @var array<string, string>
     */
    protected $metadata = array();

    /**
     * Package file path.
     *
     * @var string
     */
    private $package_path;

    /**
     * Package type.
     *
     * @var string
     */
    private $type = null;

    /**
     * Construct a package instance and parse the provided zip file.
     *
     * @param $package_path
     */
    public function __construct(string $package_path)
    {
        $this->package_path = $package_path;
        $this->parse();
    }

    /**
     * Get slug.
     *
     * @return string|null
     */
    public function getSlug(): string|null
    {
        $metadata = $this->getMetaData();

        if (! isset($metadata['slug'])) {
            return null;
        }

        return $metadata['slug'];
    }

    /**
     * Get metadata.
     *
     * @return array<string, string>
     */
    public function getMetaData(): array
    {
        return $this->metadata;
    }

    /**
     * Parse package.
     *
     * @return bool
     */
    private function parse(): bool
    {
        if (! $this->validateFile()) {
            return false;
        }

        $plugin_parser = new Parsers\PluginParser();
        $theme_parser  = new Parsers\ThemeParser();

        $slug  = null;
        $zip   = $this->openPackage();
        $files = $zip->numFiles;

        for ($index = 0; $index < $files; $index++) {
            $info = $zip->statIndex($index);

            $file = $this->exploreFile($info['name']);
            if (! $file) {
                continue;
            }

            $slug      = $file['dirname'];
            $file_name = $file['name'] . '.' . $file['extension'];
            $content   = $zip->getFromIndex($index);

            if ($file['extension'] === 'php') {
                $headers = $plugin_parser->parsePlugin($content);

                if ($headers) {
                    //Add plugin file
                    $plugin_file       = $slug . '/' . $file_name;
                    $headers['plugin'] = $plugin_file;

                    $this->type     = 'plugin';
                    $this->metadata = array_merge($this->metadata, $headers);
                }

                continue;
            }

            if ($file_name === 'readme.txt') {
                $data = $plugin_parser->parseReadme($content);
                unset($data['name']);
                $data['readme'] = true;
                $this->metadata = array_merge($data, $this->metadata);

                continue;
            }

            if ($file_name === 'style.css') {
                $headers = $theme_parser->parseStyle($content);
                if ($headers) {
                    $this->type     = 'theme';
                    $this->metadata = $headers;
                }
            }
        }

        if (empty($this->type)) {
            $this->metadata = array();

            return false;
        }

        $this->metadata['slug'] = $slug;

        return true;
    }

    /**
     * Get package type.
     *
     * @return string|null
     */
    public function getType(): string|null
    {
        return $this->type;
    }

    /**
     * Explore file.
     *
     * @param string $file_name File name.
     *
     * @return bool|array<string, string>
     */
    private function exploreFile(string $file_name): bool|array
    {
        $data      = pathinfo($file_name);
        $dirname   = $data['dirname'];
        $depth     = substr_count($dirname, '/');
        $extension = ! empty($data['extension']) ? $data['extension'] : false;

        //Skip directories and everything that's more than 1 sub-directory deep.
        if ($depth > 0 || ! $extension) {
            return false;
        }

        return array(
            'dirname'   => $dirname,
            'name'      => $data['filename'],
            'extension' => $data['extension']
        );
    }

    /**
     * Validate package file.
     *
     * @return bool
     */
    private function validateFile()
    {
        $file = $this->package_path;

        if (! file_exists($file) || ! is_readable($file)) {
            return false;
        }

        if ('zip' !== pathinfo($file, PATHINFO_EXTENSION)) {
            return false;
        }

        return true;
    }

    /**
     * Open package file.
     *
     * @return false|ZipArchive
     */
    private function openPackage(): bool|ZipArchive
    {
        $file = $this->package_path;

        $zip = new ZipArchive();
        if ($zip->open($file) !== true) {
            return false;
        }

        return $zip;
    }
}
