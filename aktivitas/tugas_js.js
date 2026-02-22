let nama = prompt("Tuliskan nama Kamu");

if (nama !== null && nama !== "") {

    document.getElementById("hasilNama").innerHTML =
        "<b>Nama saya " + nama +
        ", saya akan mengamalkan Pancasila dan UUD 1945 sebagai Dasar Negara.</b>";

} else {
    alert("Nama tidak boleh kosong!");
}