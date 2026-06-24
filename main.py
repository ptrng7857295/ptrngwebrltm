"""
main.py — Jalankan pipeline:
  1. Fetch harga XAUUSD + kurs IDR
  2. Simpan data.json (untuk ditampilkan di web)

Usage:
  python main.py
"""

import traceback
from datetime import datetime

from fetch_price import get_price_data
from save_data    import save_data_json


def run():
    print(f"\n{'='*50}")
    print(f"  EMASWEB — {datetime.now().strftime('%d %b %Y %H:%M:%S')}")
    print(f"{'='*50}")

    # ── STEP 1: Fetch harga ──────────────────────────────────
    print("\n[1/2] Fetching harga...")
    try:
        data = get_price_data()
    except Exception as e:
        print(f"[main] ❌ Gagal fetch harga: {e}")
        traceback.print_exc()
        return False

    if not data or data.get("xauusd_oz", 0) == 0:
        print("[main] ❌ Data harga kosong, skip cycle ini.")
        return False

    # ── STEP 2: Simpan data.json untuk website ───────────────
    print("\n[2/2] Simpan data.json...")
    try:
        save_data_json(data)
        print("[main] ✅ Selesai! data.json sudah diupdate.")
        return True
    except Exception as e:
        print(f"[main] ❌ Gagal simpan data.json: {e}")
        traceback.print_exc()
        return False


if __name__ == "__main__":
    run()
