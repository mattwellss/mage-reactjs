<?php

class Mpw_ReactJs_Block_Bundle extends Mage_Core_Block_Template
{
    protected $_frameOpenTag = 'script';
    protected $_frameCloseTag = '/script';
    protected $_allowSymlinks = 1;

    public function _beforeToHtml()
    {
        /** @var Mage_Core_Block_Text_List */
        $components = $this->getChild('components');
        $componentRequest = [];
        foreach ($components->getChild() as $child) {
            $componentRequest[] = [
                'template' => $child->getTemplateFile(),
                'props' => $child->getTemplateData(),
                'destination' => $child->getDestination(),
                'component_name' => $child->getComponentName(),
            ];
        }
        $this->setBundleSource(
            $this->helper('reactjs/renderer')->reactRequest(
                'bundle', $componentRequest)->getBody());
    }
}
