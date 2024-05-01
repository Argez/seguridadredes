<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Field: Select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if( ! class_exists( 'Codevz_Field_select' ) ) {
  class Codevz_Field_select extends Codevz_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '' ) {
      parent::__construct( $field, $value, $unique, $where );
    }

    public function output() {

      echo $this->element_before();

      if( isset( $this->field['options'] ) ) {

        $options    = $this->field['options'];
        $class      = $this->element_class();
        $options    = ( is_array( $options ) ) ? $options : array_filter( $this->element_data( $options ) );
        $extra_name = ( isset( $this->field['attributes']['multiple'] ) ) ? '[]' : '';
        $chosen_rtl = ( is_rtl() && strpos( $class, 'chosen' ) ) ? 'chosen-rtl' : '';
        $saved_value= $this->element_value();

        // Codevz.
        if ( isset( $this->field['edit_link'] ) ) {
          echo '<div class="codevz-select-page">';
        }

        echo '<select name="'. $this->element_name( $extra_name ) .'"'. $this->element_class( $chosen_rtl ) . $this->element_attributes() .'>';

        echo ( isset( $this->field['default_option'] ) ) ? '<option value="">'.$this->field['default_option'].'</option>' : '';

        if( !empty( $options ) ){
          foreach ( $options as $key => $value ) {
            echo '<option value="'. $key .'" '. $this->checked( $saved_value, $key, 'selected' ) .'>'. $value .'</option>';
          }
        }

        echo '</select>';

        // Codevz.
        if ( isset( $this->field['edit_link'] ) ) {

          $admin = get_admin_url();

          if ( $this->field['edit_link'] !== true ) {

            echo '<a href="' . esc_url( $this->field['edit_link'] ) . '" target="_blank" style="display:block"><i class="far fa-pen-to-square"></i></a>';

          } else {

            echo '<a href="' . esc_url( $admin . '?codevz_edit_content=' . $saved_value ) . '" data-href="' . esc_url( $admin ) . '" title="' . esc_html__( 'Edit', 'codevz' ) . '" target="_blank" style="display: ' . ( $saved_value ? 'block' : 'none' ) . '"><i class="far fa-pen-to-square"></i></a>';

          }

          echo '</div>';

        }

      }

      echo $this->element_after();

    }

  }
}
