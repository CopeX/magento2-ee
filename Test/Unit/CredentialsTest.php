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
 * License Version 2 (GPLv2) and can be used, developed and passed on to third parties under
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

namespace Wirecard\ElasticEngine\Test\Unit\Adminhtml\Test;

use GuzzleHttp\Psr7\Request;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Authorization;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Wirecard\ElasticEngine\Controller\Adminhtml\Test\Credentials;

class CredentialsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Credentials
     */
    private $instance;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var Json
     */
    private $json;

    public function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        $context = $this->getMock(Context::class, [
            'getRequest',
            'getAuthorization'
        ], [], '', false);

        $authorization = $this->getMock(Authorization::class, ['isAllowed'], [], '', false);
        $authorization->method('isAllowed')->willReturn(true);
        $context->method('getAuthorization')->willReturn($authorization);

        $request = $this->getMock(Request::class, ['getParams'], [], '', false);
        $request->method('getParams')->willReturn([
            'baseUrl' => 'http://localhost',
            'httpUser' => 'user',
            'httpPass' => 'pass'
        ]);
        $context->method('getRequest')->willReturn($request);


        $this->json = $this->getMock(Json::class, ['setData'], [], '', false);
        $this->resultJsonFactory = $this->getMock(JsonFactory::class, ['create'], [], '', false);
        $this->resultJsonFactory->method('create')->willReturn($this->json);

        $data = [
            'context' => $context,
            'resultJsonFactory' => $this->resultJsonFactory
        ];
        $this->instance = $this->objectManager->getObject(Credentials::class, $data);
    }

    public function testConstructor()
    {
        $this->assertAttributeEquals($this->resultJsonFactory, 'resultJsonFactory', $this->instance);
    }

    public function testExecute()
    {
        $this->json->expects($this->once())->method('setData');
        $this->instance->execute();
    }
}
