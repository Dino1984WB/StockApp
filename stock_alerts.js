async function sendAlert(phone_number, stock_ticker, threshold) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "send_alert.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  await xhr.send(JSON.stringify({
    phone_number: phone_number,
    stock_ticker: stock_ticker,
    threshold: threshold
  }));
}

const apiKey = process.env.YAHOO_FINANCE_API_KEY;

async function onSubmit() {
  var phone_number = $("#phone_number").val();
  var stock_ticker = $("#stock_ticker").val();
  var threshold = $("#threshold").val();

  if (phone_number && stock_ticker && threshold) {
    const url = `https://finance.yahoo.com/quote/?symbols=${stock_ticker}&format=json&region=US&lang=en-US&apikey=${apiKey}`;

    const response = await fetch(url);
    const data = await response.json();

    const price = data.quoteSummary.price;

    if (price > threshold) {
      await sendAlert(phone_number, stock_ticker, threshold);
    }
  }
}

$(document).ready(function() {
  $("#submit").click(onSubmit);
});
