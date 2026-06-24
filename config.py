import os
from dotenv import load_dotenv

load_dotenv()

# ─── EXCHANGE RATE API (kurs USD/IDR) ──────────────────────
EXCHANGE_API_KEY = os.getenv("EXCHANGE_API_KEY", "")
EXCHANGE_API_URL = f"https://v6.exchangerate-api.com/v6/{EXCHANGE_API_KEY}/pair/USD/IDR"

# ─── KONSTANTA ANTAM ────────────────────────────────────────
ANTAM_JUAL_MARKUP    = 1.10    # +10% dari harga spot
ANTAM_BUYBACK_MARKUP = 0.925   # -7.5% dari harga spot
