window.onload = function () {
    let urlParams = new URLSearchParams(window.location.search);
    let flotteParam = urlParams.get('flotte');
  
    if (flotteParam) {
      let flotteData = JSON.parse(decodeURIComponent(flotteParam));
      console.log(flotteData);
    } else {
      console.log('No flotte parameter found in URL.');
    }
  };