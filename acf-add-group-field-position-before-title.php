<?php

/*
Plugin Name:  ACF Before Title
Description:  Adds a choice "High (before title) to ACF field groups position drop-down"
Author:       Smeedijzer-ijzersterk-online
Author URI:   https://github.com/Smeedijzer-ijzersterk-online/
Version:      1.0
*/

namespace App;

add_action('edit_form_top',                   __NAMESPACE__ . '\\print_acf_fields_before_title');
add_filter('acf/get_valid_field/type=select', __NAMESPACE__ . '\\add_acf_field_position_before_title');

function print_acf_fields_before_title() {
  global $post;
  do_meta_boxes(get_current_screen(), 'acf_before_title', $post);
}

function add_acf_field_position_before_title($field) {
  if(!is_acf_group_field_position_field($field)) {
    return $field;
  }
  $field['choices'] = array_merge(['acf_before_title' => 'Boven titel'], $field['choices']);
  return $field;
}

function is_acf_group_field_position_field($field) {
  $current_screen = get_current_screen();
  if(empty($current_screen) || !isset($current_screen->post_type) || 'acf-field-group' !== $current_screen->post_type) {
    return false;
  }
  if('position' !== $field['name']) {
    return false;
  }
  if('acf_field_group' !== $field['prefix']) {
    return false;
  }
  if(!array_key_exists('acf_after_title', $field['choices'])) {
    return false;
  }
  return true;
}
