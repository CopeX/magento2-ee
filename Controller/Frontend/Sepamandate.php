<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard Central Eastern Europe GmbH
 * (abbreviated to Wirecard CEE) and are explicitly not part of the Wirecard CEE range of
 * products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 3 (GPLv3) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Wirecard CEE does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard CEE does not guarantee their full
 * functionality neither does Wirecard CEE assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Wirecard CEE does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */

namespace Wirecard\ElasticEngine\Controller\Frontend;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

class Sepamandate extends Action
{
    private $session;

    /**
     * @var LoggerInterface
     */
    private $logger;

    protected $_url;

    protected $_order;

    protected $_resultPageFactory;



    public function __construct(Context $context, PageFactory $resultPageFactory, Session $session, LoggerInterface $logger)
    {
        parent::__construct($context);

        $this->session = $session;
        $this->logger = $logger;
        $this->_url               = $context->getUrl();
        $this->_resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $this->logger->debug('Sepa: ');


        $page = $this->_resultPageFactory->create();
        $page->getLayout()->getBlock('frontend.sepamandate');

        return $page;
    }
}
