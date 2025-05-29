<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Formula - ProfitEase</title>
  <link rel="stylesheet" href="../../Login-Register/asset/formulastyle.css">
  <link rel="icon" type="image/x-icon" href="../../ProfitEasez/favicon-32x32.png">
</head>
<body class="background">

  <div class="overlay"></div> <!-- darkens bg -->

  <nav>
    <div class="nav-logo">ProfitEase</div>
    <div class="nav-links">
      <a href="../accounts.php">return to accounts</a>
    </div>
  </nav>

  <section class="landing-content">
    <h1>Financial Formula Reference</h1>
    <p>Use these formulas to analyze and calculate financial performance</p>
  </section>

  <section class="about-section">
    <h2 style="color:white;">Key Financial Formulas</h2>

    <div class="tiles">
      <div class="tile">
        <h3>Net Profit</h3>
        <code>Net Profit = Total Revenue - Total Expenses</code>
      </div>
      <div class="tile">
        <h3>Gross Profit</h3>
        <code>Gross Profit = Revenue - COGS</code>
      </div>
      <div class="tile">
        <h3>Operating Profit</h3>
        <code>Operating Profit = Gross Profit - Operating Expenses</code>
      </div>
    </div>

    <div class="tiles">
      <div class="tile">
        <h3>Profit Margin (%)</h3>
        <code>Profit Margin = (Net Profit / Revenue) × 100</code>
      </div>
      <div class="tile">
        <h3>ROI</h3>
        <code>ROI = (Net Profit / Investment Cost) × 100</code>
      </div>
      <div class="tile">
        <h3>Break-even Point</h3>
        <code>Break-even = Fixed Costs / (Price - Variable Cost)</code>
      </div>
    </div>

    <div class="tiles">
      <div class="tile">
        <h3>Current Ratio</h3>
        <code>Current Ratio = Current Assets / Current Liabilities</code>
      </div>
      <div class="tile">
        <h3>Debt to Equity</h3>
        <code>Debt to Equity = Total Liabilities / Equity</code>
      </div>
      <div class="tile">
        <h3>EPS</h3>
        <code>EPS = Net Income / Avg Outstanding Shares</code>
      </div>
    </div>
  </section>

  <footer style="text-align:center; padding:20px; color:white;">
    &copy; <?php echo date("Y"); ?> ProfitEase. All rights reserved.
  </footer>

</body>
</html>
