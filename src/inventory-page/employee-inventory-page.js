
function showBtnFunc()
{
    let searchVal = document.getElementById("searchbar").value;
    let searchVallc = searchVal.toLowerCase();

    const itemList = document.querySelectorAll(".item");
    var counter = 0;

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
            counter++;
        }
    }

    document.getElementById("counter").innerHTML = counter + " Results";
}