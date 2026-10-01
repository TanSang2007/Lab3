<?php
require('../model/database.php');
require('../model/product_db.php');
require('../model/category_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_products';
    }
}  

if ($action == 'list_products') {
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id == NULL || $category_id == FALSE) {
        $category_id = 1;
    }
    $categories = get_categories();
    $category_name = get_category_name($category_id);
    $products = get_products_by_category($category_id);
    include('product_list.php');

} else if ($action == 'view_product') {
    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);   
    if ($product_id == NULL || $product_id == FALSE) {
        $error = 'Missing or incorrect product id.';
        include('../errors/error.php');
    } else {
        $categories = get_categories();
        $product = get_product($product_id);

        $code = $product['productCode'];
        $name = $product['productName'];
        $list_price = $product['listPrice'];

        $discount_percent = 30;
        $discount_amount = round($list_price * ($discount_percent/100.0), 2);
        $unit_price = $list_price - $discount_amount;

        $discount_amount_f = number_format($discount_amount, 2);
        $unit_price_f = number_format($unit_price, 2);

        $image_filename = '../images/' . $code . '.png';
        $image_alt = 'Image: ' . $code . '.png';

        include('product_view.php');
    }

// --- CÁC CHỨC NĂNG QUẢN LÝ DANH MỤC ---

} else if ($action == 'list_categories') {
    $categories = get_categories();
    include('category_list.php');

} else if ($action == 'delete_category') {
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id == NULL || $category_id == FALSE) {
        $error = 'Missing or incorrect category id.';
        include('../errors/error.php');
    } else {
        delete_category($category_id);
        header('Location: .?action=list_categories'); 
    }

} else if ($action == 'add_category') {
    $name = filter_input(INPUT_POST, 'name');
    if ($name == NULL || $name == FALSE) {
        $error = 'Invalid category name. Check all fields and try again.';
        include('../errors/error.php');
    } else {
        add_category($name);
        header('Location: .?action=list_categories');
    }

} else if ($action == 'show_edit_form') {
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id == NULL || $category_id == FALSE) {
        $error = 'Missing or incorrect category id.';
        include('../errors/error.php');
    } else {
        $category = get_category($category_id);
        include('category_edit.php');
    }

} else if ($action == 'update_category') {
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name');

    if ($category_id == NULL || $category_id == FALSE || $name == NULL || $name == FALSE) {
        $error = 'Invalid category data. Check all fields and try again.';
        include('../errors/error.php');
    } else {
        update_category($category_id, $name);
        header('Location: .?action=list_categories'); 
    }
}
?>