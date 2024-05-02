<?php include("../navbar/navbar.php"); ?>
<style>
<?php include 'employee-inventory-page.css'; ?>
</style>

<script src="employee-inventory-page.js"></script>

<!DOCTYPE HTML>
<html lang="en">
    <link rel="stylesheet" href="../../navbar.css">
    <?php include 'inventory-page-helper.php'; ?>
    
    <body>
        <div class="actualBody">
            <div class="header">
                <h1>INVENTORY</h1>
            </div>
            <a class="button-popup" href="#popupstart">Add Item</a>
            <form name="searchForm" class="searchbar" method="post">
                <input type="text" class="searchbar-txt" id="searchbar" name="searchbar" 
                        placeholder="Search for Product/Brand" list="searchlist" oninput="showBtnFunc()"/>
                <datalist id="searchlist">
                </datalist>
                <input type="submit" class="searchbar-btn" value="Search"/>
            </form>
            <?php echo $tester; ?>
            <div style="padding-left: 11%">
                <form method="post">
                    <input type="submit" id="all" class="filter" name="all" value="ALL"/>
                    <input type="submit" id="fruit"  class="filter" name="fruit" value="FRUIT"/>
                    <input type="submit" id="vegetable"  class="filter" name="vegetable" value="VEGETABLE"/>
                </form>
            </div>
            <div class="part2">
                <p id="counter"><?php echo $counterString; ?></p>
                <div class="dropdown">
                    <button class="dropbtn">Sort By: <?php echo $sort ?></button>
                    <form class="dropdown-content" id="sort-by-items" method="post">
                        <input type="submit" class="searchbar"  name="az" value="A-Z"/>
                        <input type="submit" class="searchbar"  name="za" value="Z-A"/>
                        <input type="submit" class="searchbar"  name="inStock" value="In Stock"/>
                        <input type="hidden" name="filter" value="<?php echo $type; ?>"/>
                    </form>
                </div>
            </div>
            <div style="position: relative; top: 200px; padding-left: 11%">
                <div class="item-holder">
                    <?php echo $allItems; ?>
                </div>
            </div>
            <input type='hidden' name='sort' value='<?php echo $sort; ?>'/>
            <div id="popupstart" class="overlay">
                <div class="popup">
                    <h2>Add item information</h2>
                    <a class="close" href="#">×</a>
                    <div class="content">
                        <form method="post">
                            <div class="add-item-gen">
                                <label for="addImage">Select image (.jpg or .png with 1:1 resolution):&nbsp</label>
                                <input type="file" name="addImage" accept=".jpg, .png">
                            </div>
                            <div class="add-item-gen">
                                <label for="addType">Enter Type:&nbsp</label>
                                <select name="addType">
                                    <option value="1">Fruit</option>
                                    <option value="2">Vegetable</option>
                                </select>
                            </div>
                            <div class="add-item-gen">
                                <label for="addProduct">Enter Product:&nbsp</label>
                                <input type="text" name="addProduct" placeholder="Ex: Apple"/>
                            </div>
                            <div class="add-item-gen">
                                <label for="addBrand">Enter Brand:&nbsp</label>
                                <input type="text" name="addBrand" placeholder="Ex: Fuji"/>
                            </div>
                            <div class="add-item-gen">
                            <label for="addPrice">Enter Price:&nbsp</label>
                                <input type="text" name="addPrice" placeholder="Ex: 1 or 0.99"/>
                            </div>
                            <div class="add-item-gen">
                            <label for="addWeight">Enter Weight:&nbsp</label>
                                <input type="text" name="addWeight" placeholder="Ex: 1 or 0.99"/>
                            </div>
                            <div class="add-item-gen">
                            <label for="addQuantity">Enter Quantity:&nbsp</label>
                                <input type="text" name="addQuantity" placeholder="Ex: 1 or 2"/>
                            </div>
                            <input type="submit" class="searchbar" style="background-color: white" name="add" value="Add"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>