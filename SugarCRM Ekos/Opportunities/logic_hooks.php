<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1, 'Opportunities push feed', 'modules/Opportunities/SugarFeeds/OppFeed.php','OppFeed', 'pushFeed'); 
$hook_array['before_save'][] = Array(1, 'workflow', 'include/workflow/WorkFlowHandler.php','WorkFlowHandler', 'WorkFlowHandler');
$hook_array['before_save'][] = Array(1, 'Create quote', 'custom/modules/Opportunities/crea_cotizacion.php','clase', 'funcion'); 

$hook_array['after_ui_frame'] = Array(); 
$hook_array['after_ui_frame'][] = Array(1, 'Opportunities InsideView frame', 'modules/Connectors/connectors/sources/ext/rest/insideview/InsideViewLogicHook.php','InsideViewLogicHook', 'showFrame'); 
$hook_array['after_ui_frame'][] = Array(1, 'customizations', 'custom/modules/Opportunities/visualiza.php','clase', 'funcion');

$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1, 'Update probability oportunity', 'custom/modules/Opportunities/probabilidad.php','clases', 'funcions'); 



?>