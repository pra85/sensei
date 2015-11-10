<?php
/**
 * Adds Sensei settings to the permalinks admin settings page.
 *
 * Credits: WooCommerce 2.3.0 class WC_Admin_Permalink_Settings
 *
 * @class       Sensei_Permalink_Settings
 * @author      Automattic
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     1.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sensei_Permalink_Settings Class
 */
class Sensei_Permalink_Settings{

    /**
     * Initialize the settings
     */
    public function settings_init() {

        // Add a section to the permalinks page
        add_settings_section(
            'sensei-lesson-permalink',
            __( 'Sensei Lesson Permalink Options', 'woothemes-sensei' ),
            array( 'Sensei_Permalink_Settings', 'show_settings' ),
            'permalink'
        );

        // Add lesson radio button setting to choose the lesson base
        add_settings_field(
            'sensei_lesson_permalink_base_slug',                                 // id
            __( 'Lesson', 'woothemes-sensei' ),                                 // setting title
            array( 'Sensei_Permalink_Settings', 'lesson_permalink_base_slug_input' ), // display callback
            'permalink',                                                              // settings page
            'optional;'                                                // settings section
        );
    }

    /**
     * Show a slug input box.
     */
    public static function lesson_permalink_base_slug_input( $field ) {
        $permalinks = get_option( 'sensei_permalinks' );
        ?>
        <input name="<?php esc_attr_e( $field['id'] )?>"
               type="radio"
               value="<?php if ( isset( $permalinks['lesson'] ) ) echo esc_attr( $permalinks['lesson'] ); ?>"
               placeholder="<?php echo esc_attr_x('product-category', 'slug', 'sensei') ?>" />

        <?php
    }

    /**
     * Show the lesson section settings.
     */
    public function show_settings() {

        echo wpautop( __( 'The settings below control the permalinks used for lessons. Please note that it will not work if the "Common Settings" above uses the default option.', 'woothemes-sensei' ) );

        $structures = array(
            'default' => '/lesson/',
            'course'  => '/%course-slug%/'
        );

        $permalinks = get_option( 'sensei_permalinks' );
        $lesson_permalink = isset( $permalinks['lesson'] )?  $permalinks['lesson'] : $structures['default'];

        ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th>
                    <label>

                        <input name="sensei_lesson_permalink_base_slug"
                               type="radio"
                               value="lesson"
                               class="sensei-toggle" <?php checked( $structures['default'], $lesson_permalink ); ?> />

                        <?php _e( 'Default', 'woothemes-sensei' ); ?>

                    </label>
                </th>
                <td>
                    <code><?php echo esc_html( home_url() ); ?>/lesson/sample-lesson</code>
                </td>
            </tr>
            <tr>
                <th>
                    <label>

                        <input name="sensei_lesson_permalink_base_slug"
                               type="radio"
                               value="<?php echo esc_attr( $structures['course'] ); ?>"
                               class="sensei-toggle" <?php checked( $structures['course'], $lesson_permalink ); ?> />

                        <?php _e( 'Course', 'sensei' ); ?>

                    </label>
                </th>
                <td>
                    <code><?php echo esc_html( home_url() ); ?>/course-name/sample-lesson/</code>
                </td>
            </tr>

            </tbody>

        </table>
        <?php
    }

    /**
     * Save the settings.
     */
    public function settings_save() {

        if ( ! is_admin() ) {
            return;
        }

        // We need to save the options ourselves; settings api does not trigger save for the permalinks page
        if ( isset( $_POST['sensei_lesson_permalink_base_slug'] ) ) {

            // Lesson base slug incoming
            $sensei_lesson_slug = sanitize_text_field( $_POST['sensei_lesson_permalink_base_slug'] );
            $permalinks = get_option( 'sensei_permalinks' );

            if ( ! $permalinks ) {
                $permalinks = array();
            }

            $permalinks['lesson']  =  $sensei_lesson_slug;

            update_option( 'sensei_permalinks', $permalinks );
        }
    }
}
