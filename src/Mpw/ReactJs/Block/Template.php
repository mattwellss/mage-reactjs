<?php

class Mpw_ReactJs_Block_Template extends Mage_Core_Block_Template
{
    const RENDER_ISOMORPHIC = 1;
    const RENDER_FRONTEND = 2;

    protected function _construct()
    {
        parent::_construct();

        $this->helper = Mage::helper('reactjs/renderer');
        $this->_renderMode = $this->getData('render_mode') ?: static::RENDER_ISOMORPHIC;
    }

    public function getRenderMode()
    {
        return $this->_renderMode;
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
