function sendAlert(phone_number, stock_ticker, threshold) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "send_alert.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify({
      phone_number: phone_number,
      stock_ticker: stock_ticker,
      threshold: threshold
    }));
  }
  
  $(document).ready(function() {
    $("#submit").click(function() {
      var phone_number = $("#phone_number").val();
      var stock_ticker = $("#stock_ticker").val();
      var threshold = $("#threshold").val();
  
      if (phone_number && stock_ticker && threshold) {
        sendAlert(phone_number, stock_ticker, threshold);
      }
    });
  });
  