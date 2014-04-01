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
class Conshiy_Slave_Model_Api extends Mage_Api_Model_Resource_Abstract
{    
	/*
	 * Submits job notifications in slave queuing table. Only submits notifications if they don't exist.
	 * 
	 * @param object $jobData {model,identifier}
	 * @return true or SOAP Fault.
	 */
    public function submit($jobData)
    {
    	$job_exist = Mage::getModel('conshiyslave/jobs')->getUniqueJob($jobData->model, $jobData->identifier);
    	if (!$job_exist) {
    		try {
    			$job = Mage::getModel('conshiyslave/jobs')
    				->setResourceModel($jobData->model)
    				->setResourceIdentifier($jobData->identifier)
    				->save();
    		} catch (Mage_Core_Exception $e) {
    			$this->_fault('job_not_submitted', $e->getMessage());
    		} catch (Exception $e) {
    			$this->_fault('job_not_submitted', $e->getMessage());
    		}
    	}
   
    	return true;
    }
    
}
