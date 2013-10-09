<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2013-03-13 20:54:44
$dictionary['Account']['fields']['calle_principal_c']['enforced']='';
$dictionary['Account']['fields']['calle_principal_c']['dependency']='';

 

 // created: 2013-06-14 16:12:25
$dictionary['Account']['fields']['ingresos_anuales_c']['enforced']='';
$dictionary['Account']['fields']['ingresos_anuales_c']['dependency']='';

 

 // created: 2013-03-13 20:47:47
$dictionary['Account']['fields']['employees']['audited']=true;
$dictionary['Account']['fields']['employees']['comments']='Number of employees, varchar to accomodate for both number (100) or range (50-100)';
$dictionary['Account']['fields']['employees']['merge_filter']='disabled';
$dictionary['Account']['fields']['employees']['calculated']=false;

 

 // created: 2013-03-13 20:45:47
$dictionary['Account']['fields']['date_modified']['audited']=false;
$dictionary['Account']['fields']['date_modified']['comments']='Date record last modified';
$dictionary['Account']['fields']['date_modified']['merge_filter']='disabled';
$dictionary['Account']['fields']['date_modified']['calculated']=false;

 

 // created: 2013-05-05 00:14:37
$dictionary['Account']['fields']['identificacion_c']['enforced']='';
$dictionary['Account']['fields']['identificacion_c']['dependency']='';

 

 // created: 2013-03-21 05:09:44
$dictionary['Account']['fields']['provincia_c']['dependency']='';
$dictionary['Account']['fields']['provincia_c']['visibility_grid']=array (
  'trigger' => 'pais_c',
  'values' => 
  array (
    '' => 
    array (
    ),
    'Argentina' => 
    array (
    ),
    'Bolivia' => 
    array (
    ),
    'Brasil' => 
    array (
    ),
    'Chile' => 
    array (
    ),
    'Colombia' => 
    array (
    ),
    'Ecuador' => 
    array (
      0 => 'Azuay',
      1 => 'Bolivar',
      2 => 'Canar',
      3 => 'Carchi',
      4 => 'Chimborazo',
      5 => 'Cotopaxi',
      6 => 'El_Oro',
      7 => 'Esmeraldas',
      8 => 'Galapagos',
      9 => 'Guayas',
      10 => 'Imbabura',
      11 => 'Loja',
      12 => 'Los_Rios',
      13 => 'Manabi',
      14 => 'Morona_Santiago',
      15 => 'Napo',
      16 => 'Orellana',
      17 => 'Pastaza',
      18 => 'Pichincha',
      19 => 'Santa_Elena',
      20 => 'Santo_Domingo',
      21 => 'Sucumbios',
      22 => 'Tungurahua',
      23 => 'Zamora_Chinchipe',
    ),
    'Paraguay' => 
    array (
    ),
    'Peru' => 
    array (
    ),
    'Uruguay' => 
    array (
    ),
    'Venezuela' => 
    array (
    ),
  ),
);

 

 // created: 2013-07-26 16:48:54
$dictionary['Account']['fields']['deleted']['audited']=true;
$dictionary['Account']['fields']['deleted']['comments']='Record deletion indicator';
$dictionary['Account']['fields']['deleted']['merge_filter']='disabled';
$dictionary['Account']['fields']['deleted']['calculated']=false;

 

 // created: 2013-03-13 20:50:01
$dictionary['Account']['fields']['ciudad_c']['dependency']='';
$dictionary['Account']['fields']['ciudad_c']['visibility_grid']=array (
  'trigger' => 'provincia_c',
  'values' => 
  array (
    'Azuay' => 
    array (
      0 => '',
      1 => 'Cuenca',
      2 => 'Gualaceo',
      3 => 'Paute',
      4 => 'Santa_Isabel',
    ),
    'Bolivar' => 
    array (
      0 => '',
      1 => 'Caluma',
      2 => 'San_Miguel',
    ),
    'Carchi' => 
    array (
      0 => '',
      1 => 'Bolivar',
      2 => 'San_Gabriel',
      3 => 'Tulcan',
    ),
    'Canar' => 
    array (
      0 => '',
      1 => 'Azogues',
      2 => 'Canar',
    ),
    'Chimborazo' => 
    array (
      0 => '',
      1 => 'Alausi',
      2 => 'Chunchi',
      3 => 'Cumanda',
      4 => 'Guano',
      5 => 'Pallatanga',
      6 => 'Riobamba',
    ),
    'Cotopaxi' => 
    array (
      0 => '',
      1 => 'La_Mana',
      2 => 'Latacunga',
      3 => 'Pujili',
      4 => 'Salcedo',
      5 => 'Saquisili',
    ),
    'El_Oro' => 
    array (
      0 => '',
      1 => 'Arenillas',
      2 => 'Balsas',
      3 => 'El_Guabo',
      4 => 'Huaquillas',
      5 => 'Machala',
      6 => 'Pasaje',
      7 => 'Pinas',
      8 => 'Puertovelo',
      9 => 'Santa_Rosa',
      10 => 'Zaruma',
    ),
    'Esmeraldas' => 
    array (
      0 => '',
      1 => 'Atacames',
      2 => 'Esmeraldas',
      3 => 'Muisne',
      4 => 'Quininde',
    ),
    'Galapagos' => 
    array (
      0 => '',
      1 => 'Puerto_Ayora',
      2 => 'Puerto_Baquerizo_Moreno',
    ),
    'Guayas' => 
    array (
      0 => '',
      1 => 'Balao',
      2 => 'Balzar',
      3 => 'Bucay',
      4 => 'Colimes',
      5 => 'Daule',
      6 => 'Duran',
      7 => 'El_Triunfo',
      8 => 'Guayaquil',
      9 => 'Isidro_Ayora',
      10 => 'Jujan',
      11 => 'Milagro',
      12 => 'Naranjal',
      13 => 'Naranjito',
      14 => 'Nobol',
      15 => 'Palestina',
      16 => 'Pedro_Carbo',
      17 => 'Playas',
      18 => 'Salitre',
      19 => 'Samborondon',
      20 => 'Santa_Lucia',
      21 => 'Simon_Bolivar',
      22 => 'Yaguachi',
    ),
    'Imbabura' => 
    array (
      0 => '',
      1 => 'Atuntaqui',
      2 => 'Cotacachi',
      3 => 'Ibarra',
      4 => 'Otavalo',
    ),
    'Loja' => 
    array (
      0 => '',
      1 => 'Cariamanga',
      2 => 'Catacocha',
      3 => 'Catamayo',
      4 => 'Loja',
    ),
    'Los_Rios' => 
    array (
      0 => '',
      1 => 'Baba',
      2 => 'Babahoyo',
      3 => 'Buena_Fe',
      4 => 'Mocache',
      5 => 'Montalvo',
      6 => 'Palenque',
      7 => 'Puebloviejo',
      8 => 'Quevedo',
      9 => 'Valencia',
      10 => 'Ventanas',
      11 => 'Vinces',
    ),
    'Manabi' => 
    array (
      0 => '',
      1 => 'Bahia_de_Caraquez',
      2 => 'Calceta',
      3 => 'Chone',
      4 => 'El_Carmen',
      5 => 'Flavio_Alfaro',
      6 => 'Jama',
      7 => 'Jaramijo',
      8 => 'Jipijapa',
      9 => 'Junin',
      10 => 'Manta',
      11 => 'Montecristi',
      12 => 'Pedernales',
      13 => 'Pichincha',
      14 => 'Portoviejo',
      15 => 'Puerto_Lopez',
      16 => 'Pajan',
      17 => 'Rocafuerte',
      18 => 'San_Vicente',
      19 => 'Santa_Ana',
      20 => 'Sucre',
    ),
    'Morona_Santiago' => 
    array (
      0 => '',
      1 => 'Macas',
    ),
    'Napo' => 
    array (
      0 => '',
      1 => 'Tena',
    ),
    'Orellana' => 
    array (
      0 => '',
    ),
    'Pastaza' => 
    array (
      0 => '',
      1 => 'Puyo',
    ),
    'Pichincha' => 
    array (
      0 => '',
      1 => 'Cayambe',
      2 => 'Machachi',
      3 => 'Pedro_Vicente_Maldonado',
      4 => 'Puerto_Quito',
      5 => 'Quito',
      6 => 'Sangolqui',
      7 => 'Tabacundo',
    ),
    'Santa_Elena' => 
    array (
      0 => '',
      1 => 'La_libertad',
      2 => 'Santa_Elena',
    ),
    'Santo_Domingo' => 
    array (
      0 => '',
      1 => 'La_concordia',
      2 => 'Santo_Domingo',
    ),
    'Sucumbios' => 
    array (
      0 => '',
      1 => 'Nueva_Loja',
    ),
    'Tungurahua' => 
    array (
      0 => '',
      1 => 'Ambato',
      2 => 'Banos',
      3 => 'Pelileo',
      4 => 'Pillaro',
    ),
    'Zamora_Chinchipe' => 
    array (
      0 => '',
      1 => 'Zamora',
    ),
    '' => 
    array (
    ),
  ),
);

 

 // created: 2012-12-24 13:21:29

 

 // created: 2013-06-14 16:12:25

 

 // created: 2013-03-13 22:46:12
$dictionary['Account']['fields']['rango_facturacion_c']['dependency']='';
$dictionary['Account']['fields']['rango_facturacion_c']['visibility_grid']='';

 

 // created: 2013-03-13 20:52:29
$dictionary['Account']['fields']['calle_secundaria_c']['enforced']='';
$dictionary['Account']['fields']['calle_secundaria_c']['dependency']='';

 

 // created: 2013-03-13 22:50:44
$dictionary['Account']['fields']['sector_c']['enforced']='';
$dictionary['Account']['fields']['sector_c']['dependency']='';

 

 // created: 2013-03-13 20:46:12
$dictionary['Account']['fields']['account_type']['len']=100;
$dictionary['Account']['fields']['account_type']['audited']=true;
$dictionary['Account']['fields']['account_type']['comments']='The Company is of this type';
$dictionary['Account']['fields']['account_type']['merge_filter']='disabled';
$dictionary['Account']['fields']['account_type']['calculated']=false;
$dictionary['Account']['fields']['account_type']['dependency']=false;

 

 // created: 2013-06-12 13:23:34
$dictionary['Account']['fields']['logotipo_c']['dependency']='';

 

 // created: 2013-03-13 22:47:09
$dictionary['Account']['fields']['grupo_c']['enforced']='';
$dictionary['Account']['fields']['grupo_c']['dependency']='';

 

 // created: 2013-03-13 20:48:01
$dictionary['Account']['fields']['email1']['audited']=true;
$dictionary['Account']['fields']['email1']['merge_filter']='disabled';
$dictionary['Account']['fields']['email1']['calculated']=false;

 

 // created: 2013-03-13 20:49:39
$dictionary['Account']['fields']['sector_economico_c']['dependency']='';
$dictionary['Account']['fields']['sector_economico_c']['visibility_grid']='';

 

 // created: 2013-03-21 05:08:51
$dictionary['Account']['fields']['phone_office']['required']=true;
$dictionary['Account']['fields']['phone_office']['comments']='The office phone number';
$dictionary['Account']['fields']['phone_office']['merge_filter']='disabled';
$dictionary['Account']['fields']['phone_office']['calculated']=false;
$dictionary['Account']['fields']['phone_office']['len']='9';

 

// created: 2012-12-24 13:07:13
$dictionary["Account"]["fields"]["accounts_sucursales_1"] = array (
  'name' => 'accounts_sucursales_1',
  'type' => 'link',
  'relationship' => 'accounts_sucursales_1',
  'source' => 'non-db',
  'side' => 'right',
  'vname' => 'LBL_ACCOUNTS_SUCURSALES_1_FROM_SUCURSALES_TITLE',
);


 // created: 2013-03-18 15:44:07
$dictionary['Account']['fields']['referencia_c']['enforced']='';
$dictionary['Account']['fields']['referencia_c']['dependency']='';

 

 // created: 2013-03-13 21:57:33
$dictionary['Account']['fields']['name']['comments']='Name of the Company';
$dictionary['Account']['fields']['name']['merge_filter']='disabled';
$dictionary['Account']['fields']['name']['calculated']=false;

 

 // created: 2013-03-13 20:54:54
$dictionary['Account']['fields']['tipo_cuenta_c']['dependency']='';
$dictionary['Account']['fields']['tipo_cuenta_c']['visibility_grid']='';

 

 // created: 2013-06-12 13:44:39
$dictionary['Account']['fields']['tipo_de_institucion_c']['dependency']='';
$dictionary['Account']['fields']['tipo_de_institucion_c']['visibility_grid']='';

 

 // created: 2013-03-18 15:42:48
$dictionary['Account']['fields']['piso_oficina_c']['enforced']='';
$dictionary['Account']['fields']['piso_oficina_c']['dependency']='';

 

 // created: 2013-03-13 22:45:52
$dictionary['Account']['fields']['fecha_certificacion_c']['enforced']='';
$dictionary['Account']['fields']['fecha_certificacion_c']['dependency']='';

 

 // created: 2013-03-13 22:47:34
$dictionary['Account']['fields']['inf_certificada_por_c']['dependency']='';

 

 // created: 2013-03-13 20:45:41
$dictionary['Account']['fields']['date_entered']['audited']=false;
$dictionary['Account']['fields']['date_entered']['comments']='Date record created';
$dictionary['Account']['fields']['date_entered']['merge_filter']='disabled';
$dictionary['Account']['fields']['date_entered']['calculated']=false;

 

 // created: 2013-03-13 21:23:28
$dictionary['Account']['fields']['edificio_c']['enforced']='';
$dictionary['Account']['fields']['edificio_c']['dependency']='';

 

 // created: 2013-06-14 16:12:46
$dictionary['Account']['fields']['annual_revenue']['audited']=true;
$dictionary['Account']['fields']['annual_revenue']['comments']='Annual revenue for this company';
$dictionary['Account']['fields']['annual_revenue']['merge_filter']='disabled';
$dictionary['Account']['fields']['annual_revenue']['calculated']=false;

 

 // created: 2013-03-13 20:51:56
$dictionary['Account']['fields']['tipo_identificacion_c']['dependency']='';
$dictionary['Account']['fields']['tipo_identificacion_c']['visibility_grid']='';

 

 // created: 2013-05-17 10:51:04
$dictionary['Account']['fields']['pais_c']['dependency']='';
$dictionary['Account']['fields']['pais_c']['visibility_grid']='';

 

 // created: 2013-03-13 20:46:01
$dictionary['Account']['fields']['description']['audited']=false;
$dictionary['Account']['fields']['description']['comments']='Full text of the note';
$dictionary['Account']['fields']['description']['merge_filter']='disabled';
$dictionary['Account']['fields']['description']['calculated']=false;

 

 // created: 2013-03-21 05:08:37
$dictionary['Account']['fields']['phone_fax']['len']='9';
$dictionary['Account']['fields']['phone_fax']['comments']='The fax phone number of this company';
$dictionary['Account']['fields']['phone_fax']['merge_filter']='disabled';
$dictionary['Account']['fields']['phone_fax']['calculated']=false;
$dictionary['Account']['fields']['phone_fax']['audited']=true;

 

 // created: 2013-03-18 15:39:25
$dictionary['Account']['fields']['nombre_comercial_marca_c']['enforced']='';
$dictionary['Account']['fields']['nombre_comercial_marca_c']['dependency']='';

 

 // created: 2013-03-13 20:53:49
$dictionary['Account']['fields']['notas_c']['enforced']='';
$dictionary['Account']['fields']['notas_c']['dependency']='';

 

 // created: 2013-03-13 20:53:26
$dictionary['Account']['fields']['telefono_otro_c']['enforced']='';
$dictionary['Account']['fields']['telefono_otro_c']['dependency']='';

 

 // created: 2013-03-13 22:45:29
$dictionary['Account']['fields']['entrega_especial_c']['dependency']='';
$dictionary['Account']['fields']['entrega_especial_c']['visibility_grid']='';

 

 // created: 2013-03-18 15:43:20
$dictionary['Account']['fields']['numero_c']['enforced']='';
$dictionary['Account']['fields']['numero_c']['dependency']='';

 

 // created: 2013-03-21 05:08:27
$dictionary['Account']['fields']['phone_alternate']['len']='9';
$dictionary['Account']['fields']['phone_alternate']['comments']='An alternate phone number';
$dictionary['Account']['fields']['phone_alternate']['merge_filter']='disabled';
$dictionary['Account']['fields']['phone_alternate']['calculated']=false;
$dictionary['Account']['fields']['phone_alternate']['audited']=true;

 
?>