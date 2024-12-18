<?php
/**
* @version 			SEBLOD 3.x Core
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// Plugin
class plgCCK_FieldJform_Tag extends JCckPluginField
{
	protected static $type				=	'jform_tag';
	protected static $type2				=	'tag';

	protected static $friendly			=	1;
	protected static $path;
	protected static $prepared_input	=	1;

	// -------- -------- -------- -------- -------- -------- -------- -------- // Construct

	// onCCK_FieldConstruct
	public function onCCK_FieldConstruct( $type, &$data = array() )
	{
		if ( self::$type != $type ) {
			return;
		}
		parent::g_onCCK_FieldConstruct( $data );
	}

	// -------- -------- -------- -------- -------- -------- -------- -------- // Prepare

	// onCCK_FieldPrepareContent
	public function onCCK_FieldPrepareContent( &$field, $value = '', &$config = array() )
	{
		if ( self::$type != $field->type ) {
			return;
		}
		parent::g_onCCK_FieldPrepareContent( $field, $config );
		
		JLoader::register( 'TagsHelperRoute', JPATH_SITE . '/components/com_tags/helpers/route.php' );

		$html	=	'';

		if ( $value || ( $config['client'] == 'list' || $config['client'] == 'item'  ) ) {
			$location		=	( isset( $config['location'] ) && $config['location'] ) ? $config['location'] : 'joomla_article';
			$properties		=	array( 'context', 'context2' );
			$properties		=	JCck::callFunc( 'plgCCK_Storage_Location'.$location, 'getStaticProperties', $properties );
			
			if ( isset( $properties['context2'] ) && $properties['context2'] != '' ) {
				$properties['context']	=	$properties['context2'];
			}
			if ( is_object( $value ) && isset( $value->tags ) ) {
				$value		=	$value->tags;
			}
			$tags			=	new JHelperTags;
			$tags->getItemTags( $properties['context'], $config['pk'] );
			$tagLayout		=	new JLayoutFile( 'joomla.content.tags' );
			$html			=	$tagLayout->render( $tags->itemTags );
		}

		// Set
		$field->value	=	$value;
		$field->html	=	$html;
	}

	// onCCK_FieldPrepareExport
	public function onCCK_FieldPrepareExport( &$field, $value = '', &$config = array() )
	{
		if ( static::$type != $field->type ) {
			return;
		}

		$field->output	=	'';

		if ( is_object( $value ) ) {
			$tags			=	explode( ',', $value->tags );
			$tags			=	$value->getTagNames( $tags );
			$field->output	=	implode( ',', $tags );
		}
	}

	// onCCK_FieldPrepareForm
	public function onCCK_FieldPrepareForm( &$field, $value = '', &$config = array(), $inherit = array(), $return = false )
	{
		if ( self::$type != $field->type ) {
			return;
		}
		self::$path	=	parent::g_getPath( self::$type.'/' );
		parent::g_onCCK_FieldPrepareForm( $field, $config );

		// Init
		if ( count( $inherit ) ) {
			$id		=	( isset( $inherit['id'] ) && $inherit['id'] != '' ) ? $inherit['id'] : $field->name;
			$name	=	( isset( $inherit['name'] ) && $inherit['name'] != '' ) ? $inherit['name'] : $field->name;
		} else {
			$id		=	$field->name;
			$name	=	$field->name;
		}
		$value		=	( $value != '' ) ? $value : $field->defaultvalue;
		$value		=	( $value != ' ' ) ? $value : '';

		// Validate
		$validate	=	'';
		if ( $config['doValidation'] > 1 ) {
			plgCCK_Field_ValidationRequired::onCCK_Field_ValidationPrepareForm( $field, $id, $config );
			$validate	=	( count( $field->validate ) ) ? ' validate['.implode( ',', $field->validate ).']' : '';

			if ( $field->required || $field->validation ) {
				$config['validation_options']['prettySelect']	=	'1';
				$config['validation_options']['useSuffix']		=	'_chzn';
			}
		}

		// Prepare
		if ( parent::g_isStaticVariation( $field, $field->variation, true ) ) {
			$form			=	'';
			$field->text	=	'';
			parent::g_getDisplayVariation( $field, $field->variation, $value, $field->text, $form, $id, $name, '<input', '', '', $config );
		} else {
			JHtml::_( 'formbehavior.chosen', 'select.tag' );

			$options2	=	JCckDev::fromJSON( $field->options2 );
			$class		=	'inputbox tag'.$validate . ( $field->css ? ' '.$field->css : '' );
			$mode		=	( isset( $options2['mode'] ) && $options2['mode'] ) ? 'mode="'.$options2['mode'].'"' : '';
			$custom		=	( isset( $options2['custom'] ) && !$options2['custom'] ) ? 'custom="deny"' : '';
			$multiple	=	( $field->bool3 ) ? 'multiple="true"' : '';
			$parent		=	( isset( $options2['parent'] ) && $options2['parent'] ) ? 'parent="parent"' : '';
			$lang_tag	=	( isset( $options2['language'] ) && $options2['language'] ) ? 'language="'.$options2['language'].'"' : '';

			$opt		=	'';
			$options2	=	JCckDev::fromJSON( $field->options2 );
			if ( trim( $field->selectlabel ) ) {
				if ( $config['doTranslation'] ) {
					$field->selectlabel	=	JText::_( 'COM_CCK_' . str_replace( ' ', '_', trim( $field->selectlabel ) ) );
				}
				$opt	=	'<option value="">'.'- '.$field->selectlabel.' -'.'</option>';
			}

			$xml		=	'
							<form>
								<field
									type="'.self::$type2.'"
									name="'.$name.'"
									id="'.$id.'"
									label="'.htmlspecialchars( $field->label ).'"
									class="'.$class.'"
									'.$mode.'
									'.$parent.'
									'.$custom.'
									'.$multiple.'
									'.$lang_tag.'
								>
								'.$opt.'
								'.( $parent ? '<option value="1">JNONE</option>' : '' ).'
								</field>
							</form>
						';
			$form	=	JForm::getInstance( $id, $xml );
			$form	=	$form->getInput( $name, '', $value );

			$form	=	str_replace( '<select', '<select class="form-select"', $form );
		}

		// Set
		if ( ! $field->variation ) {
			$field->form	=	$form;
			if ( $field->script ) {
				parent::g_addScriptDeclaration( $field->script );
			}
		} else {
			parent::g_getDisplayVariation( $field, $field->variation, $value, $value, $form, $id, $name, '<input', '', '', $config );
		}
		$field->value	=	$value;

		// Return
		if ( $return === true ) {
			return $field;
		}
	}

	// onCCK_FieldPrepareImport
	public function onCCK_FieldPrepareImport( &$field, $value = '', &$config = array() )
	{
		if ( static::$type != $field->type ) {
			return;
		}

		if ( $config['prepare_input'] ) {
			$default_id	=	$config['params']['tags'];

			if ( $value != '' ) {
				$i			=	0;
				$ids		=	array();
				$values		=	explode( ',', $value );
				
				foreach ( $values as $value ) {
					$value		=	trim( $value );

					if ( empty( $value ) ) {
						continue;
					}

					$parent_id	=	$config['params']['unknown_tags'] ? $config['params']['tags_parent'] : $default_id;
					$parts		=	explode( $config['glue'], $value );

					foreach ( $parts as $part ) {
						$part = trim( $part );
						
						$pk	=	(int)JCckDatabaseCache::loadResult( 'SELECT id FROM #__tags WHERE published != -2 AND title = "'.$part.'"' );

						if ( !$pk ) {
							if ( $config['params']['unknown_tags'] ) {
								$parent_id	=	$this->_addNew( $part, ( $parent_id ? $parent_id : $config['params']['tags_parent'] ) );
							} else {
								// Trigger an error?
								$parent_id	=	0;
								break;
							}
						} else {
							$parent_id	=	$pk;
						}
					}

					if ( $parent_id ) {
						$ids[$i++]	=	$parent_id;
					}
				}

				$value	=	implode( ',', $ids );
			}

			if ( !$value ) {
				$value	=	$default_id;
			}
		}

		$field->value	=	$value;
	}

	// onCCK_FieldPrepareSearch
	public function onCCK_FieldPrepareSearch( &$field, $value = '', &$config = array(), $inherit = array(), $return = false )
	{
		if ( self::$type != $field->type ) {
			return;
		}

		// Prepare
		if ( is_array( $value ) ) {
			$value	=	implode( ',', $value );
		}
		$isMultiple	=	( strpos( $value, ',' ) !== false ) ? 1 : 0;

		if ( $value != '' && $field->storage_location != '' ) {
			require_once JPATH_SITE.'/plugins/cck_storage_location/'.$field->storage_location.'/'.$field->storage_location.'.php';
			$properties	=	array( 'context', 'context2', 'key', 'table' );
			$properties	=	JCck::callFunc( 'plgCCK_Storage_Location'.$field->storage_location, 'getStaticProperties', $properties );

			$field->storage_location	=	'free';
			$field->storage_table		=	'#__contentitem_tag_map';
			$field->storage_field		=	'tag_id';
			$field->storage_field2		=	'';

			$join						=	new stdClass;
			$join->table				=	'#__contentitem_tag_map';
			$join->column				=	'content_item_id';
			$join->column2				=	$properties['key'];
			$join->table2				=	$properties['table'];
			$join->and					=	'type_alias = "'.( ( isset( $properties['context2'] ) && $properties['context2'] != '' ) ? $properties['context2'] : $properties['context'] ).'"';

			$config['joins'][$field->stage][]		=	$join;

			if ( $isMultiple ) {
				$config['query_parts']['group'][]	=	't0.id';
			}
		} else {
			$field->storage					=	'none';
			$field->storage_location		=	'';
			$field->storage_table			=	'';
			$field->storage_field2			=	'';
		}
		self::onCCK_FieldPrepareForm( $field, $value, $config, $inherit, $return );

		// Return
		if ( $return === true ) {
			return $field;
		}
	}

	// onCCK_FieldPrepareStore
	public function onCCK_FieldPrepareStore( &$field, $value = '', &$config = array(), $inherit = array(), $return = false )
	{
		if ( self::$type != $field->type ) {
			return;
		}

		// Init
		if ( count( $inherit ) ) {
			$name	=	( isset( $inherit['name'] ) && $inherit['name'] != '' ) ? $inherit['name'] : $field->name;
		} else {
			$name	=	$field->name;
		}

		// Validate
		parent::g_onCCK_FieldPrepareStore_Validation( $field, $name, $value, $config );

		// Set or Return
		if ( $return === true ) {
			return $value;
		}
		$field->value	=	$value;
		$field->text	=	'';

		$values			=	( is_array( $field->value ) ) ? implode( ',', $field->value ) : $field->value;
		
		if ( $values != '' ) {
			$values		=	explode( ',', $values );
			$existing	=	array();
			$new		=	array();
			$texts		=	'';

			if ( count( $values ) ) {
				foreach ( $values as $k=>$v ) {
					if ( strpos( $v, '#new#' ) !== false ) {
						$new[]		=	substr( $v, 5 );
					} elseif ( is_numeric( $v ) ) {
						$existing[]	=	$v;
					}
				}
			}
			$existing	=	implode( ',', $existing );
			
			if ( $existing != '' ) {
				$texts		=	JCckDatabase::loadColumn( 'SELECT title FROM #__tags WHERE id IN ('.$existing.')' );
			}
			if ( is_array( $texts ) ) {
				$field->text	=	implode( ',', $texts );
			}
			if ( count( $new ) ) {
				$new			=	implode( ',', $new );
				$field->text	.=	( $field->text != '' ) ? ','.$new : $new;
			}
		}
		if ( $field->storage_field != 'tags' ) {
			$field->value	=	( is_array( $field->value ) ) ? implode( ',', $field->value ) : $field->value;
			$value			=	$field->value;
		}

		parent::g_onCCK_FieldPrepareStore( $field, $name, $value, $config );
	}

	// -------- -------- -------- -------- -------- -------- -------- -------- // Render

	// onCCK_FieldRenderContent
	public static function onCCK_FieldRenderContent( $field, &$config = array() )
	{
		return parent::g_onCCK_FieldRenderContent( $field, 'html' );
	}

	// onCCK_FieldRenderForm
	public static function onCCK_FieldRenderForm( $field, &$config = array() )
	{
		return parent::g_onCCK_FieldRenderForm( $field );
	}

	// -------- -------- -------- -------- -------- -------- -------- -------- // Stuff & Script

	// _addNew
	protected static function _addNew( $title, $parent_id )
	{
		$data	=	array(
						'access'=>1,
						'language'=>'*',
						'parent_id'=>(int)$parent_id,
						'published'=>1,
						'title'=>$title
					);

		JLoader::register( 'TagsTableTag', JPATH_ADMINISTRATOR . '/components/com_tags/tables/tag.php' );

		$table	=	JTable::getInstance( 'Tag', 'TagsTable' );

		$table->setLocation( $data['parent_id'], 'last-child' );

		if ( $table->save( $data ) ) {
			$table->rebuildPath( $table->id );

			return $table->id;
		}

		return 0;
	}

	// isFriendly
	public static function isFriendly()
	{
		return self::$friendly;
	}
}
?>
