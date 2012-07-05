window.onload = init; 
function init() {
   var button = document.getElementById("Button");
   button.onclick = handleButtonClick;
}	

function handleButtonClick() {
   alert("Button was clicked");
}