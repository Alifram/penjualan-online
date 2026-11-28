# Dokumentasi API Evaluasi Individu

## Admin Product Stock API

Endpoint untuk mengambil informasi stok produk. Endpoint hanya dapat diakses oleh pengguna dengan role admin.

### 1. Method dan URL

- Method: GET
- URL: /api/v1/admin/products/{product}/stock

Contoh:
GET /api/v1/admin/products/1/stock

### 2. Authorization

Menggunakan Laravel Sanctum Bearer Token.

Header:
Authorization: Bearer {admin_token}
Accept: application/json

Hanya pengguna dengan role admin yang diperbolehkan mengakses endpoint.

### 3. Request Body

Tidak memerlukan request body karena menggunakan method GET.

### 4. Response Sukses

HTTP 200 OK

{
  "message": "Stok produk berhasil diambil.",
  "data": {
    "id": 1,
    "sku": "ELK-PROD-001",
    "name": "Mouse Wireless Production",
    "stock": 8
  }
}

### 5. Response Error

#### HTTP 401 Unauthorized

Token tidak tersedia atau tidak valid.

{
  "message": "Unauthenticated."
}

#### HTTP 403 Forbidden

Pengguna berhasil login tetapi bukan admin.

{
  "message": "Anda tidak memiliki hak akses."
}

#### HTTP 404 Not Found

Produk dengan ID yang diminta tidak ditemukan.

{
  "message": "Not Found"
}

### 6. Automated Testing

Pengujian dilakukan melalui ProductStockApiTest.

- Admin berhasil melihat stok produk: 200 OK.
- Customer ditolak saat melihat stok produk: 403 Forbidden.

Hasil pengujian:
2 tests passed (7 assertions).
