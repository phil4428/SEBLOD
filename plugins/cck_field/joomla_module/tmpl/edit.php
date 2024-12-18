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

JCckDev::forceStorage();

/*
TODO: improve
JCckDev::renderForm( 'core_bool', $this->item->bool7, $config, array( 'label'=>'Show Form', 'options'=>'Hide=0||Show=optgroup||Yes No=1||Modules=2' ) );
JCckDev::renderForm( 'core_options', JCckDev::fromSTRING( $this->item->options ), $config, array( 'label'=>'Modules' ) );
*/

// Set
$displayData    =   array(
                        'config'=>$config,
                        'form'=>array(
                            array(
                                'fields'=>array(
                                            JCckDev::renderForm( 'core_label', $this->item->label, $config ),          
                                            JCckDev::renderForm( 'core_bool', $this->item->bool, $config, array( 'label'=>'MODE', 'options'=>'NameTitle=1||Position=0' ) ),
                                            JCckDev::renderForm( 'core_defaultvalue', $this->item->defaultvalue, $config, array( 'label'=>'NAMETITLE_OR_POSITION' ) ),
                                            JCckDev::renderForm( 'core_bool2', $this->item->bool2, $config, array( 'label'=>'Prepare Content', 'defaultvalue'=>'0' ) ),
                                            JCckDev::renderForm( 'core_module_style', $this->item->style, $config )                                            
                                ),
                            ),
                            array(
                                'fields'=>array(
                                    JCckDev::getForm( 'core_storage', $this->item->storage, $config )
                                ),
                                'mode'=>'storage'
                            )
                        ),
                        'help'=>array(),
                        'html'=>'',
                        'item'=>$this->item,
                        'script'=>''
                    );

echo JCckDev::renderLayoutFile( 'cck'.JCck::v().'.construction.cck_field.edit', $displayData );
?>