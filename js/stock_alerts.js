async function sendAlert(phone_number, stock_ticker, threshold, message) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "send_alert.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");
  await xhr.send(JSON.stringify({
    phone_number: phone_number,
    stock_ticker: stock_ticker,
    threshold: threshold,
    message: message
  }));
}

async function onSubmit() {
  var phone_number = $("#phone_number").val();
  var stock_ticker = $("#stock_ticker").val();
  var threshold = $("#threshold").val();

  if (phone_number && stock_ticker && threshold) {
    const url = `https://finance.yahoo.com/quote/?symbols=${stock_ticker}&format=json&region=US&lang=en-US&apikey=${apiKey}`;

    const response = await fetch(url);
    const data = await response.json();

    const price = data.quoteSummary.price;

    // Send welcome message when user clicks submit.
    let welcomeMsg = `Welcome to William's Stock Ticker! The stock ${stock_ticker} is currently at ${price}. STOP to stop texts.`;
    await sendAlert(phone_number, stock_ticker, threshold, welcomeMsg);

    if (price > threshold) {
      await sendAlert(phone_number, stock_ticker, threshold, `The stock ${stock_ticker} has reached your threshold.`);
    }

    const setInterval = setInterval(async () => {
      const response = await fetch(url);
      const data = await response.json();

      const price = data.quoteSummary.price;

      const summary = data.quoteSummary.summary;

      const text = `${stock_ticker}: ${price}

      ${summary.length > 0 ? summary.slice(0, 80) + "..." : "No additional data available"}`;

      alert(text);
    }, 3600000);
  }
}

$(document).ready(function() {
  $("#submit").click(onSubmit);
});
