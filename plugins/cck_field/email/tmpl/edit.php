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

// Init
$options2	=	JCckDev::fromJSON( $this->item->options2 );
$to_admin	=	( is_array( @$options2['to_admin'] ) ) ? implode( ',', $options2['to_admin'] ) : ( ( @$options2['to_admin'] ) ? $options2['to_admin'] : '' );
$visibility	=	'';
 
if ( !JCck::on( '4.0' ) ) {
	$visibility	=	',true,"visibility"';
}

// JS
$js =	'jQuery(document).ready(function($) {
			$("#json_options2_from_param").isVisibleWhen("json_options2_from","1,3"'.$visibility.');
			$("#json_options2_from_name_param").isVisibleWhen("json_options2_from_name","1,3"'.$visibility.');
			$("#json_options2_reply_to_param").isVisibleWhen("json_options2_reply_to","3"'.$visibility.');
			$("#json_options2_reply_to_name_param").isVisibleWhen("json_options2_reply_to_name","3"'.$visibility.');
			$("#json_options2_cc_param").isVisibleWhen("json_options2_cc","1,3"'.$visibility.');
			$("#json_options2_bcc_param").isVisibleWhen("json_options2_bcc","1,3"'.$visibility.');
		});';

// Set
$displayData	=	array(
						'config'=>$config,
						'form'=>array(
							array(
								'fields'=>array(
									JCckDev::renderForm( 'core_label', $this->item->label, $config ),
									JCckDev::renderLayoutFile(
										'cck'.JCck::v().'.form.field', array(
											'label'=>JText::_( 'COM_CCK_SEND_EMAIL' ),
											'html'=>JCckDev::renderLayoutFile( 'cck'.JCck::v().'.construction.grid', array(
												'grid'=>'|50%',
												'html'=>array(
													JCckDev::getForm( 'core_options_send', @$options2['send'], $config ),
													JCckDev::getForm( 'core_options_from_param', @$options2['send_field'], $config, array( 'label'=>'Send Email Field', 'defaultvalue'=>'', 'size'=>'14', 'storage_field'=>'json[options2][send_field]' ) )
												)
											) )
										)
									),
									JCckDev::renderForm( 'core_options_from', @$options2['from'], $config ),
									JCckDev::renderForm( 'core_options_from_param', @$options2['from_param'], $config ),
									JCckDev::renderForm( 'core_options_from', @$options2['from_name'], $config, array( 'label'=>'From Name', 'selectlabel'=>'Use Global', 'options'=>'Name=1||Field=3', 'storage_field'=>'json[options2][from_name]' ) ),
									JCckDev::renderForm( 'core_options_from_param', @$options2['from_name_param'], $config, array( 'label'=>'From Name Field', 'storage_field'=>'json[options2][from_name_param]' ) ),
									JCckDev::renderForm( 'core_options_from', @$options2['reply_to'], $config, array( 'label'=>'Reply To', 'selectlabel'=>'', 'options'=>'None=0||Field=3', 'storage_field'=>'json[options2][reply_to]' ) ),
									JCckDev::renderForm( 'core_options_from_param', @$options2['reply_to_param'], $config, array( 'label'=>'Reply To Field', 'storage_field'=>'json[options2][reply_to_param]' ) ),
									JCckDev::renderForm( 'core_options_from', @$options2['reply_to_name'], $config, array( 'label'=>'Reply To Name', 'selectlabel'=>'', 'options'=>'None=0||Field=3', 'storage_field'=>'json[options2][reply_to_name]' ) ),
									JCckDev::renderForm( 'core_options_from_param', @$options2['reply_to_name_param'], $config, array( 'label'=>'Reply To Name Field', 'storage_field'=>'json[options2][reply_to_name_param]' ) ),
									JCckDev::renderForm( 'core_options_subject', @$options2['subject'], $config ),
									JCckDev::renderForm( 'core_options_to', @$options2['to'], $config ),
									JCckDev::renderForm( 'core_options_message', @$options2['message'], $config ),
									JCckDev::renderForm( 'core_options_to_field', @$options2['to_field'], $config ),
									JCckDev::renderForm( 'core_options_from_param', @$options2['message_field'], $config, array( 'label'=>'Message Field', 'defaultvalue'=>'', 'storage_field'=>'json[options2][message_field]' ) ),
									JCckDev::renderForm( 'core_options_to_admin', $to_admin, $config ),
									JCckDev::renderForm( 'core_options_from_param', @$options2['send_attachment_field'], $config, array( 'label'=>'Send Attachment Field', 'defaultvalue'=>'', 'storage_field'=>'json[options2][send_attachment_field]' ) ),
									JCckDev::renderForm( 'core_options_to', @$options2['attachment_field'], $config, array( 'label'=>'Attachment Field', 'defaultvalue'=>'', 'storage_field'=>'json[options2][attachment_field]' ) ),
									JCckDev::renderForm( 'core_options_from', @$options2['cc'], $config, array( 'label'=>'CC', 'selectlabel'=>'', 'options'=>'None=0||Email=1||Field=3', 'storage_field'=>'json[options2][cc]' ) ),
									JCckDev::renderForm( 'core_options_to', @$options2['cc_param'], $config, array( 'label'=>'CC Email Field', 'storage_field'=>'json[options2][cc_param]' ) ),
									JCckDev::renderForm( 'core_options_from', @$options2['bcc'], $config, array( 'label'=>'BCC', 'selectlabel'=>'', 'options'=>'None=0||Email=1||Field=3', 'storage_field'=>'json[options2][bcc]' ) ),
									JCckDev::renderForm( 'core_options_to', @$options2['bcc_param'], $config, array( 'label'=>'BCC Email Field', 'storage_field'=>'json[options2][bcc_param]' ) ),
									JCckDev::renderForm( 'core_size', $this->item->size, $config ),
									JCckDev::renderForm( 'core_dev_select', @$options2['format'], $config, array( 'label'=>'Format', 'defaultvalue'=>'1', 'selectlabel'=>'', 'options'=>'HTML=1||HTML as Plain Text=2||Plain Text=0', 'storage_field'=>'json[options2][format]' ) )
								)
							),
							array(
								'fields'=>array(
									JCckDev::getForm( 'core_storage', $this->item->storage, $config, array(), array( 'alter_type_value' => 'TEXT' ) )
								),
								'mode'=>'storage'
							)
						),
						'help'=>array( 'field', 'seblod-2-x-email-field' ),
						'html'=>'',
						'item'=>$this->item,
						'script'=>$js
					);

echo JCckDev::renderLayoutFile( 'cck'.JCck::v().'.construction.cck_field.edit', $displayData );
?>
