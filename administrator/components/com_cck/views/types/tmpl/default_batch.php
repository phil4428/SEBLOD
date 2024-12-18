<?php
/**
* @version 			SEBLOD 3.x Core ~ $Id: default_batch.php sebastienheraud $
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;
?>
<div class="<?php echo $this->css['batch']; ?>" id="collapseModal"><div class="modal-dialog modal-lg"><div class="modal-content">
	<div class="modal-header">
		<?php Helper_Display::quickModalTitle( JText::_( 'COM_CCK_BATCH_PROCESS' ) ); ?>
	</div>
	<?php if ( $user->authorise( 'core.edit', 'com_cck' ) ) { ?>
	<div class="modal-body">
		<p><?php echo JText::_( 'COM_CCK_BATCH_PROCESS_'.$this->vName ); ?></p>
		<div class="control-group">
			<div class="control-label">
				<label for="batch_folder"><?php echo JText::_( 'COM_CCK_SET_APP_FOLDER' ); ?></label>
			</div>
			<div class="controls">
				<?php echo JCckDev::getFormFromHelper( array( 'component'=>'com_cck', 'function'=>'getFolder', 'name'=>'core_folder' ), '', $config, array( 'label'=>_C0_TEXT, 'storage_field'=>'batch_folder', 'css'=>'no-chosen' ) ); ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-secondary" type="button" onclick="" <?php echo $this->html['attr_modal_close']; ?>><?php echo JText::_( 'JCANCEL' ); ?></button>
		<button class="btn btn-primary" type="submit" onclick="Joomla.submitbutton('batchFolder');"><?php echo JText::_( 'COM_CCK_GO' ); ?></button>
	</div>
	<?php } ?>
	<?php if ( $user->authorise( 'core.create', 'com_cck' ) ) { ?>
	<div class="modal-body">
		<p><?php echo JText::_( 'COM_CCK_BATCH_PROCESS_'.$this->vName.'_2' ); ?></p>
		<div class="control-group">
			<div class="control-label">
				<label for="duplicate_title"><?php echo JText::_( 'COM_CCK_CHOOSE_A_TITLE' ); ?></label>
			</div>
			<div class="controls">
				<?php echo JCckDev::getForm( $cck['core_dev_text'], '', $config, array( 'label'=>'Title', 'storage_field'=>'duplicate_title' ) ); ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-secondary" type="button" onclick="" <?php echo $this->html['attr_modal_close']; ?>><?php echo JText::_( 'JCANCEL' ); ?></button>
		<button class="btn btn-primary" type="submit" onclick="Joomla.submitbutton('types.duplicate');"><?php echo JText::_( 'COM_CCK_GO' ); ?></button>
	</div>
	<?php } ?>
</div></div></div>
<?php if ( 1 == 1 ) {
	$items  =   JCckDatabase::loadObjectList( 'SELECT id, title, name, app, icon_path as icon FROM #__cck_core_folders WHERE featured = 1 ORDER BY lft' );
?>
<div class="<?php echo $this->css['batch']; ?>" id="collapseModal2"><div class="modal-dialog modal-lg"><div class="modal-content">
	<div class="modal-header">
		<?php Helper_Display::quickModalTitle( JText::_( 'JTOOLBAR_NEW' ).' '.JText::_( 'COM_CCK_'._C2_TEXT ) ); ?>
	</div>
	<?php if ( $user->authorise( 'core.create', 'com_cck' ) ) { ?>
	<div class="modal-body">
		<p><?php echo JText::_( 'COM_CCK_SELECT_WHICH_OBJECT_TYPE' ); ?></p>
		<?php if ( JCck::on( '4.0' ) ) { ?>
			<div class="list-group">
				<?php
				if ( count( $items ) ) {
					foreach ( $items as $item ) {
						?>
						<a class="choose_type list-group-item list-group-item-action" href="javascript:void(0);" onclick="JCck.Dev.addNew('<?php echo $item->id; ?>');">
								<div class="pe-2"><?php echo $item->title; ?></div>
								<!-- <small class="text-muted">...</small> -->
						</a>
					<?php }
				}
				?>
			</div>
		<?php } else { ?>
			<div class="cpanel row-fluid">
				<?php
				if ( count( $items ) ) {
					foreach ( $items as $item ) {
						$image  =   ( $item->icon ) ? $item->icon : 'administrator/components/com_cck/assets/images/48/icon-48-form.png';
						$text   =   $item->title;
					?>
					<div class="wrapper-icon span3">
						<div class="icon">
							<a href="javascript:void(0);" onclick="JCck.Dev.addNew('<?php echo $item->id; ?>');">
								<?php
								$img    =   JHtml::_( 'image', $image, htmlspecialchars( str_replace( '<br />', ' ', $text ) ) );

								echo str_replace( '<img ', '<img width="32" height="32" ', $img );
								?>
								<span><?php echo $text; ?></span>
							</a>
						</div>
					</div>
				<?php } } ?>
				<div class="cpanel">
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="modal-footer">
		<button class="btn btn-secondary" type="button" onclick="" <?php echo $this->html['attr_modal_close']; ?>><?php echo JText::_( 'JCANCEL' ); ?></button>        
		<button class="btn btn-secondary" type="button" onclick="JCck.Dev.addNew();"><?php echo JText::_( 'COM_CCK_CREATE_BLANK' ); ?></button>
	</div>
	<?php } ?>
</div></div></div>
<?php } ?>