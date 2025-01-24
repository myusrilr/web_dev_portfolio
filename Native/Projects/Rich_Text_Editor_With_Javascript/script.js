let optionsButtons = document.querySelectorAll(".option-button");
let advancedOptionButtons = document.querySelectorAll(".adv-option-button");
let fontName = document.getElementById("fontName");
let fontSizeRef = document.getElementById("fontSize");
let writingArea = document.getElementById("text-input");
let linkButton = document.getElementById("createLink");
let alignButtons = document.querySelectorAll(".align");
let spacingButtons = document.querySelectorAll(".spacing");
let formatButtons = document.querySelectorAll(".format");
let scriptButtons = document.querySelectorAll(".script");

// Daftar Fonts
let fontLists = [
    "Arial", "Verdana", "Times New Roman", "Garamond", "Georgia", "Courier New", "Cursive"
];

// Pengaturan awal
const initializer = () => {
    // Fungsi ini hanya memanggil tombol sorotan
    hightlighter(alignButtons, true);
    hightlighter(spacingButtons, true);
    hightlighter(formatButtons, false);
    hightlighter(scriptButtons, true);

    // Membuat pilihan untuk font names
    fontLists.map((value) => {
        let option = document.createElement("option");
        option.value = value;
        option.innerHTML = value;
        fontName.appendChild(option);
    });
};

// Ukuran font hingga 7
for (let i = 1; i <= 7; i++) {
    let option = document.createElement("option");
    option.value = i;
    option.innerHTML = i;
    fontSizeRef.appendChild(option);
}

// Set ukuran font awal
fontSizeRef.value = 3;

// Logika Utama
const modifyText = (command, defaultUi, value) => {
    document.execCommand(command, defaultUi, value);
};

// Untuk operasi dasar tanpa parameter nilai
optionsButtons.forEach((button) => {
    button.addEventListener("click", () => {
        modifyText(button.id, false, null);
    });
});

// Untuk operasi yang membutuhkan nilai (misal warna, font)
advancedOptionButtons.forEach((button) => {
    button.addEventListener("change", () => {
        modifyText(button.id, false, button.value);
    });
});

// Tautan
linkButton.addEventListener("click", () => {
    let userLink = prompt("Enter a URL");
    if (/http/i.test(userLink)) {
        modifyText(linkButton.id, false, userLink);
    } else {
        userLink = "http://" + userLink;
        modifyText(linkButton.id, false, userLink);
    }
});

// Fungsi untuk menyoroti tombol yang diklik
const hightlighter = (className, needsRemoval) => {
    className.forEach((button) => {
        button.addEventListener("click", () => {
            if (needsRemoval) {
                let alreadyActive = false;
                if (button.classList.contains("active")) {
                    alreadyActive = true;
                }
                hightlighterRemover(className);
                if (!alreadyActive) {
                    button.classList.add("active");
                }
            } else {
                button.classList.toggle("active");
            }
        });
    });
};

// Fungsi untuk menghapus sorotan
const hightlighterRemover = (className) => {
    className.forEach((button) => {
        button.classList.remove("active");
    });
};

window.onload = initializer();
