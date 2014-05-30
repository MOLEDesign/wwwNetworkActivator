<?php

require(__DIR__.'/../../../layouts/theme.config.php');

// add script
$this['asset']->addFile('css', 'css:customstyles.css');

// add script
$this['asset']->addFile('js', 'js:customscripts.js');