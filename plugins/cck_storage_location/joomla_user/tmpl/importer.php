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
?>

<div class="seblod cck-padding-top-0 cck-padding-bottom-0">
	<?php echo JCckDev::renderLegend( JText::_( 'COM_CCK_DEFAULT_VALUES' ) ); ?>
    <div class="form-grid">
		<?php
		echo JCckDev::renderForm( 'core_joomla_user_groups', '', $config, array( 'label'=>'User Groups', 'storage_field'=>'values[groups]' ) );
		?>
	<div class="clr"></div>
	<?php echo JCckDev::renderLegend( JText::_( 'COM_CCK_SETTINGS' ) ); ?>
	<div class="form-grid">
		<?php
		echo JCckDev::renderForm( 'core_bool', 0, $config, array( 'label'=>'Password', 'options'=>'Password Clear=0||MD5=1', 'storage_field'=>'options[force_password]' ) );
		?>
	</div>
	<div class="clr"></div>
	<?php echo JCckDev::renderLegend( JText::_( 'COM_CCK_UPDATE' ) ); ?>
	<div class="form-grid">
		<?php
		echo JCckDev::renderForm( 'core_dev_select', '', $config, array( 'label'=>'Update By Key', 'defaultvalue'=>'email', 'selectlabel'=>'',
								  'options'=>'ID=id||Email=email||Username=username||', 'storage_field'=>'options[key]' ) );
		echo JCckDev::renderForm( 'core_dev_select', '', $config, array( 'label'=>'Update By Diff', 'selectlabel'=>'None',
								  'options'=>'Update By Diff Desc=optgroup||Block=block', 'storage_field'=>'options[diff]' ) );
        ?>
	</div>
</div>