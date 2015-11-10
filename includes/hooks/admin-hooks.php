<?php
/**
 * Sensei Admin Hooks
 *
 * Action/filter hooks used for Sensei functionality hooked into Sensei For admin purposes
 *
 * @author 		WooThemes
 * @package 	Sensei
 * @category 	Hooks/Admin
 * @version     1.9.0
 */

/***************************
 *
 *
 * Permalink Hooks
 *
 *
 ***************************/

//@since 1.9.0
// this hook adds the Sensei permalink settings to the permalink options page
add_action( 'current_screen', array ( 'Sensei_Permalink_Settings', 'settings_init' ), 30 );

// @since 1.9.0
// This hook ensures that the Sensei permalinks settings are saved
add_action( 'admin_init', array( 'Sensei_Permalink_Settings', 'settings_save' ) );