<?php
require_once (dirname(__FILE__).'/class-tgm-plugin-activation.php');
require_once (dirname(__FILE__).'/plugins.php');
require_once (dirname(__FILE__).'/options.php');
if (class_exists('WPBakeryVisualComposerAbstract')) {
    require_once (dirname(__FILE__).'/visual_composer.php');
}