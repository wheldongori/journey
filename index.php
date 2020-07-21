<?php

// include database and object files
include_once 'config/database.php';
include_once 'config/core.php';
include_once 'objects/product.php';
include_once 'objects/category.php';


//get db connection
$db = Database::getDbInstance();

$db = $db->dbConn();

//pass connection to objects
$product = new Product($db);
$category = new Category($db);

//query products
$stmt = $product->readAll($from_record_num,$records_per_page);
$num = $stmt->rowCount();


//set page header
include_once 'layout_header.php';

echo "<div class = 'right-button-margin'>
        <a href = 'create.php' class  = 'btn btn-default pull-right'>Create Product</a>
        </div>
    </div>";

//footer
include_once 'layout_footer.php';



