import os
from dotenv import load_dotenv

load_dotenv()

# ─── EXCHANGE RATE API (kurs USD/IDR) ──────────────────────
EXCHANGE_API_KEY = os.getenv("EXCHANGE_API_KEY", "")
EXCHANGE_API_URL = f"https://v6.exchangerate-api.com/v6/{EXCHANGE_API_KEY}/pair/USD/IDR"

# ─── KONSTANTA ANTAM ────────────────────────────────────────
ANTAM_JUAL_MARKUP   = 1.038   # 1.112 (+11.2%) dari harga spot (sesuaikan dengan kondisi pasar) menjadi 1.038
ANTAM_BUYBACK_MARKUP = 0.989 # 1.009 (+0.9%) dari harga spot menjadi 0.989
