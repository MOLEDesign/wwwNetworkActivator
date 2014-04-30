<?php

// Custom template style for Network Activator theme
// Code : Morgan@MOLEDesign.biz

require(__DIR__.'/../../../layouts/theme.config.php');

// add css
$this['asset']->addFile('css', 'css:overrides.css');

// add script
$this['asset']->addFile('js', 'js:custom.js');