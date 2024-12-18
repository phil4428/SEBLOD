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

if ( !$user->authorise( 'core.create', 'com_cck' ) ) {
    return;
}
?>
<div class="<?php echo $this->css['batch']; ?>" id="collapseModal2"><div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header">
        <?php Helper_Display::quickModalTitle( JText::_( 'JTOOLBAR_NEW' ).' '.JText::_( 'COM_CCK_SITE' ).' ('.JText::_( 'COM_CCK_MULTISITES' ).')' ); ?>
    </div>
    <?php if ( $user->authorise( 'core.create', 'com_cck' ) ) { ?>
    <div class="modal-body">
        <div class="control-group">
            <div class="control-label">
                <label><?php echo JText::_( 'COM_CCK_SELECT_WHICH_SITE_TYPE' ); ?></label>
            </div>
            <div class="sly-wrapper">
                <div class="sly">
                    <ul>
                        <li data-values="7"><?php echo JText::_( 'COM_CCK_BASIC' ); ?>
                        	<img src="components/com_cck/assets/images/site_picker_basic.png" alt="<?php echo JText::_( 'COM_CCK_BASIC' ); ?>" width="175" height="115" />
                        </li>
                        <li data-values="2,7"><?php echo JText::_( 'COM_CCK_STANDARD' ); ?>
                        	<img src="components/com_cck/assets/images/site_picker_standard.png" alt="<?php echo JText::_( 'COM_CCK_STANDARD' ); ?>" width="175" height="115" />
                        </li>
                        <li data-values="2,3,6,7"><?php echo JText::_( 'COM_CCK_ADVANCED' ); ?>
                        	<img src="components/com_cck/assets/images/site_picker_advanced.png" alt="<?php echo JText::_( 'COM_CCK_ADVANCED' ); ?>" width="175" height="115" />
                        </li>
                    </ul>
                </div>
            </div>
            <input type="hidden" id="site_grp" name="site_grp" value="2,7" />
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" onclick="" <?php echo $this->html['attr_modal_close']; ?>><?php echo JText::_( 'JCANCEL' ); ?></button>
        <button class="btn btn-primary" type="button" onclick="JCck.Dev.addNew();"><?php echo JText::_( 'COM_CCK_CREATE' ); ?></button>
    </div>
    <?php } ?>
</div></div></div>