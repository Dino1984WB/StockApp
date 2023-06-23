<!DOCTYPE html>
<html>
<head>
<title>Stock Alerts</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Stock Ticker</h1>
<p>Enter your phone number and the stock ticker symbol to receive alerts when the stock price reaches a certain threshold.</p>
<form id="tickerForm" action="index.php" method="post">
<input type="text" id="phone_number" name="phone_number" placeholder="Phone Number">
<input type="text" id="stock_ticker" name="stock_ticker" placeholder="Stock Ticker Symbol">
<input type="text" id="threshold" name="threshold" placeholder="Threshold">
<input type="submit" value="Submit">
</form>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="script.js"></script>
</body>
</html>
