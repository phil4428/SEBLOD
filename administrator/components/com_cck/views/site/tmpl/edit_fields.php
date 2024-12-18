<?php
defined( '_JEXEC' ) or die;

if ( count( $this->item->fields ) ) { ?>
<ul class="adminformlist adminformlist-2cols">
    <?php
    $fieldnames =   array();
    foreach ( $this->item->fields as $fieldname ) {
        if ( empty( $fieldname ) ) {
            continue;
        }
        $field  =   JCckDev::get( $fieldname, '', $config );
        if ( !is_object( $field ) ) {
            continue;
        }
        if ( isset( $fieldnames[$field->name] ) ) {
            continue;
        }

        $id     =   str_replace( array( 'json[options][', ']' ), '', $field->storage_field );
        $value  =   ( isset( $this->item->options[$id] ) ) ? $this->item->options[$id] : '';
        $class  =   'inputbox text'. ( $field->css ? ' '.$field->css : '' );
        $maxlen =   ( $field->maxlength > 0 ) ? ' maxlength="'.$field->maxlength.'"' : '';
        $attr   =   'class="'.$class.'" size="'.$field->size.'"'.$maxlen . ( $field->attributes ? ' '.$field->attributes : '' );
        $picker =   '';
        $type   =   ( $field->type == 'password' ) ? $field->type : 'text';
        if ( JCck::callFunc( 'plgCCK_Field'.$field->type, 'isFriendly' ) ) {
            $picker =   '<span id="storage_field_pick_'.$field->name.'" name="'.$field->name.'" class="value-picker">&laquo;</span>';
        }
        $fieldnames[$field->name]   =   '';
        $hasOpts                    =   true;
        echo '<li><label>'.$field->label.'</label>'
         .   '<input type="'.$type.'" id="json_options_'.$field->name.'" name="'.$field->storage_field.'" value="'.$value.'" '.$attr.'>'
         .   $picker
         .   '</li>';
    }
    ?>
</ul>
<?php }
if ( !$hasOpts ) { ?>
    <p class="legend-desc"><?php echo JText::_( 'COM_CCK_SITE_OPTIONS_DESC' ); ?></p>
<?php } ?>