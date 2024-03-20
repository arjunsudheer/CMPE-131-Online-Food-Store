
function MyFunc(){
    fetch('itemDB.csv')
        .then(response => response.text())
        .then(text => console.log(text))
}