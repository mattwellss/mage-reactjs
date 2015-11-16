<?php

class Mpw_ReactJs_Helper_Renderer extends Mage_Core_Helper_Abstract
{
    const REACT_SRC_PATH = './react.js';

    protected $_reactSrc;
    protected $_requestProto;

    /**
     * @var Mage_Core_Block_Template
     */
    protected $_reactBundleBlock;

    public function __construct()
    {
        $this->setLayout(Mage::getSingleton('core/layout'));
        $this->_outBlockProto = $this->getLayout()->createBlock('core/template');
        $this->_requestProto = new Zend_Http_Client('http://localhost:3000');
        $this->_requestProto->setHeaders(['Content-type' => 'application/json; charset=utf-8']);
        $reactFrontend = $this->getLayout()
            ->createBlock('reactjs/bundle', 'reactjs-bundle', ['template' => 'reactjs/bundle.phtml']);
        $this->_reactBundleBlock = $this->getLayout()->createBlock('core/text_list');
        $reactFrontend->setChild('components', $this->_reactBundleBlock);
    }

    public function renderTemplate(Mpw_ReactJs_Block_Template $template)
    {
        try {
            $this->registerFrontendJs($template);
            return $this->renderTemplateHtml($template);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    /**
     * @param  Mpw_ReactJs_Block_Template $template
     * @return string
     */
    protected function renderTemplateHtml(Mpw_ReactJs_Block_Template $template)
    {
        if ($template->getRenderMode() == $template::RENDER_FRONTEND) {
            return '';
        }

        $response = $this->reactRequest(
            'render',
            [
                'props' => $template->getTemplateData(),
                'template' => $template->getTemplateFile()
            ]);

        return $response->getBody();

        // $rjsTemplate = new ReactJS(
        //     $this->getReactSrc(),
        //     $template->getSrc());

        // $rjsTemplate->setComponent(
        //     $template->getComponentName(),
        //     $template->getTemplateData());

        // return $rjsTemplate->getMarkup();
    }

    public function reactRequest($endPoint, array $data = null)
    {
        $request = clone $this->_requestProto;
        $requestUri = $request->getUri()->__toString() . '/' . $endPoint;
        $request->setUri($requestUri);
        if (is_array($data)) {
            $request->setRawData(Mage::helper('core')->jsonEncode($data));
        }

        return $request->request($data ? Zend_Http_Client::POST : Zend_Http_Client::GET);
    }

    /**
     * @param  Mpw_ReactJs_Block_Template $template
     * @return void
     */
    protected function registerFrontendJs(Mpw_ReactJs_Block_Template $template)
    {
        $this->_reactBundleBlock->append($template);
    }

    protected function getReactSrc()
    {
        if (is_null($this->reactSrc)) {
            $this->reactSrc = file_get_contents(static::REACT_SRC_PATH);
        }

        return $this->reactSrc;
    }

}
