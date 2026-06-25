import json
import os

DATA_JSON_PATH = "data.json"
HISTORY_JSON_PATH = "history.json"

def save_data_json(data: dict) -> None:
    """
    Simpan data harga ke file data.json di root repo.
    File ini di-fetch oleh halaman web via GitHub raw URL.
    """
    output = {
        "xauusd_oz"     : round(data.get("xauusd_oz", 0), 2),
        "idr_per_gram"  : round(data.get("idr_per_gram", 0)),
        "antam_jual"    : round(data.get("antam_jual", 0)),
        "antam_buyback" : round(data.get("antam_buyback", 0)),
        "change_pct"    : round(data.get("change_pct", 0), 2),
        "change_idr"    : round(data.get("change_idr", 0)),
        "usd_idr"       : round(data.get("usd_idr", 0)),
        "timestamp"     : data.get("timestamp", "")
    }

    # 1. Simpan ke data.json (Kode Asli)
    with open(DATA_JSON_PATH, "w", encoding="utf-8") as f:
        json.dump(output, f, indent=2, ensure_ascii=False)

    print(f"[save] data.json disimpan: {output}")

    # 2. Simpan ke history.json (Tambahan Baru)
    history_list = []
    
    # Baca history lama jika file sudah ada
    if os.path.exists(HISTORY_JSON_PATH):
        try:
            with open(HISTORY_JSON_PATH, "r", encoding="utf-8") as f:
                history_list = json.load(f)
        except json.JSONDecodeError:
            history_list = [] # Reset menjadi array kosong jika file korup/kosong

    # Masukkan data terbaru di posisi paling atas (index 0)
    history_list.insert(0, output)

    # Batasi array agar maksimal hanya berisi 20 record
    history_list = history_list[:20]

    # Simpan kembali ke history.json
    with open(HISTORY_JSON_PATH, "w", encoding="utf-8") as f:
        json.dump(history_list, f, indent=2, ensure_ascii=False)
        
    print(f"[save] history.json diupdate (Total: {len(history_list)} record)")
