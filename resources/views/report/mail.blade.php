<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Disposisi Document</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    .container {
        border: 1px solid #000;
    }
    .header, .footer {
        display: flex;
        justify-content: space-between;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    td, th {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
        padding: 5px;
        text-align: left;
        vertical-align: top;
    }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .checkboxes {
    	width:100%;
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .flex{
    	display: flex;
        align-items: center;
    }
    .flex > div{
    	width: 50%;
    }
</style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <p>Indeks: ______</p>
        </div>
        <div>
            <label class="checkbox-label"><input type="checkbox"> Rahasia</label>
            <label class="checkbox-label"><input type="checkbox"> Penting</label>
            <label class="checkbox-label"><input type="checkbox"> Biasa</label>
        </div>
    </div>
    
    <p>Kode: ________ &nbsp;&nbsp; Tanggal Penyelesaian: ________</p>

    <table>
        <tr>
            <td>Tgl / No</td>
            <td>:</td>
            <td>________</td>
        </tr>
        <tr>
            <td>Asal</td>
            <td>:</td>
            <td>________</td>
        </tr>
        <tr>
            <td>Isi Ringkas</td>
            <td>:</td>
            <td>________</td>
        </tr>
    </table>

    <p>Instruksi / Informasi:</p>
    <ol>
        <li>____________________</li>
        <li>____________________</li>
    </ol>

    <p>Diteruskan Kepada:</p>
    <table>
        <tr>
            <td colspan='3'>Setelah digunakan harap segera kembali</td>
        </tr>
        <tr>
            <td>Kepada</td>
            <td>:</td>
            <td>________</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>________</td>
        </tr>
    </table>
    <div class="flex">
      <div class="checkboxes">
          <label class="checkbox-label"><input type="checkbox"> Penting</label>
          <label class="checkbox-label"><input type="checkbox"> Rahasia</label>
          <label class="checkbox-label"><input type="checkbox"> Segera</label>
          <label class="checkbox-label"><input type="checkbox"> Biasa</label>
      </div>
      <div class="checkboxes">
      	<label class="checkbox-label"><input type="checkbox"> Tgl Surat</label>
        <label class="checkbox-label"><input type="checkbox"> No Surat</label>
        <label class="checkbox-label"><input type="checkbox"> Hal (Code)</label>
      </div>
    </div>
    

    <table>
        <tr>
            <td colspan='2'>Tanggal Terima:</td>
        </tr>
        <tr>
            <td>1. Mohon pendapat/saran</td>
            <td>15. Selesaikan sesuai konsep</td>
        </tr>
        <tr>
            <td>2. Mohon petunjuk</td>
            <td>16. Setuju diselesaikan</td>
        </tr>
        <tr>
            <td>3. Mohon keputusan</td>
            <td>17. Untuk diketahui</td>
        </tr>
        <tr>
            <td>4. Untuk perhatian</td>
            <td>18. Untuk diselesaikan</td>
        </tr>
        <tr>
            <td>5. Siapkan konsep</td>
            <td>19. Mohon koreksi konsep</td>
        </tr>
        <!-- Continue filling in rows as necessary -->
    </table>

    <table>
        <tr>
            <th>Tanggal</th>
            <th>Kepada</th>
            <th>No. Disposisi</th>
            <th>Dari</th>
            <th>Paraf</th>
        </tr>
        <tr>
            <td>________</td>
            <td>________</td>
            <td>________</td>
            <td>________</td>
            <td>________</td>
        </tr>
    </table>
</div>

</body>
</html>
