<?php
$popupMeta = array (
    'moduleMain' => 'Account',
    'varName' => 'ACCOUNT',
    'orderBy' => 'name',
    'whereClauses' => array (
  'name' => 'accounts.name',
  'identificacion_c' => 'accounts_cstm.identificacion_c',
  'email' => 'accounts.email',
  'assigned_user_id' => 'accounts.assigned_user_id',
),
    'searchInputs' => array (
  0 => 'name',
  3 => 'identificacion_c',
  4 => 'email',
  5 => 'assigned_user_id',
),
    'create' => array (
  'formBase' => 'AccountFormBase.php',
  'formBaseClass' => 'AccountFormBase',
  'getFormBodyParams' => 
  array (
    0 => '',
    1 => '',
    2 => 'AccountSave',
  ),
  'createButton' => 'LNK_NEW_ACCOUNT',
),
    'searchdefs' => array (
  'name' => 
  array (
    'name' => 'name',
    'width' => '10%',
  ),
  'identificacion_c' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_IDENTIFICACION',
    'width' => '10%',
    'name' => 'identificacion_c',
  ),
  'email' => 
  array (
    'name' => 'email',
    'width' => '10%',
  ),
  'assigned_user_id' => 
  array (
    'name' => 'assigned_user_id',
    'label' => 'LBL_ASSIGNED_TO',
    'type' => 'enum',
    'function' => 
    array (
      'name' => 'get_user_array',
      'params' => 
      array (
        0 => false,
      ),
    ),
    'width' => '10%',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'width' => '40',
    'label' => 'LBL_LIST_ACCOUNT_NAME',
    'link' => true,
    'default' => true,
  ),
  'BILLING_ADDRESS_STREET' => 
  array (
    'width' => '10',
    'label' => 'LBL_BILLING_ADDRESS_STREET',
    'default' => false,
  ),
  'BILLING_ADDRESS_CITY' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_CITY',
    'default' => true,
  ),
  'BILLING_ADDRESS_STATE' => 
  array (
    'width' => '7',
    'label' => 'LBL_STATE',
    'default' => true,
  ),
  'BILLING_ADDRESS_COUNTRY' => 
  array (
    'width' => '10',
    'label' => 'LBL_COUNTRY',
    'default' => true,
  ),
  'BILLING_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10',
    'label' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_STREET' => 
  array (
    'width' => '10',
    'label' => 'LBL_SHIPPING_ADDRESS_STREET',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_CITY' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_CITY',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_STATE' => 
  array (
    'width' => '7',
    'label' => 'LBL_STATE',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_COUNTRY' => 
  array (
    'width' => '10',
    'label' => 'LBL_COUNTRY',
    'default' => false,
  ),
  'SHIPPING_ADDRESS_POSTALCODE' => 
  array (
    'width' => '10',
    'label' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'default' => false,
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '2',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'default' => true,
  ),
  'PHONE_OFFICE' => 
  array (
    'width' => '10',
    'label' => 'LBL_LIST_PHONE',
    'default' => false,
  ),
),
);
