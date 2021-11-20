<?php
   require_once('connection.php');

   function get_product($conn , $term){	
      $query = "SELECT * FROM products WHERE LOWER(product_name) LIKE '%".$term."%' ORDER BY product_name ASC";
      $result = mysqli_query($conn, $query);	
      $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
      return $data;	
   }

   if (isset($_GET['term'])) {
      $getProduct = get_product($conn, $_GET['term']);
      $productList = array();
      foreach($getProduct as $product){
         $productList[] = $product['product_name'];
      }
      echo json_encode($productList);
   }
?>