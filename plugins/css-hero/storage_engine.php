<?php

//NEW STORAGE ENGINE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function csshero_get_table_name()  {return "csshero4";}

function csshero_storage_perform_existance_check() {
  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();
  
  //check if table is created
  if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	  
	  //TABLE IS NOT CREATED. LET'S CREATE THE TABLE HERE.
	  $charset_collate = $wpdb->get_charset_collate();
  
	  $sql = "CREATE TABLE $table_name (
		  step_id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
		  step_time DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  step_type VARCHAR(30) NOT NULL,
		  step_name VARCHAR(100) NOT NULL,
		  step_data MEDIUMBLOB NOT NULL,
		  step_theme VARCHAR(100) NOT NULL,
		  step_context VARCHAR(30) NOT NULL,
		  step_active_flag VARCHAR(3) NOT NULL,
		  UNIQUE KEY step_id (step_id)
	  ) $charset_collate;";
  
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  dbDelta( $sql );
	
  } //END IF TABLE NOT EXISTS

} //end function

//////// SAVING FUNCTIONS ////////////////////////////////////////////////////////////////////////
function csshero_storage_save_new_step($step_name, $current_settings_array, $context='frontend-css-step',$step_type='history-step') {
  //check if table exists or create it
  //csshero_storage_perform_existance_check(); //no need no more: we do it before on read

  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();
  //insert
  $the_insert=$wpdb->insert( 
		$table_name, 
		array( 
			'step_time' => current_time( 'mysql' ),
			'step_type' => $step_type,
			'step_name' => $step_name,
			'step_data' => (gzcompress(  ($current_settings_array))),
			'step_theme' => csshero_get_active_theme_slug(),
			'step_context' => $context,
			'step_active_flag' =>'no'
		) 
	);
  
  //if inserted ahistory step,, mark as not active other ones, and bless this one
  if ($step_type=='history-step' && $the_insert) csshero_storage_bless_row($wpdb->insert_id,$context);
  
	if ($the_insert)   return ($wpdb->insert_id); else return $the_insert;
}

function csshero_storage_bless_row($step_id, $context){
  if (!is_numeric($step_id)) die("<h1>Error in csshero_storage_bless_row, exiting</h1>");
  
  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();
  
  //unbless others
  $wpdb->query(
	"UPDATE $table_name SET step_active_flag = 'no'
	WHERE step_active_flag = 'yes' AND step_context = '$context' AND step_theme='".csshero_get_active_theme_slug()."'
	"
  );
  
  //bless me
  $wpdb->update( 
		  $table_name, 
		  array( 
			  'step_active_flag' => 'yes',	// string
		  ), 
		  array( 'step_id' => $step_id ,'step_context'  => $context, 'step_theme' =>csshero_get_active_theme_slug() )
	  );
  
} //end func

function csshero_storage_mark_active_step_as_preset($newname,$context='frontend-css-step') { 
  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();

  $update=$wpdb->update( 
		  $table_name, 
		  array( 
			  'step_name' => $newname,
			  'step_type' =>'preset-step'
		  ), 
		  array( 'step_active_flag' => 'yes', 'step_context' => $context
				)
	  );
  return $update;
}

function csshero_storage_delete_step($step_id)

{
  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();
  $wpdb->delete( $table_name, array( 'step_id' => $step_id, 'step_active_flag' =>'no' ) );
}


////READ////////////////FUNCTIONS  ////////////////////////////////////////////////////////////////

function csshero_get_data($step_id="default",$step_context='frontend-css-step',$field_name='step_data') {
  csshero_storage_perform_existance_check();
  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();
  
  //GET THE DATA FROM DB
  if ($step_id=="default") {
	  $value = $wpdb->get_var( "SELECT $field_name FROM $table_name WHERE step_theme='".csshero_get_active_theme_slug()."' AND step_context='".$step_context."' AND step_active_flag='yes' ORDER BY step_id DESC LIMIT 0,1" ); 
	}
    else {
	  if (!is_numeric($_GET['step_id'])) die ("<h1>Invalid step id, not numeric!");     
      $value = $wpdb->get_var( "SELECT $field_name FROM $table_name WHERE step_theme='".csshero_get_active_theme_slug()."' AND step_context='".$step_context."' and step_id=".$_GET['step_id'] );
  }
  //EXTRACT THE COMPRESSED DATA
  if ($value) return (gzuncompress($value)); else return('{}');
  
   
}

function csshero_get_saved_steps($step_context='frontend-css-step',$snapshot_type='history') {
  global $wpdb;
  $table_name = $wpdb->prefix . csshero_get_table_name();
  if ($snapshot_type=='history') $add_where=" step_type='history-step' ";
  if ($snapshot_type=='preset') $add_where=" step_type='preset-step' ";
  $rows=$wpdb->get_results( "SELECT step_id,step_type,step_name,step_time,step_active_flag FROM $table_name WHERE $add_where AND step_theme='".csshero_get_active_theme_slug()."' AND step_context='".$step_context."'  ORDER BY step_id DESC" );
  return $rows; 
}