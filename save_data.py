import json

DATA_JSON_PATH = "data.json"


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

    with open(DATA_JSON_PATH, "w", encoding="utf-8") as f:
        json.dump(output, f, indent=2, ensure_ascii=False)

    print(f"[save] data.json disimpan: {output}")
