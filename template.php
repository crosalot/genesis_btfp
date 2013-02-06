<?php
// $Id: template.php,v 1.10 2011/01/14 02:57:57 jmburnz Exp $

/**
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function to match your subthemes name,
 *    e.g. if you name your theme "themeName" then the function
 *    name will be "themeName_preprocess_hook". Tip - you can
 *    search/replace on "genesis_SUBTHEME".
 * 2. Uncomment the required function to use.
 */

/**
 * Override or insert variables into all templates.
 */
/* -- Delete this line if you want to use these functions
function genesis_SUBTHEME_preprocess(&$vars, $hook) {
}
function genesis_SUBTHEME_process(&$vars, $hook) {
}
// */

/**
 * Override or insert variables into the html templates.
 */
/* -- Delete this line if you want to use these functions
function genesis_SUBTHEME_preprocess_html(&$vars) {
  // Uncomment the folowing line to add a conditional stylesheet for IE 7 or less.
  // drupal_add_css(path_to_theme() . '/css/ie/ie-lte-7.css', array('weight' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
}
function genesis_SUBTHEME_process_html(&$vars) {
}
// */

/**
 * Override or insert variables into the page templates.
 */
/* -- Delete this line if you want to use these functions
function genesis_SUBTHEME_preprocess_page(&$vars) {
}
function genesis_SUBTHEME_process_page(&$vars) {
}
// */

/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function genesis_SUBTHEME_preprocess_node(&$vars) {
}
function genesis_SUBTHEME_process_node(&$vars) {
}
// */

/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function genesis_SUBTHEME_preprocess_comment(&$vars) {
}
function genesis_SUBTHEME_process_comment(&$vars) {
}
// */
/**
 * Override or insert variables into the block templates.
 */
/* -- Delete this line if you want to use these functions
function genesis_SUBTHEME_preprocess_block(&$vars) {
}
function genesis_SUBTHEME_process_block(&$vars) {
}
// */
function genesis_btfp_links($variables) {
  $links = $variables['links'];
  $attributes = $variables['attributes'];
  $heading = $variables['heading'];
  global $language_url;
  $output = '';

  // Rutz override.
  $current_alias = drupal_get_path_alias($_GET['q']);
  // End override.

  if (count($links) > 0) {
    $output = '';

    // Treat the heading first if it is present to prepend it to the
    // list of links.
    if (!empty($heading)) {
      if (is_string($heading)) {
        // Prepare the array that will be used when the passed heading
        // is a string.
        $heading = array(
          'text' => $heading,
          // Set the default level of the heading. 
          'level' => 'h2',
        );
      }
      $output .= '<' . $heading['level'];
      if (!empty($heading['class'])) {
        $output .= drupal_attributes(array('class' => $heading['class']));
      }
      $output .= '>' . check_plain($heading['text']) . '</' . $heading['level'] . '>';
    }

    $output .= '<ul' . drupal_attributes($attributes) . '>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = array($key);

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class[] = 'first';
      }
      if ($i == $num_links) {
        $class[] = 'last';
      }

      // Rutz override.
      if (isset($link['href'])) {
        $link_alias = drupal_get_path_alias($link['href']);
        if (strpos($current_alias, $link_alias .'/') !== FALSE) {
          $link['in_active_trail'] = TRUE;
          if (isset($link['attributes']['class'])) {
            $link['attributes']['class'] .= ' active-trail active';
          }
          else {
            $link['attributes']['class'] = 'active-trail active';
          }
          if (!in_array('active', $class)) {
            $class[] = 'active';
          }
          if (!in_array('active-trail', $class)) {
            $class[] = 'active-trail';
          }
        }
      }
      // End override.

      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))
       && (empty($link['language']) || $link['language']->language == $language_url->language)) {
        $class[] = 'active';
      }
      $output .= '<li' . drupal_attributes(array('class' => $class)) . '>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      elseif (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes.
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span' . $span_attributes . '>' . $link['title'] . '</span>';
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}

function genesis_btfp_date_nav_title($params) {
  $granularity = $params['granularity'];
  $view = $params['view'];
  $date_info = $view->date_info;
  $link = !empty($params['link']) ? $params['link'] : FALSE;
  $format = !empty($params['format']) ? $params['format'] : NULL;
  switch ($granularity) {
    case 'year':
      $title = $date_info->year;
      $date_arg = $date_info->year;
      break;
    case 'month':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F Y' : 'F Y');
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year .'-'. date_pad($date_info->month);
      break;
    case 'day':
      $format = !empty($format) ? $format : (empty($date_info->mini) ? 'l, F j Y' : 'l, F j');
      $title = date_format_date($date_info->min_date, 'custom', $format);
      $date_arg = $date_info->year .'-'. date_pad($date_info->month) .'-'. date_pad($date_info->day);
      break;
    case 'week':
        $format = !empty($format) ? $format : (empty($date_info->mini) ? 'F j Y' : 'F j');
      $title = t('Week of @date', array('@date' => date_format_date($date_info->min_date, 'custom', $format)));
        $date_arg = $date_info->year .'-W'. date_pad($date_info->week);
        break;
  }
  if (!empty($date_info->mini) || $link) {
      // Month navigation titles are used as links in the mini view.
    $attributes = array('title' => t('View full page month'));
      $url = date_pager_url($view, $granularity, $date_arg, TRUE);
    return $title;
  }
  else {
    return $title;
  }  
}

function genesis_btfp_calendar_tooltips_preprocess_calendar_datebox(&$vars) {
  $date = $vars['date'];
  $view = $vars['view'];
  $vars['day'] = intval(substr($date, 8, 2));
  $force_view_url = !empty($view->date_info->block) ? TRUE : FALSE;
  $month_path = calendar_granularity_path($view, 'month');
  $year_path = calendar_granularity_path($view, 'year');
  $day_path = calendar_granularity_path($view, 'day');
  unset($month_path,$year_path,$day_path);
  $month_path ='';
  $year_path = '';
  $day_path = '';
  $vars['url'] = str_replace(array($month_path, $year_path), $day_path, date_pager_url($view, NULL, $date, $force_view_url));
  $vars['link'] = !empty($day_path) ? l($vars['day'], $vars['url']) : $vars['day'];
  $vars['granularity'] = $view->date_info->granularity;
  $vars['mini'] = !empty($view->date_info->mini);
  




  /* The following code has been added. It aggregates event data
     of that day and puts it in an HTML unordered list,
     which is parented in a div element, which, on its turn,
     is placed next to the hyperlink. The div element with the event
     data is hidden by using a "display:none" style.
     The code for telling Beautytips that this is the place to look for
     event data, is in the function
     calendar_tooltips_initialize_beautytips().
  */
  if (!empty($vars['selected'])) {
    $bt_text = "<ul>";
    foreach ($vars['items'][$date] as $time => $results_at_that_time) {
      foreach ($results_at_that_time as $num => $result) {
        $result = (array)$result;
        $bt_text .= "<li>";
        /* The event data shown in the tooltip can be specified in
           the display settings of your calendar view.
           Choose the "Block view" display, and check out
           the "Fields" section.
        */
        foreach ($view->field as $name => $field) {
          if (!$field->options['exclude']) {
            if ($field->options['label'] != "" &&
              ($result['rendered_fields'][$name] != "" ||
              empty($field->options['hide_empty'])))
              $bt_text .= "<div class=\"calendar_tooltips-" . $name .
                "-label\">" . $field->options['label'] .
                ($field->options['element_label_colon'] ? ":" : "") .
                "</div>";
            if ($result['rendered_fields'][$name] != "")
              $bt_text .= "<div class=\"calendar_tooltips-" . $name .
                "-value\">" . $result['rendered_fields'][$name] .
                "</div>";
          }
        }
        $bt_text .= "</li>";
      }
    }
    $bt_text .= "</ul>";
    $bt_text = "<div class=\"calendar_tooltips\" style=\"display:none\">" .
      $bt_text . "</div>";
    if (!empty($day_path))
      $vars['link'] = l($vars['day'], $vars['url']);
    else
      $vars['link'] = '<span>' . $vars['day'] . '</span>';
    $vars['link'] .= $bt_text;
    /*
       The balloon text is appended to the link variable,
       like this: "<a href=...>31</a> <div>balloon text</div>" (see above).
       which makes it difficult for the user to alter the link without
       losing the balloon text. That's why we provide an extra variable with
       the balloon text only. The user may use this to append to
       the new link when overriding calendar-datebox.tpl.php.
    */
    $vars['calendar_tooltips_text'] = $bt_text;
  }
  /* End of additional code. */

  if ($vars['mini']) {
    if (!empty($vars['selected'])) {
      $vars['class'] = 'mini-day-on';
    }
    else {
      $vars['class'] = 'mini-day-off';
    }
  }
  else {
    $vars['class'] = 'day';
  }
}


function genesis_btfp_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
  
    unset($form['search_block_form']['#title']);
    
    $form['search_block_form']['#title_display'] = 'invisible';
    $form_default = t('Search');
    $form['search_block_form']['#default_value'] = $form_default;
//    $form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search.jpg');
    

$form['search_block_form']['#attributes'] = array('onblur' => "if (this.value == '') {this.value = '{$form_default}';}", 'onfocus' => "if (this.value == '{$form_default}') {this.value = '';}" );
  }
}

function genesis_btfp_process_page(&$variables) {
  drupal_add_js(drupal_get_path('theme', 'genesis_btfp') .'/js/custom.js', 'file');
  if (arg(0) == 'node' && is_numeric(arg(1)) && arg(2) == 'edit') {
    $node = node_load(arg(1));
    if ($node->type == 'research_fund_form') {
      $variables['title'] = t('Update request funding online');
    }
    elseif ($node->type == 'webboard') {
      $variables['title'] = t('Edit subject').' '.$node->title;
    }
  }
  if (drupal_is_front_page()) {
    $variables['title'] = FALSE;
  }

}

function genesis_btfp_preprocess_field(&$variables) {
  if($variables['element']['#field_name'] == 'field_webboard_file') {
    $file = (array)$variables['items']['0']['#file'];
    if (strpos($file['filemime'], 'image') !== FALSE) {
      $render = theme('image_style', array('style_name' => 'webboard_detail', 'path' => $file['uri']));
      $variables['items']['0'] = array('#markup' => $render);
    }
  }
}

function genesis_btfp_preprocess_node(&$variables) { 
  $variables['num_comments'] = db_query('SELECT COUNT(cid) AS count FROM {comment} WHERE nid = :nid', array(':nid' => $variables['nid']))->fetchField();
}

function genesis_btfp_comment_post_forbidden($variables) {
  $node = $variables['node'];
  global $user;

  // Since this is expensive to compute, we cache it so that a page with many
  // comments only has to query the database once for all the links.
  $authenticated_post_comments = &drupal_static(__FUNCTION__, NULL);

  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output a link if we are certain that users will get permission
      // to post comments by logging in.
      $comment_roles = user_roles(TRUE, 'post comments');
      $authenticated_post_comments = isset($comment_roles[DRUPAL_AUTHENTICATED_RID]);
    }    

    if ($authenticated_post_comments) {
      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_' . $node->type, COMMENT_FORM_BELOW) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = array('destination' => "comment/reply/$node->nid#comment-form");
      }    
      else {
        $destination = array('destination' => "node/$node->nid#comment-form");
      }    

      if (variable_get('user_register', USER_REGISTER_VISITORS_ADMINISTRATIVE_APPROVAL)) {
        // Users can register themselves.
        return t('<a class="btn-blue" href="@login">Log in</a> or <a href="@register">register</a> to post comments', array('@login' => url('user/login', array('query' => $destination)), '@register' => url('user/register', array('query' => $destination))));
      }    
      else {
        // Only admins can add new users, no public registration.
        return t('<a class="btn-blue" href="@login">Log in</a> to post comments', array('@login' => url('user/login', array('query' => $destination))));
      }    
    }    
  }
}

function genesis_btfp_pubdlcnt_counter($variables) {
  
  $type = $variables['type'];
  $value = $variables['value'];
  $path = $variables['path'];
  
  if ($path) {
    $output = ' <a href="' . $path . '">(' . $value . ')</a>';
  }
  else {
    $output = ' <span class="dcount">(' . $value . ')</span>';
  }
  $output = '';
  return $output;
}

/*
* hooker by bob
*
*/

function genesis_btfp_block_view_alter(&$data, $block) { 
  if($block->module == 'simplenews') { // condition, so all block titles won't be translated
    $block->title = t($block->title);
  }
}

function genesis_btfp_file_icon($variables) {

  $file = $variables['file'];
  $icon_directory = $variables['icon_directory'];

  $mime = check_plain($file->filemime);
  $icon_url = file_icon_url($file, $icon_directory);
  return '<img class="file-icon" alt="' . $mime . '" title="' . $mime . '" src="' . $icon_url . '" />';
}

function genesis_btfp_file_link($variables) {
  $file = $variables['file'];
  $icon_directory = $variables['icon_directory'];

  $url = file_create_url($file->uri);
  $icon = theme('file_icon', array('file' => $file, 'icon_directory' => $icon_directory));

  // Set options as per anchor format described at
  // http://microformats.org/wiki/file-format-examples
  $options = array(
    'attributes' => array(
      'type' => $file->filemime . '; length=' . $file->filesize,
      'target' => '_blank',
    ),
  );

  // Use the description as the link text if available.
  if (empty($file->description)) {
    $link_text = $file->filename;
  }
  else {
    $link_text = $file->description;
    $options['attributes']['title'] = check_plain($file->filename);
  }

  return '<span class="file">' . $icon . ' ' . l($link_text, $url, $options) . '</span>';
}

function genesis_btfp_form_element($variables) {
  $element = &$variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );  

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : ''; 
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : ''; 

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      if (!empty($element['#description'])) {
        $output .= '<div class="description">' . $element['#description'] . "</div>\n";
      }   

      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      if (!empty($element['#description'])) {
        $output .= '<div class="description">' . $element['#description'] . "</div>\n";
      }   
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  $output .= "</div>\n";

  return $output;
}
