<?php
    $manifest = array (
         'acceptable_sugar_versions' =>
          array (
			'5.x.x'
          ),
          'acceptable_sugar_flavors' =>
          array(
            'ENT','PRO'
          ),
          'readme'=>'',
          'key'=>'xxx',
          'author' => 'xxx',
          'description' => 'scheduler job package',
          'icon' => '',
          'is_uninstallable' => true,
          'name' => 'xxx',
          'published_date' => '2010-04-28 11:56:00',
          'type' => 'module',
          'version' => '1.0.0',
          'remove_tables' => 'prompt',
          );
$installdefs = array (
  'id' => 'xxx',
  'beans' =>
  array (
 
  ),
  'layoutdefs' =>
  array (
  ),
  'relationships' =>
  array (
  ),
  'copy' =>
  array (
    array (
      'from' => '<basepath>/SugarModules/custom/modules/Schedulers/comparedates.php',
      'to' => 'custom/modules/Schedulers/comparedates.php',
    ),
  ),
  'language' =>
  array (
    array (
      'from' => '<basepath>/SugarModules/language/Schedulers/custom.lang.php',
      'to_module' => 'Schedulers',
      'language' => 'en_us',
    ),
  ),
);