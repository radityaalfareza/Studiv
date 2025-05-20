<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporkan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#laporModal">
  Laporkan
</button>

<div class="modal fade" id="laporModal" tabindex="-1" aria-labelledby="laporModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="laporModalLabel">Formulir Pelaporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form id="formLaporan">
          <div class="mb-3">
            <label for="kategoriLaporan" class="form-label">Kategori Laporan</label>
            <select class="form-select" id="kategoriLaporan" required>
              <option selected disabled value="">Pilih kategori</option>
              <option value="spam">Spam</option>
              <option value="pelecehan">Pelecehan</option>
              <option value="informasi_salah">Informasi Salah</option>
              <option value="lainnya">Lainnya</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="deskripsiLaporan" class="form-label">Deskripsi Laporan</label>
            <textarea class="form-control" id="deskripsiLaporan" rows="3" placeholder="Jelaskan masalahnya..." required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" form="formLaporan" class="btn btn-primary">Kirim</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
