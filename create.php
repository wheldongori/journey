<?php
session_start();
// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/category.php';

//get db connection
$db = Database::getDbInstance();

$db = $db->dbConn();

//pass connection to objects
$product = new Product($db);
$category = new Category($db);

//set page headers
$page_title = "Create Product";
include_once "layout_header.php";

?>
<!-- PHP post code will be here -->
<?php
 $errors = [];
if($_POST){

    //form Validation
    if(strlen($_POST['name']) <= 0){
        array_push($errors,'Please Insert a name');
    }else{
        
    $_SESSION['name'] =  $_POST['name'];
    $product->name = $_POST['name'];
    }
    if(strlen($_POST['price']) <= 0){
        array_push($errors,'Please Insert a price');
    }else{
    $_SESSION['price'] =  $_POST['price'];    
    $product->price = $_POST['price'];
    }
    if(strlen($_POST['description']) <= 0){
        array_push($errors,'Please Insert a description');
    }else{
    // $_SESSION['description'] =  $_POST['description'];    
    $product->description = $_POST['description'];
    }
    if(!isset($_POST['category_id']) || $_POST['category_id'] == 'Select category...'){
        array_push($errors,'Please choose a category');
    }else{
    // $_SESSION['category_id'] =  $_POST['category_id'];       
    $product->category_id = $_POST['category_id'];
    }

   
    // print_r($product->category_id);
    if($product->create() && !empty($product->name) && !empty($product->price) 
    && !empty($product->description) && isset($product->category_id) && $_POST['category_id'] != 'Select category...'){
        echo "<div class='alert alert-success'>Product was created.</div>";
        
    }
    else{
        array_push($errors,"Unable to create product");
        //print_r($errors);
    }
}
?>
<!-- 'create product' html form will be here -->
 <!-- tables -->
 <section>
      <div class="container-fluid">
        <div class="row mb-5">
          <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
            <div class="row align-items-center">
              <div class="col-xl-6 col-12 mb-4 mb-xl-0">
                <h3 class="text-muted text-center mb-3">Create Product</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <table class="table table-striped bg-light text-center">
                  <thead>
                  <tr>
                  <?php if(in_array('Unable to create product',$errors)) {
                      echo '<div class="alert alert-danger">Unable to create product</div>';
                  }?>
                            <?php
                            if(in_array('Please Insert a name',$errors)){
                                echo '<script>
                                alert("Please Insert a name");
                                </script>';
                            }
                            ?>
                                <td>Name</td>
                                <td><input type='text' name='name' class='form-control' value = "<?php if(isset($_SESSION['name'])){
                                    echo $_SESSION['name'];
                                } ?>" /></td>
                            </tr>
                            
                            <?php
                            if(in_array('Please Insert a price',$errors)){
                                echo '<script>
                                alert("Please Insert a price");
                                </script>';
                            }
                            ?>

                            <tr>
                                <td>Price</td>
                                <td><input type='text' name='price' class='form-control' value = "<?php if(isset($_SESSION['price'])){
                                    echo $_SESSION['price'];
                                } ?>" /></td>
                            </tr>

                            <?php
                            if(in_array('Please Insert a description',$errors)){
                                echo '<script>
                                alert("Please Insert a description");
                                </script>';
                            }
                            ?>
                        

                            <tr>
                                <td>Description</td>
                                <td><textarea name='description' class='form-control'></textarea></td>
                            </tr>
                            
                            <?php
                            if(in_array('Please choose a category',$errors)){
                                echo '<script>
                                alert("Please choose a category");
                                </script>';
                            }
                            ?>
                        
                            <tr>
                                <td>Category</td>
                                <td>
                                <!-- categories from database will be here -->
                                <?php
                                // read the product categories from the database
                                $stmt = $category->read();
                                // put them in a select drop-down
                                echo "<select class='form-control' name='category_id'>";
                                echo "<option>Select category...</option>";
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    extract($row);
                                    
                                    echo "<option value = '{$id}'>{$name}</option>";
                                }
                                // print_r($row);
                                echo "</select>";
                                ?>
                                </td>
                            </tr>
                    
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </td>
                            </tr>
                  
                </table>

<?php

//footer
include_once "layout_footer.php";
