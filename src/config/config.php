<?php

return [
  'cache_root_dir' => '',
  'cache_web_dir' => '',
  'presets' => [
    'thumbnail' => function ($image, $options) {
      return $image->resize(50, 50);
    },
    'banner' => function ($image, $options) {
      return $image->resize(800, 400)->grayscale();
    },
  ],
];
