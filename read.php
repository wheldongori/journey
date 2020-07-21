<?php
//import pagination variables
include_once 'config/core.php';

//include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

//get db connection
$db = Database::getDbInstance();
$db = $db->dbConn();

//pass connection to objects
$product = new Product($db);
$category = new Category($db);

$page_title = 'All Products';
include_once 'layout_header.php';

$product->readAll($from_record_num,$records_per_page);

$page_url = 'index.php';

$total_rows = $product->countAll();

include_once 'read_template.php';

include_once 'layout_footer.php';



