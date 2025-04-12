function init() {
    getWeather('Aachen', update_temp)
    var timer = setInterval(function () {getWeather('Aachen', update_temp)}, 30000);
}

function getWeather(city, callback) {
  var url = "https://api.openweathermap.org/data/2.5/weather?units=metric&appid=f1624d9fc06da3bc02fb1e0586e4f4b4";
  $.ajax({
    dataType: "jsonp",
    url: url,
    jsonCallback: 'jsonp',
    data: { q: city },
    cache: false,
    success: function (data) {
      if(callback) callback(data.main.temp);
    }
  });
}

function update_temp(value) {
  var string_val = String(value) + '°C'
  if(document.getElementById("temp")) {
    document.getElementById("temp").innerHTML = string_val;
  }
}
