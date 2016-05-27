(function personHeights(){
  console.log("hallo");
  var personPresentation = document.getElementById("personPresentation"),
    personStats = document.getElementById("personStats"),
    height = window.innerHeight;

  personPresentation.style.height = (height - 164) / 2 + "px";
  personStats.style.height = (height - 164) / 2 + "px";
})(;
