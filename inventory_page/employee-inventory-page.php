<?php include("../navbar/navbar.html"); ?>
<style>
<?php include 'employee-inventory-page.css'; ?>
</style>


<!DOCTYPE HTML>
<html lang="en">
    <link rel="stylesheet" href="../navbar/navbar.css">
    <?php include 'inventory-page-helper.php'; ?>
    <body>
        <form style="padding-left: 11%; padding-bottom: 10px;" method="post">
            <input type="text" class="searchbar" name="searchbar">
            <input type="submit" value="Search"/>  
        </form>
        <?php echo $tester; ?>
        <div style="padding-left: 11%">
        <!--
            <button name="addToPage">Fruits</button>
            <button>Vegetables</button>
            <button style="float:right">Add Item</button> 
        !-->
        <form method="post">
            <input type="submit" name="all" value="all" />
            <input type="submit" name="fruit" value="fruit" />
            <input type="submit" name="vegetable" value="vegetable" />
        </form>
        </div>
        <div style="padding-left: 11%">
            <?php echo $counterString; ?>
            <div class="dropdown" style="float:right; margin-top: 15px">
                <button class="dropbtn">Sort By</button>
                <form class="dropdown-content" method="post">
                    <input type="submit" name="az" value="A-Z"/>
                    <input type="submit" name="za" value="Z-A"/>
                    <input type="submit" name="inStock" value="In Stock"/>
                </div>
            </div>
        </div>
        <div style="padding-left: 11%">
            <?php echo $allItems; ?>
        </div>
        <input type="hidden" name="filter" value="<?php echo $type; ?>">
    </body>
</html>