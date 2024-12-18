<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: list.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// View
class JCckBaseLegacyViewList extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	
	// display
	public function display( $tpl = null )
	{
		if ( $this->getlayout() == 'element' ) {
			$this->prepareDisplay();
		} else {
			$this->prepareDisplay();
			$this->prepareBatch();
		}
		
		if ( count( $errors = $this->get( 'Errors' ) ) ) {
			throw new Exception( implode( "\n", $errors ), 500 );
		}
		
		$this->prepareToolbar();
		$this->prepareUI();
		$this->completeUI();
		
		parent::display( $tpl );
	}

	// getSortFields
	protected function getSortFields()
	{
		return array(
					'a.id'=>JText::_( 'COM_CCK_ID' ),
					'a.title'=>JText::_( 'COM_CCK_TITLE' )
				);
	}
	
	// prepareBatch
	protected function prepareBatch()
	{
	}
	
	// prepareDisplay
	protected function prepareDisplay()
	{
		$app				=	JFactory::getApplication();
		$this->items		=	$this->get( 'Items' );
		$this->option		=	$app->input->get( 'option', '' );
		$this->pagination	=	$this->get( 'Pagination' );
		$this->state		=	$this->get( 'State' );
	}
	
	// completeUI
	protected function completeUI()
	{
		$this->document->setTitle( JText::_( $this->vTitle.'_MANAGER' ) );
	}

	// prepareUI
	protected function prepareUI()
	{
		$this->css		=	array( 'batch'=>'modal modal-small hide fade',
								   'btn-count'=>'btn btn-micro btn-count hasTooltip',
								   'filter'=>'',
								   'filter_search'=>'filter-search btn-group pull-left hidden-phone input-append',
								   'filter_search_button'=>'tip hasTooltip',
								   'filter_search_buttons'=>'btn-group pull-left hidden-phone',
								   'filter_search_list'=>'pull-right hidden-phone',
								   'filter_select'=>'filter-select hidden-phone hidden-important',
								   'items'=>'seblod-manager clearfix',
								   'joomla3'=>' hide',
								   'table'=>'table table-striped',
								   'w50'=>'span6',
								   'wrapper'=>'row-fluid'
							);
		$this->html		=	array( 'attr_modal_close'=>'data-dismiss="modal"',
								   'filter_select_divider'=>'<div class="filter-search pull-right solo">',
								   'filter_select_header'=>'<h4 class="page-header">'.JText::_( 'JSEARCH_FILTER_LABEL' ).'</h4>',
								   'filter_select_header_custom'=>'<h4 class="page-header">*title*</h4>',
								   'filter_select_separator'=>'<hr class="hr-condensed" />'
							);
		$this->js		=	array( 'filter'=>'' );
		$this->sidebar	=	JHtmlSidebar::render();

		if ( JCck::on( '4.0' ) ) {
			$this->css['btn-count']					=	'btn btn-count btn-sm btn-outline-secondary';
			$this->css['filter_search_button']		=	'btn btn-secondary';
			$this->css['filter_search_list']		.=	' solo';
			$this->css['filter_select']				=	'js-stools-container-filters-visible';
			$this->css['table']						=	'table';
			$this->css['w50']						=	'col-12 col-lg-6';
			$this->css['wrapper']					=	'row';
			$this->html['attr_modal_close']			=	'data-bs-dismiss="modal"';
			$this->html['filter_select_divider']	=	'</div><div class="filter-search pull-right solo">';
			$this->html['filter_select_header']		=	'';
			$this->html['filter_select_separator']	=	'';
			$this->sidebar							=	str_replace( '<li>', '<li class="item">', $this->sidebar );
		} else {
			$this->js	=	array( 'filter'=>'jQuery(document).ready(function($) { $("#sidebar div.sidebar-nav").append("<hr />"); $("div.filter-select").appendTo("#sidebar div.sidebar-nav").removeClass("hidden-important");'
											.'var w = $("div.sidebar-nav").width()-28; $("div.filter-select,div.sidebar-nav div.chzn-container").css("width",w+"px"); $("div.sidebar-nav div.chzn-drop").css("width",(w)+"px");  $("div.sidebar-nav div.chzn-search > input").css("width",(w-10)+"px"); });'
							);
		}
	}
	
	// prepareToolbar
	protected function prepareToolbar()
	{
		Helper_Admin::addToolbar( $this->vName, $this->vTitle );
	}
}
?>
