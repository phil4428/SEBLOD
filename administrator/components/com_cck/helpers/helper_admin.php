<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: helper_admin.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

require_once JPATH_ADMINISTRATOR.'/components/'.CCK_COM.'/helpers/common/admin.php';

// Helper
class Helper_Admin extends CommonHelper_Admin
{
	// addInsidebox
	public static function addInsidebox( $isNew )
	{
		$prefix	=	JCck::getConfig_Param( 'development_prefix', '' );
		
		return ( $isNew && $prefix ) ? '<span class="insidebox">'.$prefix.'</span>' : '';
	}
	
	// addSubmenu
	public static function addSubmenu( $option, $vName )
	{
		$addons		=	array();
		$items		=	array();
		$uix		=	JCck::getUIX();
		$vName2		=	JFactory::getApplication()->input->get( 'filter_e_type', '' );
		$folder		=	JText::_( 'COM_CCK_'._C0_TEXT.'S' );
		
		if ( $uix == 'compact' ) {
			$items	=	array( array( 'name'=>$folder, 'link'=>_C0_LINK, 'active'=>( $vName == _C0_NAME ) ),
							   array( 'val'=>'2', 'pre'=>'', 'key'=>'COM_CCK_' ) );
		} else {
			$items	=	array( array( 'name'=>$folder, 'link'=>_C0_LINK, 'active'=>( $vName == _C0_NAME ) ),
							   array( 'val'=>'2', 'pre'=>'', 'key'=>'COM_CCK_', 'active'=>( $vName == _C2_NAME || ( $vName == _C6_NAME && $vName2 == 'type' ) ) ),
							   array( 'val'=>'3', 'pre'=>'', 'key'=>'' ),
							   array( 'val'=>'4', 'pre'=>'', 'key'=>'COM_CCK_', 'active'=>( $vName == _C4_NAME || ( $vName == _C6_NAME && $vName2 == 'search' ) ) ),
							   array( 'val'=>'1', 'pre'=>'', 'key'=>'', 'active'=>( $vName == _C1_NAME || $vName == _C7_NAME ) ),
							   array( 'val'=>'5', 'pre'=>'', 'key'=>'', 'active'=>( $vName == _C5_NAME ) )
							);
		}
		if ( $vName == 'cck' ) {
			$addons	=	JCckDatabase::loadObjectList( 'SELECT a.title, a.link, b.element FROM #__menu AS a LEFT JOIN #__extensions AS b ON b.extension_id = a.component_id'
													. ' WHERE a.link LIKE "index.php?option=com_cck\_%" ORDER BY a.title ASC' );
		}
		
		self::addSubmenuEntries( $option, $vName, $items, $addons );
	}
	
	// getIcon
	public static function getIcon( $name )
	{
		$icons	=	array(
						'addon'=>'cck-addon',
						'community'=>'cck-community',
						'field'=>'cck-plugin',
						'folder'=>'cck-application',
						'marketplace'=>'cck-products',
						'plugin'=>'cck-plugin',
						'resource'=>'cck-resources',
						'search'=>'cck-search',
						'seblod'=>'cck-seblod',
						'service'=>'cck-services',
						'session'=>'archive',
						'site'=>'cck-multisite',
						'template'=>'cck-template',
						'type'=>'cck-form',
						'variation'=>'cck-variation',
						'version'=>'archive'
					);

		return ( isset( $icons[$name] ) ) ? $icons[$name] : '';
	}


	// addToolbar
	public static function addToolbar( $vName, $vTitle, $folderId = 0 )
	{
		$bar		=	JToolBar::getInstance( 'toolbar' );
		$canDo		=	self::getActions( $folderId );
		$data_bs	=   JCck::on( '4.0' ) ? 'data-bs-' : 'data-';
		$uix		=	JCck::getUIX();
		
		require_once JPATH_COMPONENT.'/helpers/toolbar/separator.php';
		
		if ( $vTitle != '' ) {
			JToolBarHelper::title( JText::_( $vTitle.'_MANAGER' ), self::getIcon( $vName ) );
		}
		if ( $canDo->get( 'core.create' ) ) {
			if ( $vName == 'type' || $vName == 'search' || $vName == 'site' ) {
				$hasModal	=	true;
				$label	=	JText::_( 'JTOOLBAR_NEW' );
				$html	=	'<button '.$data_bs.'toggle="modal" '.$data_bs.'target="#collapseModal2" class="btn btn-small btn-success">'
						.	'<span class="icon-new" title="'.$label.'"></span>&nbsp;'.$label.'</button>';

				if ( JCck::on( '4.0' ) ) {
					$html	=	'<joomla-toolbar-button>'.$html.'</joomla-toolbar-button>';
				}
				$bar->appendButton( 'Custom', $html, 'new' );
			} else {
				JToolBarHelper::custom( $vName.'.add', 'new', 'new', 'JTOOLBAR_NEW', false );
			}
		}
		if ( JCck::on( '4.0' ) && ( $canDo->get( 'core.edit' ) || $canDo->get( 'core.edit.state' ) || $canDo->get( 'core.delete' ) ) ) {
			$dropdown	=	$bar->dropdownButton( 'status-group' )
								->text( 'JTOOLBAR_CHANGE_STATUS' )
								->toggleSplit( false )
								->icon( 'icon-ellipsis-h' )
								->buttonClass( 'btn btn-action' )
								->listCheck( true );

			$childBar	=	$dropdown->getChildToolbar();
		}
		if ( $canDo->get( 'core.edit' ) ) {
			if ( !JCck::on( 4.0 ) ) {
				JToolBarHelper::custom( $vName.'.edit', 'edit', 'edit', 'JTOOLBAR_EDIT', true );
			}
		}		
		if ( $canDo->get( 'core.edit.state' ) || $canDo->get( 'core.delete' ) ) {
			if ( $canDo->get( 'core.edit.state' ) ) {
				if ( JCck::on( '4.0' ) ) {
					$childBar->standardButton( 'publish' )->text( 'COM_CCK_TURN_ON' )->task( $vName.'s'.'.publish' )->listCheck( true );
					$childBar->standardButton( 'unpublish' )->text( 'COM_CCK_TURN_OFF' )->task( $vName.'s'.'.unpublish' )->listCheck( true );
				} else {
					JToolBarHelper::custom( $vName.'s'.'.publish', 'publish', 'publish', 'COM_CCK_TURN_ON', true );
					JToolBarHelper::custom( $vName.'s'.'.unpublish', 'unpublish', 'unpublish', 'COM_CCK_TURN_OFF', true );
				}
			}
			if ( $canDo->get( 'core.delete' ) ) {
				if ( JCck::on( '4.0' ) ) {
					$childBar->standardButton( 'delete' )->text( 'JTOOLBAR_DELETE' )->task( $vName.'s'.'.delete' )->listCheck( true )->buttonClass( 'btn-danger' );
				} else {
					JToolBarHelper::custom( $vName.'s'.'.delete', 'delete', 'delete', 'JTOOLBAR_DELETE', true );
				}
			}
			if ( $canDo->get( 'core.edit.state' ) ) {
				if ( JCck::on( '4.0' ) ) {
					$childBar->standardButton( 'checkin' )->text( 'JTOOLBAR_CHECKIN' )->task( $vName.'s'.'.checkin' )->listCheck( true );
				} else {
					JToolBarHelper::custom( $vName.'s'.'.checkin', 'checkin', 'checkin', 'JTOOLBAR_CHECKIN', true );
				}
			}
			if ( $vName == 'type' || $vName == 'search' ) {
				if ( JCck::on( '4.0' ) ) {
					$childBar->standardButton( 'archive' )->text( 'JTOOLBAR_ARCHIVE' )->task( $vName.'s'.'.version' )->listCheck( true );
				} else {
					JToolBarHelper::custom( $vName.'s'.'.version', 'unarchive', 'archives', 'JTOOLBAR_ARCHIVE', true );
				}
			}
		}
		if ( $vName != 'site' && $vName != 'folder' /*&& $canDo->get('core.edit' )*/ ) {
			if ( ( ( $vName == 'type' || $vName == 'search' ) && ( $canDo->get('core.create' ) || $canDo->get('core.edit' ) ) )
				|| $canDo->get('core.edit' ) ) {
				$hasModal	=	true;
				$label	=	JText::_( 'JTOOLBAR_BATCH' );
				$html	=	'<button '.$data_bs.'toggle="modal" '.$data_bs.'target="#collapseModal" class="btn btn-small">'
						.	'<span class="icon-checkbox-partial" title="'.$label.'"></span> '.$label.'</button>';

				if ( JCck::on( '4.0' ) ) {
					$html	=	'<joomla-toolbar-button list-selection>'.$html.'</joomla-toolbar-button>';
				}
				
				$bar->appendButton( 'Custom', $html, 'batch' );
			}
		}
		if ( $vName == 'folder' ) {
			if ( !JCck::is( '5' ) ) {
				JToolBarHelper::custom( 'folders.clear', 'refresh', 'refresh', JText::_( 'COM_CCK_CLEAR_ACL' ), true );
			}
			JToolBarHelper::custom( 'folders.rebuild', 'refresh', 'refresh', JText::_( 'COM_CCK_REBUILD' ), false );

			$hasModal	=	true;
			$label	=	JText::_( 'COM_CCK_APP_FOLDER_EXPORT_OPTIONS' );
			$html	=	'<button '.$data_bs.'toggle="modal" '.$data_bs.'target="#collapseModal" class="btn btn-small">'
					.	'<span class="icon-checkbox-partial" title="'.$label.'"></span> '.$label.'</button>';

			if ( JCck::on( '4.0' ) ) {
				$html	=	'<joomla-toolbar-button list-selection>'.$html.'</joomla-toolbar-button>';
			}
			$bar->appendButton( 'Custom', $html, 'batch' );
		} elseif ( $vName == 'site' ) {
			// JToolBarHelper::custom( 'sites.clear', 'refresh', 'refresh', JText::_( 'COM_CCK_CLEAR_VISITS' ), true );
		} else {
			require_once JPATH_ADMINISTRATOR.'/components/com_cck/helpers/toolbar/link.php';
			if ( $vName == 'type' || $vName == 'search' ) {
				if ( JCck::on( '4.0' ) ) {
					$bar->linkButton( 'versions' )->text( 'COM_CCK_VERSIONS' )->url( JRoute::_( 'index.php?option=com_cck&view=versions&filter_e_type='.$vName ) )->icon( 'icon-archive' )->buttonClass( 'btn' );
				} else {
					$bar->appendButton( 'CckLink', 'archive', 'COM_CCK_VERSIONS', JRoute::_( 'index.php?option=com_cck&view=versions&filter_e_type='.$vName ), '_self' );					
				}
			} elseif ( $vName == 'template' ) {
				if ( JCck::on( '4.0' ) ) {
					$bar->linkButton( 'variations' )->text( JText::_( _C7_TEXT.'S' ) )->url( JRoute::_( 'index.php?option=com_cck&view=variations' ) )->icon( 'icon-unarchive' )->buttonClass( 'btn' );
				} else {
					$bar->appendButton( 'CckLink', 'cck-variation', JText::_( _C7_TEXT.'S' ), JRoute::_( 'index.php?option=com_cck&view=variations' ), '_self' );	
				}			
			}
		}

		if ( $hasModal ) {
			if ( JCck::on( '4.0' ) ) {
				JHtml::_( 'bootstrap.renderModal', 'collapseModal' );
			} else {
				JHtml::_( 'bootstrap.modal', 'collapseModal' );
			}
		}
	}
	
	// addToolbarEdit
	public static function addToolbarEdit( $vName, $vTitle, $vMore = '', $params = array() )
	{
		$bar		=	JToolBar::getInstance( 'toolbar' );
		$user		=	JFactory::getUser();
		$checkedOut	= 	! ( $vMore['checked_out'] == 0 || $vMore['checked_out'] == $user->id );
		$canDo		=	self::getActions( $vMore['folder'] );
		$vSubtitle	=	'';
		
		JFactory::getApplication()->input->set( 'hidemainmenu', true );
		require_once JPATH_COMPONENT.'/helpers/toolbar/separator.php';
		
		if ( ( $vName == 'type' || $vName == 'search' ) ) {
			$vSubtitle	=	' <span class="subtitle">[ '.JText::_( 'COM_CCK_SEBLOD_WORKSHOP' ).' ]</span>';
			require_once JPATH_COMPONENT.'/helpers/toolbar/link.php';
		}
		if ( $vMore['isNew'] )  {
			JToolBarHelper::title( JText::_( $vTitle ).': <small><small>[ '.JText::_( 'COM_CCK_ADD' ).' ]'.$vSubtitle.'</small></small>', self::getIcon( $vName ) );
			
			if ( $canDo->get('core.create') ) {
				JToolBarHelper::custom( $vName.'.apply', 'apply', 'apply', 'JTOOLBAR_APPLY', false );
				JToolBarHelper::custom( $vName.'.save', 'save', 'save', 'JTOOLBAR_SAVE', false );
				JToolBarHelper::custom( $vName.'.save2new', 'save-new', 'save-new', 'JTOOLBAR_SAVE_AND_NEW', false );
			}
			JToolBarHelper::custom( $vName.'.cancel', 'cancel', 'cancel', 'JTOOLBAR_CANCEL', false );
		} else {
			JToolBarHelper::title( JText::_( $vTitle ).': <small><small>[ '.JText::_( 'JTOOLBAR_EDIT' ).' ]'.$vSubtitle.'</small></small>', self::getIcon( $vName ) );
			
			if ( !$checkedOut ) {
				if ( $canDo->get('core.edit') ) {
					JToolBarHelper::custom( $vName.'.apply', 'apply', 'apply', 'JTOOLBAR_APPLY', false );
					JToolBarHelper::custom( $vName.'.save', 'save', 'save', 'JTOOLBAR_SAVE', false );
					if ( $canDo->get('core.create' ) ) {
						JToolBarHelper::custom( $vName.'.save2new', 'save-new', 'save-new', 'JTOOLBAR_SAVE_AND_NEW', false );
					}
				}
			}
			if ( ! $vMore['isNew'] && $canDo->get( 'core.create' ) && $vName == 'folder' ) {
				JToolBarHelper::custom( $vName.'.save2copy', 'save-copy', 'save-copy', 'JTOOLBAR_SAVE_AS_COPY', false );
				//if ( @$params['rename'] ) { /* TODO#SEBLOD: */
				//	JToolBarHelper::custom( $vName.'.save2copy', 'save-copy', 'save-copy', 'JTOOLBAR_SAVE_AS_COPY', false );
				//}
			}
			JToolBarHelper::custom( $vName.'.cancel', 'cancel', 'cancel', 'JTOOLBAR_CLOSE', false );
		}
	}
	
	// addToolbarDelete
	public static function addToolbarDelete( $vName, $vTitle )
	{
		JFactory::getApplication()->input->set( 'hidemainmenu', true );
		
		JToolBarHelper::title( JText::_( $vTitle ).': <small><small>[ '.JText::_( 'Delete' ).' ]</small></small>', $vName.'s.png' );
		JToolBarHelper::custom( $vName.'cancel', 'cancel', 'cancel', 'JTOOLBAR_CLOSE', false );
	}
	
	// getActions
	public static function getActions( $folderId = 0 )
	{
		$user	=	JFactory::getUser();
		$result	=	new JObject;
		
		if ( empty( $folderId ) ) {
			$assetName	=	'com_'.CCK_NAME;
		} else {
			$assetName	=	'com_'.CCK_NAME.'.folder.'.(int)$folderId;
		}
		
		$actions	=	array( 'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete' );
		foreach ( $actions as $action ) {
			$result->set( $action, $user->authorise( $action, $assetName ) );
		}
		
		return $result;
	}

	// getDefaultTemplate
	public static function getDefaultTemplate()
	{
		$name		=	JCckDatabaseCache::loadResult( 'SELECT name FROM #__cck_core_templates WHERE featured = 1 ORDER BY id' );
		
		if ( !$name) {
			$name	=	'seb_minima';
		}

		return $name;
	}
}
?>