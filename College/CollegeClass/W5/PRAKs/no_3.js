const anggotaAwal = ["Andi", "Budi", "Cici", "Doni"];
console.log("Anggota awal:", anggotaAwal);
anggotaAwal.splice(2, 0, "Eko", "Fitri");
console.log("Anggota setelah penambahan:", anggotaAwal);
const anggotaList = document.getElementById("anggota-list");