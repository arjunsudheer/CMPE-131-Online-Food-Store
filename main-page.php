<?php include("navbar.html"); ?>
<?php include("search-bar.html"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <link rel="stylesheet" href="main-page.css">
</head>

<body>
    <!-- Icon Filters -->
    <div id="icon-filters-box" class="main-page-box">
        <div class="icon-filters">
            <p>Fruits</p>
            <i class="fa fa-lemon-o" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Vegetables</p>
            <i class="fa fa-leaf" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Dairy</p>
            <i class="fa fa-tint" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Protein</p>
            <i class="fa fa-cutlery" aria-hidden="true"></i>
        </div>
        <div class="icon-filters">
            <p>Sweets</p>
            <i class="fa fa-birthday-cake" aria-hidden="true"></i>
        </div>
    </div>

    <!-- Number of Results and Sort by -->
    <div id="results-and-sort" class="main-page-box">
        <p id="number-of-results"># of Results</p>
        <select name="sort-menu" id="sort-menu" class="sort-by">
            <option value="sort-by">Sort By:</option>
            <option value="weight">Weight</option>
            <option value="price">Price</option>
        </select>
    </div>

    <!-- Shows the product items -->
    <div id="product-item-view">
        <div id="product-item-row">
            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$1.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>

            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$3.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>

            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$5.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>

            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$7.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>
        </div>
        <div id="product-item-row">
            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$8.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>

            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$10.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>

            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$15.00</p>
                    <button class="add-btn">Add</button>
                </div>
            </div>

            <div class="product-item">
                <img src="#" alt="product-item">
                <div class="price-and-add">
                    <p>$17.00</p>
                    <button type="submit" class="add-btn">Add</button>
                </div>
            </div>
        </div>
    </div>
    <script src="main-page.js"></script>
    <script src="popups.js"></script>
</body>

</html>