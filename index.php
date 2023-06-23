<!DOCTYPE html>
<html>
<head>
<title>Stock Alerts</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Stock Ticker</h1>
<p>Enter your phone number and the stock ticker symbol to receive alerts when the stock price reaches a certain threshold.</p>
<form action="index.php" method="post">
<input type="text" name="phone_number" placeholder="Phone Number">
<input type="text" name="stock_ticker" placeholder="Stock Ticker Symbol">
<input type="text" name="threshold" placeholder="Threshold">
<input type="submit" value="Submit">
</form>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $phone_number = $_POST["phone_number"];
  $stock_ticker = $_POST["stock_ticker"];
  $threshold = $_POST["threshold"];

  if ($phone_number && $stock_ticker && $threshold) {
    $url = `https://finance.yahoo.com/quote/?symbols=${stock_ticker}&format=json&region=US&lang=en-US&apikey=${apiKey}`;

    $response = file_get_contents($url);
    $data = json_decode($response);

    $price = $data->quoteSummary->price;

    if ($price > $threshold) {
      $message = `Welcome to William's Stock Ticker! The stock ${stock_ticker} is currently at ${price}. STOP to stop texts.`;
      send_sms($phone_number, $message);
    }

    const setInterval = setInterval(async () => {
      const url = `https://finance.yahoo.com/quote/?symbols=${stock_ticker}&format=json&region=US&lang=en-US&apikey=${apiKey}`;

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

function send_sms($phone_number, $message) {
  $url = "https://api.twilio.com/2010-04-01/Accounts/ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX/Messages.json";
  $data = {
    "From": "YOUR_PHONE_NUMBER",
    "To": $phone_number,
    "Body": $message
  };

  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $response = curl_exec($curl);
  curl_close($curl);
}

?>
