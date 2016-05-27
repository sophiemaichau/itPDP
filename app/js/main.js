(function(){

  var wrapper = document.getElementById("wrapper"),
    width = window.innerWidth,
    height = window.innerHeight;

  wrapper.style.height = height + "px";

  var style = document.createElement('style');
  style.type = 'text/css';
  style.innerHTML = '.personHeight { height: ' + (height - 164) / 2 + 'px }';
  style.innerHTML += '.statThird { height: ' + (height - 115) / 3 + 'px }';
  style.innerHTML += '.statThirdHalf { height: ' + ((height - 180) / 3) / 2 + 'px; }';
  document.getElementsByTagName('head')[0].appendChild(style);



})();
