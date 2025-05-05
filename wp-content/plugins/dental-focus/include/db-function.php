<?php
class dentalfocus_db_function{
    function dentalfocus_query($qrySelect){
        global $wpdb;
        $resData = $wpdb->get_results($qrySelect, ARRAY_A);
        if (count($resData) > 0) {
            return $resData;
        }
        else{
            return 0;
        }
    }
	function dentalfocus_insert_records($df_table_name,$array_insert,$return_type = false){
		global $wpdb;
		$qryInsert = "INSERT INTO $df_table_name";
		$keyParameter = '';
		$valueParameter = '';
		$totalParameter = count($array_insert);
		$i = 0;
		foreach($array_insert as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$keyParameter .=  $keyField . ',';
				$valueParameter .=  "'" . $valueField . "'" . ',';
			}
			else{
				$keyParameter .=  $keyField;
				$valueParameter .=  "'" . $valueField . "'";
			}
			$i++;
		}
		$qryInsert .= "($keyParameter) VALUES ($valueParameter)";
		$wpdb->query($qryInsert);
		if($return_type){
			return $wpdb->insert_id;
		}
		else{
			return true;	
		}
	}
	
	function dentalfocus_select_all_records($df_table_name,$array_condition = null,$order_by = null,$return_type = true){
		global $wpdb;
		$qrySelect = "SELECT * FROM $df_table_name";
		$resData = $wpdb->get_results($qrySelect, ARRAY_A);
		if (count($resData) > 0) {
			return $resData;	
		}
		else{
			return 0;	
		}
	}

    function dentalfocus_select_mmt_master_records($df_table_name,$array_condition = null,$order_by = null,$return_type = true){
        global $wpdb;
        $qrySelect = "SELECT mu.member_no,
       mu.customer_last_name AS last_name,
       mu.customer_first_name  AS first_name,
       mu.customer_spouse  AS spouse,
       mu.customer_address AS address,
       mu.customer_city AS city,
       mu.customer_state AS state,
       mu.customer_zip AS zip,
       mu.customer_country AS country,
       mu.customer_home_phone AS home_phone,
       mu.customer_mobile_phone AS mobile_phone,
       mu.customer_email AS email,
       mu.chapter,
       mu.master_steinologist,
       mu.paid_until,
       mp.print_or_digital,
       mp.payment_date,
       mu.No_list,
       mu.SubCode AS 'Pmt_Terms',
       mu.FirstYear,
       mu.PastMember AS 'Mbr_Status',
       mu.Notes,
       mu.referred_by,
       mu.collecting_interests
FROM trentium_membership_users AS mu
LEFT JOIN trentium_membership_payments AS mp
ON mp.id = mu.last_payment_id
WHERE mu.customer_last_name IS NOT NULL
AND mu.customer_last_name != ''
ORDER BY mu.member_no DESC";
        $resData = $wpdb->get_results($qrySelect, ARRAY_A);
        if (count($resData) > 0) {
            return $resData;
        }
        else{
            return 0;
        }
    }
	
	function dentalfocus_edit_records($df_table_name,$array_condition,$return_type = true){
		global $wpdb;
		$editParameter = '';
		$totalParameter = count($array_condition);
		$i = 0;
		foreach($array_condition as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$editParameter .= $keyField . " = " . $valueField . " AND ";
			}
			else{
				$editParameter .= $keyField . " = " . $valueField;
			}
			$i++;
		}
		$qryEdit = "SELECT * FROM $df_table_name WHERE $editParameter";
		$resData = $wpdb->get_row($qryEdit, ARRAY_A);

		if ($resData) {
			return $resData;	
		}
		else{
			return 0;	
		}
	}
	
	function dentalfocus_update_records($df_table_name,$array_update_data,$array_condition,$return_type = true){
		global $wpdb;
		$editParameter = '';
		$totalCondition = count($array_condition);
		$totalParameter = count($array_update_data);
		$setParameter = '';
		$conditionParameter = '';
		$i = 0;
		foreach($array_condition as $keyField => $valueField){
			if(($totalCondition - 1) > $i){
				$conditionParameter .= $keyField . " = '" . $valueField . "' AND ";
			}
			else{
				$conditionParameter .= $keyField . " = '" . $valueField . "'";
			}
			$i++;
		}
		$i = 0;
		foreach($array_update_data as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$setParameter .= $keyField . " = '" . $valueField . "' , ";
			}
			else{
				$setParameter .= $keyField . " = '" . $valueField . "'";
			}
			$i++;
		}
		$qryUpdate = "UPDATE $df_table_name SET $setParameter WHERE $conditionParameter";
		
		$wpdb->query($qryUpdate);
		if($return_type){
			return true;
		}
		else{
			return true;	
		}
	}
	
	function dentalfocus_delete_records($df_table_name,$array_condition,$return_type = false){
		global $wpdb;
		$deleteParameter = '';
		$totalParameter = count($array_condition);
		$i = 0;
		foreach($array_condition as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$deleteParameter .= $keyField . " = " . $valueField . " AND ";
			}
			else{
				$deleteParameter .= $keyField . " = " . $valueField;
			}
			$i++;
		}
		$qryDelete = "DELETE FROM $df_table_name WHERE $deleteParameter";
		$wpdb->query($qryDelete);
		if($return_type){
			return true;
		}
		else{
			return true;	
		}
	}

    function dentalfocus_con_all_records($df_table_name){
        global $wpdb;
        $qrySelect = "SELECT trentium_convention.id,trentium_convention.member_name,trentium_convention.member_email,trentium_convention.member_phone,trentium_convention.grand_total,trentium_convention.created_at,trentium_con_payments.paypal_payer_id FROM trentium_convention LEFT JOIN trentium_con_payments ON trentium_con_payments.con_id = trentium_convention.id ORDER BY trentium_convention.id DESC";
        $resData = $wpdb->get_results($qrySelect, ARRAY_A);
        if (count($resData) > 0) {
            return $resData;
        }
        else{
            return 0;
        }
    }
}
?>
