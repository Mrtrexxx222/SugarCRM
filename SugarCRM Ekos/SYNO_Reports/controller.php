<?php
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

class SYNO_ReportsController extends SugarController
{
    function action_detailview()
    {
        global $app_strings;

        $matrice_ok = false;
        $sql_header_matrice = array();
        $sql_result_matrice = array();

        $sql_header = array();
        $sql_result = array();

        // Exécution de la requêtte SQL
        $db = DBManagerFactory::getInstance();        
        $result = $db->query(from_html($this->bean->description), true, $app_strings['ERR_EXPORT_TYPE'].": <BR>.".$this->bean->description);
        if ($result !== FALSE) {
            $sql_header = $db->getFieldsArray($result);

            // On check si on est en Matrice qu'il n'y a que 3 colonnes
            if ($this->bean->syno_reports_type == 'matrix' && count($sql_header) == 3) {
                $matrice_ok = TRUE;
                $original_datas = array();
            }

            while($val = $db->fetchByAssoc($result, -1, false)) {
                $sql_result[] = $val;
                if ($matrice_ok) {
                    $original_datas[] = $val;
                }
            }

            if ($matrice_ok) {
                // Mode Matrie en plus
                $sql_header_matrice = array();
                $sql_header_matrice_tmp = array();
                $sql_result_matrice = array();
                // On check que Google Maps est activé et que les 2 colonnes clés soient présentes
                if ($this->bean->syno_reports_type == 'geoloc' && !empty($google_maps_api_key) && array_search('dep', $sql_header_matrice) !== FALSE && array_search('counter', $sql_header_matrice) !== FALSE) {
                    $google_maps_ok = TRUE;
                }
                foreach ($original_datas as $original_data) {
                    $nb_column = 0;
                    foreach ($original_data as $key => $val) {
                        switch ($nb_column) {
                            case 0 :
                                $sql_header_matrice_tmp[] = $key;
                                break;
                            case 1 :
                                $sql_header_matrice_tmp[] = $val;
                                break;
                            default : 
                                break 2;
                        }
                        $nb_column++;
                    }
                }
                $sql_header_matrice_tmp = array_unique($sql_header_matrice_tmp);
                foreach ($sql_header_matrice_tmp as $key => $val) {
                    $sql_header_matrice[] = $val;
                }
                $sql_header_matrice_tmp = array();
                foreach ($sql_header_matrice as $key => $val) {
                    $sql_header_matrice_tmp[$val] = $key;
                }

                foreach ($original_datas as $original_data) {
                    $nb_column = 0;
                    $current_matrice_key_1 = '';
                    $current_matrice_key_2 = '';
                    $current_matrice_key_2_value = 0;
                    foreach ($original_data as $key => $val) {
                        switch ($nb_column) {
                            case 0 :
                                $current_matrice_key_1 = $val;
                                break;                                
                            case 1 :
                                $current_matrice_key_2 = $key;
                                break;
                            case 2 :
                                $current_matrice_key_2_value = $val;
                                break 2;
                       }
                       $nb_column++;
                    }
                    $sql_result_matrice[$original_data[$sql_header_matrice[0]]][0] = $original_data[$sql_header_matrice[0]];
                    $sql_result_matrice[$original_data[$sql_header_matrice[0]]][$sql_header_matrice_tmp[$original_data[$current_matrice_key_2]]] = $current_matrice_key_2_value;
                }
                foreach ($sql_header_matrice as $sql_header_matrice_key => $sql_header_matrice_val) {
                    foreach ($sql_result_matrice as $sql_result_matrice_key => $sql_result_matrice_val) {
                        if (!array_key_exists($sql_header_matrice_key, $sql_result_matrice[$sql_result_matrice_key])) {
                            $sql_result_matrice[$sql_result_matrice_key][$sql_header_matrice_key] = '';
                        }                        
                    }
                }
                
                foreach($sql_result_matrice as $key => $matrice){
                    ksort($matrice);
                    $sql_result_matrice[$key] = $matrice;
                }
            }

        }
        
        /*$fp = fopen('custom/modules/Opportunities/Array_detalle.txt', 'w');
        fwrite($fp, $this->bean->description);
        fclose($fp);*/
		
		$nombre_reporte = $GLOBALS['FOCUS']->name;
		if($nombre_reporte == 'Mapa de relacionadores')
		{
			$i=0;
			$cuenta="";
			$bandera='0';
			$producto = array();
			$db =  DBManagerFactory::getInstance();
			$resultado_matriz.="<table id='thetable' cellspacing='0' border='1' width='100%' >
									<thead>
										<tr>";
			foreach($sql_header_matrice as $row)
			{
				if($i == 0)
				{
					$resultado_matriz.="<td id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</td>";
					$resultado_matriz.="<td id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Nombre Comercial</td>";
					$i++;
				}
				else
				{
					$resultado_matriz.="<td id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</td>";
					$producto[$i] = $row;
					$i++;
				}
			}
			$i=0;
			$resultado_matriz.="</tr></thead>
								<tfoot>
								<tr>";
			foreach($sql_header_matrice as $row)
			{
				if($i == 0)
				{
					$resultado_matriz.="<td id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</td>";
					$resultado_matriz.="<td id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>Nombre Comercial</td>";
				}
				else
				{
					$resultado_matriz.="<td id='".$i."' style='border:1px solid; border-color: #D8D8D8; color:#888888; background-color:#F0F0F0;'>".$row."</td>";
				}
				$i++; 
			}
			$resultado_matriz.="</tr></tfoot> 
					<tbody>";
			foreach($sql_result_matrice as $colum)
			{
				$i=0;
				$bandera='0';
				if($i==0)
				{
					$resultado_matriz.="<tr class='first'>";
				}
				else
				{
					$resultado_matriz.="<tr>";
				}
				foreach($colum as $value)
				{
					if($bandera=='0')
					{
						$resultado_matriz.="<td style='border:1px solid; border-color: #D8D8D8;'>".$value."</td>";
						$cuenta = $value;
						$bandera='1';
						$first_part = '';
						$first_part = strstr($cuenta, "'", true);
						if($first_part != '')
						{
							$last_part = strstr($cuenta, "'");
							$new_last_part = "\\".$last_part;
							$cuenta = $first_part.$new_last_part;
						}
						$query = "SELECT nombre_comercial_marca_c FROM accounts_cstm a, accounts b WHERE b.id = a.id_c and b.name = '".$cuenta."' and b.deleted = '0'";
						$result = $db->query($query, true, 'Error selecting the account record');
						if($row=$db->fetchByAssoc($result))
						{
							$resultado_matriz.="<td style='border:1px solid; border-color: #D8D8D8;'>".$row['nombre_comercial_marca_c']."</td>";
						}
						else
						{
							$resultado_matriz.="<td style='border:1px solid; border-color: #D8D8D8;'></td>";
						}
					}
					else
					{
						$bandera='1';
						$query = "SELECT c.first_name, c.last_name, d.color_c FROM users c, users_cstm d WHERE c.id = d.id_c AND CONCAT(c.first_name,' ',c.last_name) = '".$value."'";
						$result = $db->query($query, true, 'Error selecting the user record');
						if($row=$db->fetchByAssoc($result))
						{
							$resultado_matriz.="<td style='border:1px solid; border-color: #D8D8D8;background-color:#".$row['color_c'].";'>".$value."</td>";
						}
						else
						{
							$resultado_matriz.="<td style='border:1px solid; border-color: #D8D8D8;'></td>";
						}
					}
					$i++;
				}
				$resultado_matriz.="</tr>";
			}
			$resultado_matriz.="</tbody></table>
			<script>
				jQuery(document).ready(function($)
				{
					$('#thetable').tableScroll({height:300});
					$('#thetable2').tableScroll();
				});
			</script>";
		}
		
		if($nombre_reporte == 'Pipeline de ventas')
		{		
			$fp = fopen('custom/modules/Opportunities/Array_detalle.txt', 'w');
			fwrite($fp, $this->bean->description);
			fclose($fp);
			$resultado_pipe.="<link rel='stylesheet' type='text/css' href='custom/modules/SYNO_Reports/phpChart_Basic/js/jquery.jqplot.min.css'>							
				<script  type='text/javascript' src='custom/modules/SYNO_Reports/phpChart_Basic/js/jquery.jqplot.min.js' ></script>
				";
		}
		
        // Transmission des données à la vue
        $this->bean->synoReportsData = array(
            'SQL_HEADER'            => $sql_header,
            'SQL_RESULT'            => $sql_result,
            'SQL_HEADER_MATRICE'    => $sql_header_matrice,
            'SQL_RESULT_MATRICE'    => $sql_result_matrice,
            'MATRICE_OK'            => ($matrice_ok ? 1 : 0),
			'DESC'					=> $this->bean->description,
			'MAPA'					=> $resultado_matriz,
			'PIPE'					=> $resultado_pipe,
        );

        $this->view = 'detail';
    }
}
?>
