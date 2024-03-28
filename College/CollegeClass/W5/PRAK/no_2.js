const myText = document.getElementById("myText");
const ubahTextButton = document.getElementById("ubahText");

ubahTextButton.addEventListener("click", () => {
    const teksBaru = generateRandomText();
    myText.textContent = teksBaru;
});

function generateRandomText() {
    const kataKata = ["Halo", "Selamat datang", "Bagaimana kabarmu?", "Senang bertemu denganmu"];
    return kataKata[Math.floor(Math.random() * kataKata.length)];
}
