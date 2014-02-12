<?php namespace Affinity\Imagecache;

use Symfony\Component\HttpFoundation\File\File;

class Imagecache {

  protected $rootDir;

  protected $webDir;

  protected $presets;

  protected $placeholder;

  protected $defaultLifetime = 5;

  public function __construct($root_dir, $web_dir, $presets = array(), $placeholder = NULL) {
    $this->rootDir = $root_dir;
    $this->webDir = $web_dir;
    $this->presets = $presets;
    $this->placeholder = $placeholder;
  }

  public function cache($path, $preset_name, $lifetime = NULL, $options = array(), $absolute = FALSE, $placeholder = NULL) {
    if (!isset($this->presets[$preset_name])) {
      throw new \Exception("Unknown imagecache preset: '$preset_name'");
    }

    $path = $path ?: $this->placeholder;

    if (!$path) {
      throw new \Exception("No image path provided and no default image configured.");
    }

    $preset = $this->presets[$preset_name];

    if (!$lifetime) {
      $lifetime = $this->defaultLifetime;
    }

    $file = new File($path);
    $filename = "{$preset_name}-{$file->getFilename()}";
    $dest = "{$this->rootDir}/$filename";

    \Image::cache(function ($image) use ($path, $dest, $preset, $options) {
      return $preset($image->make($path), $options)->save($dest);
    }, $lifetime);

    $base_dir = $absolute ? $this->rootDir : $this->webDir;
    return "{$base_dir}/{$filename}";
  }

}
