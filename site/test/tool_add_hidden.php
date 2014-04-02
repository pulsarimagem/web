<?php
function add_hidden($startRow_retorno = 0) {
	if(!empty($_GET) || !empty($HTTP_GET_VARS)){
		$_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
		foreach ($_GET as $_get_name => $_get_value) {
			if ($_get_name != "ajustar" && $_get_name != "preview" && $_get_name != "maxRows" && $_get_name != "ordem" && $_get_name != "filtro") {
				if(is_array($_get_value )) {
					foreach ($_get_value as $get_val_arr => $val_arr) {
						echo "<input name=\"".$_get_name."[]\" type=\"hidden\" value=\"".stripslashes($val_arr)."\" />";
						
					}
				} else {
					echo "<input name=\"" .$_get_name."\" type=\"hidden\" value=\"".stripslashes($_get_value)."\" />";
				}
			}
		}
	}
	if(!empty($_POST) || !empty($HTTP_POST_VARS)){
		$_GET = empty($_POST) ? $HTTP_POST_VARS : $_POST;
		foreach ($_POST as $_post_name => $_post_value) {
			if ($_post_name != "ajustar" && $_post_name != "preview" && $_post_name != "maxRows" && $_get_name != "ordem" && $_get_name != "filtro") {
				if(is_array($_post_value )) {
					foreach ($_post_value as $post_val_arr => $val_arr) {
						echo "<input name=\"".$_post_name."[]\" type=\"hidden\" value=\"".stripslashes($val_arr)."\" />";
						
					}
				} else {
					echo "<input name=\"".$_post_name."\" type=\"hidden\" value=\"".stripslashes($_post_value)."\" />";
				}
			}
		}
	}
	if($startRow_retorno > 0) 
		echo "<input name=\"startRow_retorno\" type=\"hidden\" value=\"".$startRow_retorno."\" />";	
}
?>