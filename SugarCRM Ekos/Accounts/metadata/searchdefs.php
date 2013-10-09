<?php
$searchdefs ['Accounts'] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'nombre_comercial_marca_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_NOMBRE_COMERCIAL_MARCA',
        'width' => '10%',
        'name' => 'nombre_comercial_marca_c',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'identificacion_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_IDENTIFICACION',
        'width' => '10%',
        'name' => 'identificacion_c',
      ),
      'favorites_only' => 
      array (
        'name' => 'favorites_only',
        'label' => 'LBL_FAVORITES_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'phone_office' => 
      array (
        'type' => 'phone',
        'label' => 'LBL_PHONE_OFFICE',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_office',
      ),
      'phone_alternate' => 
      array (
        'type' => 'phone',
        'label' => 'LBL_PHONE_ALT',
        'width' => '10%',
        'default' => true,
        'name' => 'phone_alternate',
      ),
      'grupo_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_GRUPO',
        'width' => '10%',
        'name' => 'grupo_c',
      ),
      'nombre_comercial_marca_c' => 
      array (
        'type' => 'varchar',
        'default' => true,
        'label' => 'LBL_NOMBRE_COMERCIAL_MARCA',
        'width' => '10%',
        'name' => 'nombre_comercial_marca_c',
      ),
      'provincia_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_PROVINCIA',
        'width' => '10%',
        'name' => 'provincia_c',
      ),
      'ciudad_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_CIUDAD',
        'width' => '10%',
        'name' => 'ciudad_c',
      ),
      'sector_economico_c' => 
      array (
        'type' => 'enum',
        'default' => true,
        'studio' => 'visible',
        'label' => 'LBL_SECTOR_ECONOMICO',
        'width' => '10%',
        'name' => 'sector_economico_c',
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>
