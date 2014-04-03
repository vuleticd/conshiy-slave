<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category    Conshiy
 * @package     Conshiy_Slave
 * @copyright   Copyright (c) 2014 a356 Development (http://www.a356dev.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Conshiy_Slave_Adminhtml_ValidateController extends Mage_Adminhtml_Controller_Action
{
	
	/**
	 * Validate API connection with Master website
	 *
	 * @return void
	 */
	public function indexAction() {
		
	}
	
	/**
     * Validate API connection with Master website
     *
     * @return void
     */
    public function ajaxAction()
    {
        $result = array(
        		'success' => 0,
        		'message' => 'Validation successful.'
        		);
        
        // test if API connection can be established
        try{
        	Mage::getModel('conshiyslave/api_client')->login(
        		$this->getRequest()->getParam('url'),
        		$this->getRequest()->getParam('username'),
        		$this->getRequest()->getParam('token')
        	);
        } catch (SOAP_Fault $fault){
        	$result['message'] = "Validation failed - " . $fault->getMessage();
        } catch (Exception $e) {
        	$result['message'] = "Validation failed - " . $e->getMessage();
        }
        
        $result['success'] = 1;
        
        $json = json_encode($result);
        $this->getResponse()
        	->clearHeaders()
        	->setHeader('Content-Type', 'application/json')
        	->setBody($json);
        
    }
	
}