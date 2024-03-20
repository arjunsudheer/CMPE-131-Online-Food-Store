
const itemDataBase = [];

class itemClass
{
    constructor(type, product, brand, price, weight, bundle, inStock)
    {
        this.type = type;           // string
        this.product = product;     // string
        this.brand = brand;         // string
        this.price = price;         // double
        this.weight = weight;       // double
        this.bundle = bundle;       // int
        this.inStock = inStock;     // bool
    }
    printToConsole()
    {
        console.log("Type: ", this.type, " Product: ", this.product, " Name/Brand: ", this.brand, " Price: ", this.price, " Weight: ", this.weight, " Bundle: ", this.bundle, " In Stock: ", this.inStock)
    }
}

// Key needs to be refreshed every 10 minutes after use until personal key created (Arjun needs to make it because he is owner of repo)

function MyFunc(){
    fetch('https://raw.githubusercontent.com/arjunsudheer/CMPE-131-Online-Food-Store/feature/item-database/item_database/itemDB.csv?token=GHSAT0AAAAAACOHYAV3Q5TZRWTG3CJQTLUIZP3HMWA')
        .then(response => response.text())
        .then(text => createItem(text))
}

function createItem(line)
{
    var commaCount = 12;
    let temp = "";

    for (var i = 0; i < line.length; i++)
    {
        if (commaCount <= 0)
        {
            addToDB(temp);
            commaCount = 12;
            temp = "";
        }
        else
        {
            temp += line[i];
            if (line[i] == ',')
                commaCount--;
        }
    }
}

function addToDB(line)
{
    var commaCount = 8;
    let temp = "";
    let type;
    let product;
    let brand;
    let price;
    let weight;
    let bundle;
    let inStock;
    
    for (var i = 0; i < line.length; i++)
    {
        if (commaCount <= 0)
        {
            const newClass = new itemClass(type, product, brand, price, weight, bundle, inStock);
            itemDataBase.push(newClass);
            newClass.printToConsole();
        }
        else
        {
            if (line[i] == ',')
            {
                switch(commaCount)
                {
                    case (7):
                        type = temp;
                        break;
                    case (6):
                        product = temp;
                        break;
                    case (5):
                        brand = temp;
                        break;
                    case (4):
                        price = temp;
                        break;
                    case (3):
                        weight = temp;
                        break;
                    case (2):
                        bundle = temp;
                        break;
                    case (1):
                        inStock = temp;
                        break;
                }
                temp = "";
                commaCount--;
            }
            else
                temp += line[i];
        }
    }
}
