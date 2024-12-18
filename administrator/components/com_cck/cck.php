<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: cck.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

$app	=	JFactory::getApplication();
$task	=	$app->input->get( 'task' );
$view	=	$app->input->get( 'view' );

if ( !JFactory::getUser()->authorise( 'core.manage', 'com_cck' )
  && !( $view == 'form' || $view == 'list' || $task == 'download' || in_array( substr( $task, 0, 5 ), array( 'form.', 'list.' ) ) ) ) {
	return JError::raiseWarning( 404, JText::_( 'JERROR_ALERTNOAUTHOR' ) );
}

$lang			=	JFactory::getLanguage();
$lang_default	=	$lang->setDefault( 'en-GB' );
$lang->load( 'com_cck' );
$lang->load( 'com_cck_default', JPATH_SITE );
$lang->load( 'com_cck_core' );
$lang->setDefault( $lang_default );

require_once JPATH_COMPONENT.'/helpers/helper_define.php';
require_once JPATH_COMPONENT.'/helpers/helper_display.php';
require_once JPATH_COMPONENT.'/helpers/helper_include.php';

$controller	=	JControllerLegacy::getInstance( 'CCK' );
$controller->execute( $app->input->get( 'task' ) );
$controller->redirect();
?>