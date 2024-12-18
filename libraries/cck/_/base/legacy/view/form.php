<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: form.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// View
class JCckBaseLegacyViewForm extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;
	
	// display
	public function display( $tpl = null )
	{
		if ( $this->getlayout() == 'delete' ) {
			$this->prepareDelete();
		} elseif ( $this->getLayout() == 'edit' || $this->getLayout() == 'edit2' || $this->getLayout() == 'process' ) {
			$this->prepareDisplay();
		}

		$this->prepareToolbar();
		$this->prepareUI();
		$this->completeUI();
		
		parent::display( $tpl );
	}
	
	// prepareDelete
	protected function prepareDelete()
	{
		Helper_Admin::addToolbarDelete( $this->vName, $this->vTitle );
	}
	
	// prepareDisplay
	protected function prepareDisplay()
	{
	}
	
	// completeUI
	protected function completeUI()
	{
		$title	=	( ( is_object( $this->item ) && $this->item->title != '' ) ? '"'.$this->item->title.'"' : JText::_( 'COM_CCK_ADD_NEW' ) ).' '.JText::_( 'COM_CCK_'.$this->vName );
		
		$this->document->setTitle( $title );
	}

	// prepareUI
	protected function prepareUI()
	{
		$this->css	=	array(
							'btn'=>'btn',
							'btn-no'=>'button-cancel btn btn-danger',
							'btn-yes'=>'button-save btn btn-success',
							'w30'=>'span4 col-lg-4',
							'w70'=>'span8 col-lg-8',
							'wrapper'=>'',
							'wrapper_first'=>'',
							'wrapper2'=>'row-fluid',
							'wrapper_tmpl'=>'span12'
						);

		if ( !JCck::on( '4' ) ) {
			$this->css['btn']			=	'btn btn-small';
			$this->css['btn-no']		=	'btn btn-small';
			$this->css['btn-yes']		=	'btn btn-small';
			$this->css['wrapper']		=	'container';
			$this->css['wrapper_first']	=	'seblod first';
		}
	}
	
	// prepareToolbar
	protected function prepareToolbar()
	{
	}
}
?>