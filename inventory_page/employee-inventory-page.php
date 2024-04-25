<?php include("../navbar.html"); ?>
<style>
<?php include 'employee-inventory-page.css'; ?>
</style>

<!DOCTYPE HTML>
<html lang="en">
    <link rel="stylesheet" href="../navbar.css">
    <?php include 'inventory-page-helper.php'; ?>
    
    <body>
        <form style="padding-left: 11%; padding-bottom: 10px; padding-top: 10px" method="post">
            <input type="text" class="searchbar" name="searchbar">
            <input type="submit" value="Search"/>  
        </form>
        <?php echo $tester; ?>
        <div style="padding-left: 11%">
            <form method="post">
                <input type="submit" name="all" value="ALL" />
                <input type="submit" name="fruit" value="FRUIT" />
                <input type="submit" name="vegetable" value="VEGETABLE" />
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
        <input type="hidden" name="filter" value="<?php echo $type; ?>"/>
        <div class="adder">
            <p>Enter information to add</p>
            <form method="post">
                <select name="addType">
                    <option value="1">Fruit</option>
                    <option value="2">Vegetable</option>
                </select>
                <input type="text" name="addProduct" placeholder="Enter product"/>
                <input type="text" name="addBrand" placeholder="Enter brand"/>
                <input type="text" name="addPrice" placeholder="Enter price"/>
                <input type="text" name="addWeight" placeholder="Enter weight"/>
                <input type="text" name="addQuantity" placeholder="Enter quantity"/>
                <input type="submit" style="background-color: white" name="add" value="Add"/>
            </form>
        </div>
        <div style="padding-left: 11%">
            <?php echo $allItems; ?>
        </div>
        <input type='hidden' name='sort' value='<?php echo $sort; ?>'/>
    </body>
</html>