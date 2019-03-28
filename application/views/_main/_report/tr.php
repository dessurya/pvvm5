<div style="width: 300px; padding: 15px">
  <form action="aksi_tambah.php" method="post">
    <div class="form-group">
      <label>Agent</label>
      <select id="kota" name="kota" class="form-control">
        <option value=""></option>
        <?php
          // ambil data dari database
          // $query = "SELECT * FROM provinsi ORDER BY provinsi";
          // $hasil = mysqli_query($link, $query);
          // while ($row = mysqli_fetch_array($hasil)) {
          foreach ($list_agent as $key ) {
        ?>
        <option value="<?php echo $key['NAMA_PERUSAHAAN'] ?>"><?php echo $key['NAMA_PERUSAHAAN'] ?></option>
        <?php
          }
        ?>
    </select>
  </div>
<div class="form-group">
  <input type="submit" value="Simpan" class="btn btn-primary">
</div>
</form>
</div>
<script>
  $(document).ready(function () {
    $("#kota").select2({
      placeholder: "Please Select"
    });

    $("#kota2").select2({
      placeholder: "Please Select"
    });
  });
</script>