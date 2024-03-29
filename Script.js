function filterTable() {
  var filterkelas = $("#filterkelas").val().toLowerCase();
  var filterkapasitas = $("#filterkapasitas").val().toLowerCase();
  var filterjenis = $("#filterjenis").val().toLowerCase();

  $("#TableJadwal tr").each(function () {
    var namakelasText = $(this).find("td:nth-child(1)").text().toLowerCase();
    var kapasitasText = $(this).find("td:nth-child(4)").text().toLowerCase();
    var namaText = $(this).find("td:nth-child(5)").text().toLowerCase();

    var namakelasMatch =
      filterkelas === "" || namakelasText.includes(filterkelas);
    var kapasitasMatch =
      filterkapasitas === "" || kapasitasText.includes(filterkapasitas);
    var namaMatch = filterjenis === "" || namaText.includes(filterjenis);

    $(this).toggle(namakelasMatch && kapasitasMatch && namaMatch);
  });
}