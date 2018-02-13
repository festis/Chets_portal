function hideField() {
    var checkBox = document.getElementById("return");
    var text = document.getElementById("oldPO");
    if (checkBox.checked == true){
        text.style.display = "block";
        text.value=null;
    } else {
       text.style.display = "none";
    }
}