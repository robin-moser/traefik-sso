function generate() {
  var hexValues = ["4","5","6","7","8","9","a","b","c","d","e"];
  
  function populate(a) {
    for ( var i = 0; i < 6; i++ ) {
      var x = Math.round( Math.random() * 10 );
      var y = hexValues[x];
      a += y;
    }
    return a;
  }
  
  // var newColor1 = populate('#');
  // var newColor2 = populate('#');
  // var angle = Math.round( Math.random() * 360 );
  // var gradient = "linear-gradient(" + angle + "deg, " + newColor1 + ", " + newColor2 + ")";
  
  // document.body.style.background = gradient;
}

window.onload = generate();
