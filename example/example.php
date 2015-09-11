<?php

require '../vendor/autoload.php';
require '../tmp/mage/app/Mage.php';

$block = new Mpw_ReactJs_Block_Template;
$block->setTemplate('example.jsx');

$block->setTemplateData(array(
    'name' => 'Matt'));

$block->setComponentName('Person');

$block->setDestination('document.body');

$blockHtml = $block->toHtml(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>React fun</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.min.js"></script>
</head>
<body>
<?= $blockHtml ?>
</body>
</html>

