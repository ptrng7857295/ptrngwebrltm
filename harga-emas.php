<?php
// ─────────────────────────────────────────────────────────────
// GANTI URL INI dengan raw URL data.json dari repo GitHub kamu
// Format: https://raw.githubusercontent.com/USERNAME/REPO/main/data.json
// ─────────────────────────────────────────────────────────────
$GITHUB_DATA_URL = "https://raw.githubusercontent.com/USERNAME/REPO/main/data.json";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Harga Emas Realtime - BrankasEmas</title>
<style>
  :root {
    --bg: #0d1117;
    --card-bg: #161b22;
    --white: #ffffff;
    --gray: #8b949e;
    --green: #2ecc71;
    --red: #e74c3c;
    --yellow: #f1c40f;
    --accent: #f0b90b;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    background: var(--bg);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
  }

  .card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 28px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.4);
  }

  .row-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 8px;
  }

  .usd-price { font-size: 22px; font-weight: 700; }
  .pct-change { font-size: 16px; font-weight: 600; margin-left: 8px; }
  .idr-gram { font-size: 20px; font-weight: 700; }

  .box-center {
    background: rgba(255,255,255,0.05);
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    margin-bottom: 16px;
  }

  .box-label { font-size: 15px; color: var(--white); margin-bottom: 8px; }
  .box-big { font-size: 42px; font-weight: 800; }

  .row-bottom-boxes { display: flex; gap: 12px; margin-bottom: 18px; }

  .box-small {
    flex: 1;
    background: rgba(255,255,255,0.05);
    border-radius: 14px;
    padding: 16px;
    text-align: center;
  }

  .box-small-label { font-size: 13px; color: var(--white); margin-bottom: 6px; }
  .box-small-value { font-size: 20px; font-weight: 700; }

  .footer-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    color: var(--gray);
    flex-wrap: wrap;
    gap: 6px;
  }

  .loading { text-align: center; color: var(--gray); padding: 40px 0; }
  .arrow-up   { color: var(--green); }
  .arrow-down { color: var(--red); }
</style>
</head>
<body>

<div class="card" id="card">
  <div class="loading" id="loading">Memuat data harga emas...</div>
</div>

<script>
const GITHUB_DATA_URL = "<?= $GITHUB_DATA_URL ?>";

function fmtIDR(value, prefix = "IDR ") {
  const formatted = Math.abs(Math.round(value)).toLocaleString("id-ID");
  return `${prefix}${formatted}`;
}

function fmtRP(value) { return fmtIDR(value, "Rp "); }

function fmtPct(value) {
  const sign = value >= 0 ? "+" : "";
  return `${sign}${value.toFixed(2)}%`;
}

function fmtUSD(value) {
  return `$${value.toLocaleString("en-US", {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
}

async function loadData() {
  try {
    const res = await fetch(GITHUB_DATA_URL + "?t=" + Date.now());
    if (!res.ok) throw new Error("Gagal fetch data");
    const data = await res.json();
    renderCard(data);
  } catch (err) {
    document.getElementById("card").innerHTML =
      `<div class="loading">⚠️ Gagal memuat data. Coba refresh halaman.</div>`;
    console.error(err);
  }
}

function renderCard(data) {
  const isUp = data.change_pct >= 0;
  const colorClass = isUp ? "arrow-up" : "arrow-down";
  const arrow = isUp ? "▲" : "▼";
  const labelEst = isUp ? "Estimasi Kenaikan Harga" : "Estimasi Penurunan Harga";
  const signIdr = data.change_idr >= 0 ? "+" : "-";

  document.getElementById("card").innerHTML = `
    <div class="row-top">
      <div>
        <span class="usd-price">${fmtUSD(data.xauusd_oz)}</span>
        <span class="pct-change ${colorClass}">${arrow} ${fmtPct(data.change_pct)}</span>
      </div>
      <div class="idr-gram">${fmtIDR(data.idr_per_gram)}/gr</div>
    </div>

    <div class="box-center">
      <div class="box-label">${labelEst}</div>
      <div class="box-big ${colorClass}">
        ${arrow} IDR ${signIdr}${Math.abs(Math.round(data.change_idr)).toLocaleString("id-ID")}
      </div>
    </div>

    <div class="row-bottom-boxes">
      <div class="box-small">
        <div class="box-small-label">Estimasi Harga Jual Antam</div>
        <div class="box-small-value" style="color:var(--yellow)">${fmtRP(data.antam_jual)}/gr</div>
      </div>
      <div class="box-small">
        <div class="box-small-label">Estimasi Harga Buyback Antam</div>
        <div class="box-small-value" style="color:var(--accent)">${fmtRP(data.antam_buyback)}/gr</div>
      </div>
    </div>

    <div class="footer-row">
      <span>KURS: ${fmtRP(data.usd_idr)} | ${data.timestamp}</span>
      <span>@brankasemas.idn</span>
    </div>
  `;
}

loadData();
setInterval(loadData, 2 * 60 * 1000);
</script>

</body>
</html>
