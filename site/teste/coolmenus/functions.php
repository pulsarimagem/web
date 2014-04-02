function create_menu($menu_parent_cat_id,$menu_parent_number,$menu_levels,$i,$a) {

$menuquery=mysql_query("SELECT cat_id, cat_name, cat_link, cat_target FROM categories WHERE cat_parent_id='$menu_parent_cat_id' ORDER BY cat_order ASC");

while($menu = mysql_fetch_array($menuquery,MYSQL_ASSOC)) {

if ($menu_parent_number!=0) {
echo ("oM.makeMenu('m".$i."','m".$menu_parent_number."','".$menu['cat_name']."','".$menu['cat_link']."','".$menu['cat_target']."');\n");
} else {
echo ("oM.makeMenu('m".$i."','','".$menu['cat_name']."','".$menu['cat_link']."','".$menu['cat_target']."');\n");
}

$i++;

if ($a < $menu_levels) {
create_menu($menu['cat_id'],$i-1,$menu_levels,&$i,$a+1);
}

}

}