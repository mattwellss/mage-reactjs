<?php

class Mpw_ReactJs_Block_Template extends Mage_Core_Block_Template
{
    public function __construct()
    {
        // $this->helper = Mage::helper('reactjs/renderer');
        $this->helper = new Mpw_ReactJs_Helper_Renderer;
    }

    protected function _beforeToHtml()
    {
        $this->src = file_get_contents($this->getTemplateFile());
        return parent::_beforeToHtml();
    }

    /**
     * Render a JSX view
     * @return string
     */
    public function renderView()
    {
        return $this->helper->renderTemplate($this);
    }

    /**
     * Get the source as a string
     * @return string
     */
    protected function getSrc()
    {
        return $this->src;
    }
}
