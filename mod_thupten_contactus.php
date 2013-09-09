<?php
/**
 * Module Entry Point
 * 
 * @package    Thupten.ContactUs
 * @subpackage Module
 * @link http://thupten_contactus.hellothupten.com
 * @license        GNU/GPL, see LICENSE.php
 * mod_thupten_contactus is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
require_once( dirname(__FILE__).'/helper.php' );
 
$model = modThuptenContactUsHelper::getContactUs( $params );

require( JModuleHelper::getLayoutPath( 'mod_thupten_contactus' ) );