<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: view.raw.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// View
class CCKViewField extends JCckBaseLegacyViewForm
{
	protected $vName	=	'field';
	protected $vTitle	=	_C3_TEXT;
	
	// prepareDisplay
	protected function prepareDisplay()
	{
		$app			=	JFactory::getApplication();
		$model 			=	$this->getModel();
		$this->form		=	$this->get( 'Form' );
		$this->item		=	$this->get( 'Item' );
		$this->option	=	$app->input->get( 'option', '' );
		$this->state	=	$this->get( 'State' );
		
		// Check Errors
		if ( count( $errors	= $this->get( 'Errors' ) ) ) {
			throw new Exception( implode( "\n", $errors ), 500 );
		}
		
		$this->isNew			=	( @$this->item->id > 0 ) ? 0 : 1;
		$this->item->folder		=	Helper_Admin::getSelected( $this->vName, 'folder', $this->item->folder, 1 );
		$this->item->published	=	Helper_Admin::getSelected( $this->vName, 'state', ( ( ( $this->isNew ) ? $this->state->get( 'ajax.state' ) : $this->item->published ) ), 1 );
		$this->item->published	=	(int)$this->item->published < 0 ? 1 : $this->item->published;
		$this->item->type		=	Helper_Admin::getSelected( $this->vName, 'type', $app->input->getString( 'ajax_type', $this->state->get( 'ajax.type', $this->item->type ) ), 'text' );
	}
}
?>