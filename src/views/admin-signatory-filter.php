<select name="ADMIN_FILTER_FIELD_VALUE">
    <option value=""><?php _e( 'Filter By ', 'wose45436' ); ?></option>
    <?php
    $current_v = isset( $_GET['ADMIN_FILTER_FIELD_VALUE'] ) ? $_GET['ADMIN_FILTER_FIELD_VALUE'] : '';
    foreach ( $values as $label => $value ) {
        printf
        (
            '<option value="%s"%s>%s</option>',
            $value,
            $value == $current_v ? ' selected="selected"' : '',
            $label
        );
    }
    ?>
</select>
<?php
