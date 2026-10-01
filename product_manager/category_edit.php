<?php include '../view/header.php'; ?>
<main>
    <h1>Edit Category</h1>
    <form action="index.php" method="post" id="edit_category_form">
       
        <input type="hidden" name="action" value="update_category">
        
        <input type="hidden" name="category_id" 
               value="<?php echo $category['categoryID']; ?>">

        <label>Name:</label>
        <input type="text" name="name" 
               value="<?php echo $category['categoryName']; ?>" />
        <br>
        
        <label>&nbsp;</label>
        <input type="submit" value="Save Changes" />
    </form>

    <p><a href="index.php?action=list_categories">View Category List</a></p>
</main>
<?php include '../view/footer.php'; ?>