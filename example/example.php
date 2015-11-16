<?php

require '../tmp/mage/app/Mage.php';
require '../vendor/autoload.php';

Mage::app();
Mage::setIsDeveloperMode(true);

set_include_path(
    implode(PS, array_merge(
        explode(PS, get_include_path()),
        ['../src'])));

Mage::getConfig()->loadFile('../src/Mpw/ReactJs/etc/config.xml');

/** @var Mage_Core_Model_Layout */
$layout = Mage::getSingleton('core/layout');

$block = $layout->createBlock(
    'reactjs/template',
    'example.me',
    [
        'render_mode' => Mpw_ReactJs_Block_Template::RENDER_ISOMORPHIC,
        'template' => 'example.jsx',
        'component_name' => 'Person',
        'destination' => 'document.querySelector(\'#person\')',
        'template_data' => [
            'name' => 'Matt'
        ]
    ]
);

$block2 = $layout->createBlock(
    'reactjs/template',
    'example.table',
    [
        'render_mode' => Mpw_ReactJs_Block_Template::RENDER_ISOMORPHIC,
        'template' => 'table.jsx',
        'component_name' => 'Table',
        'destination' => 'document.querySelector(\'#table\')',
        'template_data' => [
            'data' => [
                [1,2,3],
                [4,5,6],
                [7,8,9]
            ]
        ]
    ]
);

$block3 = $layout->createBlock(
    'reactjs/template',
    'example.myclock',
    [
        'render_mode' => Mpw_ReactJs_Block_Template::RENDER_ISOMORPHIC,
        'template' => 'myclock.jsx',
        'component_name' => 'MyClock',
        'template_data' => [
            'timestamp' => time()
        ],
        'destination' => 'document.querySelector(\'#table2\')'
    ]
);

$time = microtime(true);
$blockHtml = $block->toHtml();
$block2Html = $block2->toHtml();
$block3Html = $block3->toHtml();
$timeEnd = microtime(true) - $time; ?>
<!DOCTYPE html>
<html>
<head>
    <title>React fun</title>
</head>
<body>
<div id="person">
    <?= $blockHtml ?>
</div>
<div id="table">
    <?= $block2Html ?>
</div>
<div id="table2">
    <?= $block3Html ?>
</div>
<?= $layout->getBlock('reactjs-bundle')->toHtml(); ?>
<h1><?= $timeEnd ?></h1>
</body>
</html>

