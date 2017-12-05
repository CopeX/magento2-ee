<?php
/**
 * Shop System Plugins - Terms of Use
 *
 * The plugins offered are provided free of charge by Wirecard AG and are explicitly not part
 * of the Wirecard AG range of products and services.
 *
 * They have been tested and approved for full functionality in the standard configuration
 * (status on delivery) of the corresponding shop system. They are under General Public
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
 * the same terms.
 *
 * However, Wirecard AG does not provide any guarantee or accept any liability for any errors
 * occurring when used in an enhanced, customized shop system configuration.
 *
 * Operation in an enhanced, customized configuration is at your own risk and requires a
 * comprehensive test phase by the user of the plugin.
 *
 * Customers use the plugins at their own risk. Wirecard AG does not guarantee their full
 * functionality neither does Wirecard AG assume liability for any disadvantages related to
 * the use of the plugins. Additionally, Wirecard AG does not guarantee the full functionality
 * for customized shop systems or installed plugins of other vendors of plugins within the same
 * shop system.
 *
 * Customers are responsible for testing the plugin's functionality before starting productive
 * operation.
 *
 * By installing the plugin into the shop system the customer agrees to these terms of use.
 * Please do not use the plugin if you do not agree to these terms of use!
 */

namespace Wirecard\ElasticEngine\Test\Unit\Adminhtml\Support;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Result\PageFactory;
use Wirecard\ElasticEngine\Controller\Adminhtml\Support\Contact;

/**
 * Class CredentialsTest
 * @package Wirecard\ElasticEngine\Test\Unit\Adminhtml\Test
 * @method _isAllowed()
 */
class ContactUTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Contact $contact
     */
    private $contact;

    /**
     * @var PageFactory $resultPageFactory
     */
    private $resultPageFactory;

    private $page;

    private $context;

    public function setUp()
    {
        $this->context = $this->getMock(Context::class, [], [], '', false);

        $title = $this->getMock(Title::class, [], [], '', false);

        $resultPageConfig = $this->getMock(Config::class, [], [], '', false);
        $resultPageConfig->method('getTitle')->willReturn($title);

        $this->page = $this->getMock(Page::class, [], [], '', false);
        $this->page->method('setActiveMenu')->willReturn($this->page);
        $this->page->method('getConfig')->willReturn($resultPageConfig);

        $this->resultPageFactory = $this->getMock(PageFactory::class, ['create'], [], '', false);
        $this->resultPageFactory->method('create')->willReturn($this->page);

        $this->contact = new Contact($this->context, $this->resultPageFactory);
    }

    public function testExecute()
    {
        $this->assertEquals($this->page, $this->contact->execute());
    }

    public function testIsAllowed()
    {
        $authorization = $this->getMock(AuthorizationInterface::class, [], [], '', false);

        $testContact = new TestContact($this->context, $this->resultPageFactory);
        $this->assertNull($testContact->test_isAllowed($authorization));
    }
}

class TestContact extends Contact
{
    public function test_isAllowed($authorization)
    {
        $this->_authorization = $authorization;
        return $this->_isAllowed();
    }
}