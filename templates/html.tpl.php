<?php
// $Id: html.tpl.php,v 1.9 2011/01/14 03:12:40 jmburnz Exp $

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 * - $in_overlay: TRUE if the page is in the overlay.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN"
  "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"
  <?php print $rdf_namespaces; ?>>
<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $scripts; ?>
</head>
<?php // modify the layout by changing the id, see layout.css ?>
<body id="genesis-1c" <?php print $attributes;?>>

  <?php if (!$in_overlay): // Hide the skip-link in overlay ?>
    <div id="skip-link">
      <a href="#main-content"><?php print t('Skip to main content'); ?></a>
    </div>
    <div id="accessibility-help" class="wai-text">
    <h2><?php print t('Accessibility help');?></h2>
      <ul id="accessibility-top">
        <li id="help">
          <a accesskey="2" href="/accessibility-helps">
            <?php print t('Website accessibility helper'); //ตัวช่วยเหลือการเข้าถึงเว็บไซต์ ?>
          </a>
        </li>
        <li>
          <a accesskey="3" class="search-click" href="#edit-search-block-form--2">
            <?php print t('Website search box'); //กล่องค้นหาในเว็บไซต์ ?>
          </a>
        </li>
        <li>
          <a accesskey="4" href="#main-content">
            <?php print t('Go to main content'); //ไปยังเนื้อหาหลัก ?>
          </a>
        </li>
        <li>
          <a accesskey="5" href="#block-superfish-1">
            <?php print t('Go to main menu'); //ไปยังเมนูหลัก ?>
          </a>
        </li>
        <li>
          <a accesskey="6" href="#header">
            <?php print t('Go to top page'); //ไปยังด้านบนสุด ?>
          </a>
        </li>
        <li>
          <a accesskey="7" href="/sitemap">
            <?php print t('Sitemap'); //แผนผังเว็บไซต์ ?>
          </a>
        </li>
      </ul>
    </div>
  <?php endif; ?>

  <?php print $page_top; ?>
  <div id="wrapper" class="<?php print $classes; ?>">
    <?php print $page; ?>
  </div>
  <?php print $page_bottom; ?>

</body>
</html>
