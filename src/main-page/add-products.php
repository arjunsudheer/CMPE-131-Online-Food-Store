<?php

namespace Arjunsudheer\Cmpe131OnlineFoodStore;

// handles the XMLHTTPRequest from main-page.js
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $filter = json_decode($_POST['name']);
    if (isset($filter) && !empty($filter)) {
        // set the item_added count to 0
        $temp = new AddProductItems(4, $filter);
        $temp->openDatabaseConnection();
        $temp->addProductItems();
        $temp->closeDatabaseConnection();
    }
}

class AddProductItems
{
    // database connection
    private object $connection;
    // keeps track of the number of items added
    private int $itemsAdded;
    // keeps track of how many products are displayed per row
    private int $numProductsPerRow;
    // keeps track of the filter used for the SQL query construction
    private array $productFilter;

    public function __construct($productsPerRow, $filter = [])
    {
        $this->itemsAdded = 0;
        $this->productFilter = $filter;
        $this->numProductsPerRow = $productsPerRow;
    }

    public function openDatabaseConnection(): void
    {
        // establish connection to database
        $this->connection = mysqli_connect("localhost", "root", "", "ofs");
        // check connection to database
        if (!$this->connection) {
            echo 'error';
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function closeDatabaseConnection(): void
    {
        // close the database connection
        mysqli_close($this->connection);
    }

    public function createQuery(): string
    {
        // get all the product items if no productFilter is specified
        $sql_get_item = "SELECT * FROM items";
        // get all product items where the Type of the product is productFilter
        if (!empty($this->productFilter)) {
            $sql_get_item .= " WHERE ";
            // display all product items for each filter
            for ($i = 1; $i < count($this->productFilter) - 1; $i++) {
                if ($i !== 1) {
                    $sql_get_item .= " OR ";
                }
                $sql_get_item .= "Type='" . $this->productFilter[$i] . "'";
                // if the first array element is a non-empty string, then filter by the search result too
                if ($this->productFilter[0] !== "") {
                    $sql_get_item .= " AND (Product LIKE '%" . $this->productFilter[0] . "%' OR Brand LIKE '%" . $this->productFilter[0] . "%')";
                }
            }
            switch ($this->productFilter[count($this->productFilter) - 1]) {
                case "name":
                    $sql_get_item .= " ORDER BY Product ASC";
                    break;
                case "weight":
                    $sql_get_item .= " ORDER BY Weight ASC";
                    break;
                case "price":
                    $sql_get_item .= " ORDER BY Price ASC";
                    break;
            }
        }
        return $sql_get_item;
    }

    public function executeQuery($queryString): object
    {
        // query the database
        return mysqli_query($this->connection, $queryString);
    }

    public function displayProductItems($product_item): void
    {
        while ($row = mysqli_fetch_assoc($product_item)) {
            // start a new row every 4 product items
            if ($this->itemsAdded % $this->numProductsPerRow == 0) {
                echo '<div class="product-item-row">';
            }
            // create a new product item div on the main page
            $product_type = $row["Type"];
            $product_name = $row["Product"];
            $product_brand = $row["Brand"];
            $product_price = $row["Price"];
            $product_weight = $row["Weight"];
            $product_image = "../inventory/OFS_Binary/" . $row["Image"];
            echo ("
                <div class=\"product-item $product_type\">
                    <p>$product_name</p>
                    <p><span class=\"brand-name\">Brand:</span> $product_brand</p>
                    <img src=\"$product_image\" alt=\"product-item\" class=\"product-image\">
                    <div class=\"price-and-add\">
                        <p>$$product_price</p>
                        <form method='post' action='../main-page/add-to-cart.php?product_name=$product_name&product_brand=$product_brand&product_price=$product_price&product_weight=$product_weight'>
                          <button type='submit' name='add_to_cart' id='addToCartButton'>Add to Cart</button>
                        </form>
                    </div>
                </div>
            ");

            //<a href='../main-page/add-to-cart.php'><button type='submit' name='add-to-cart' id='add-to-cart'>Add</button></a>
            $this->itemsAdded++;
            // check if the current product row should be ended
            if (($this->itemsAdded) % $this->numProductsPerRow == 0) {
                echo '</div>';
            }
        }
        // check if an closing div tag needs to be added (when last row has less than 4 product items)
        if (($this->itemsAdded) % $this->numProductsPerRow != 0) {
            echo '</div>';
        }
    }

    // adds product items by querying database
    public function addProductItems(): void
    {
        // query the database
        $product_item = $this->executeQuery($this->createQuery());
        // display the product items on the webpage
        if ($product_item) {
            $this->displayProductItems($product_item);
        } else {
            echo mysqli_error($this->connection);
        }
    }
}
