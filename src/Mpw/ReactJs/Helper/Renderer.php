<?php

class Mpw_ReactJs_Helper_Renderer extends Mage_Core_Helper_Abstract
{
    const REACT_SRC_PATH = './react.min.js';

    protected $reactSrc;

    public function renderTemplate(Mpw_ReactJs_Block_Template $template)
    {
        try {
            $rjsTemplate = new ReactJS(
                $this->getReactSrc(),
                $template->getSrc());

            $rjsTemplate->setComponent(
                $template->getComponentName(),
                $template->getTemplateData());

            return $rjsTemplate->getMarkup() . $this->renderTemplateJs($template);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    protected function renderTemplateJs(Mpw_ReactJs_Block_Template $template)
    {
        // $out = $this->getLayout()->createBlock('core/template');
        $out = new Mage_Core_Block_Template;
        $out->setTemplate('reactjs/embedded.phtml');
        $out->setData([
            'src' => $template->getSrc(),
            'component_name' => $template->getComponentName(),
            'template_data' => $template->getTemplateData(),
            'destination' => $template->getDestination()]);

        return $out->toHtml();
    }

    protected function getReactSrc()
    {
        if (is_null($this->reactSrc)) {
            $this->reactSrc = file_get_contents(static::REACT_SRC_PATH);
        }

        return $this->reactSrc;
    }

}
