
function showBtnFunc()
{
    let searchVal = document.getElementById("searchbar").value;
    let searchVallc = searchVal.toLowerCase();

    const itemList = document.querySelectorAll(".item");
    var counter = 0;

    var list = [];

    for (let i = 0; i < itemList.length; i++)
    {
        //window.alert(itemList[i].id);

        let temp = itemList[i].id;

        let templc = temp.toLowerCase();

        let result = templc.includes(searchVallc);

        if (!result)
        {
            itemList[i].style.display = "none";
        }
        else
        {
            itemList[i].style.display = "initial";
            list[counter] = temp;
            counter++;
        }
    }

    // for (let i = 0; i < list.length; i++)
    // {
    //     const para = document.createElement("option");
    //     para.value = temp;
    //     const node = document.createTextNode(temp);
    //     para.appendChild(node);

    //     const element = document.getElementById("searchlist");
    //     element.appendChild(para);
    // }

    document.getElementById("counter").innerHTML = counter + " Results";
}

// <option value="Lebron">Lebron</option>