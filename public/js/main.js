function togglePassword() {
    console.log("Asd")
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}

document.addEventListener('DOMContentLoaded', function () {
    const flash = document.getElementById('success-flash');

    if (flash) {
        flashSuccess();
    }
});

function flashSuccess() {
    setTimeout(() => {
        document.getElementById('success-flash')?.remove();
    }, 3000);
}

const btnDelete = document.getElementById("btn-delete");
const deletePopup = document.getElementById("delete-popup");
const deleteCancel = document.getElementById("delete-cancel");
const inputAnggotaKas = document.getElementById("input-anggota-kas");

function showDeletePopup(id, el, path) {
    console.log(path)
    deletePopup.classList.remove("hidden")
    btnDelete.addEventListener("click", () => {
        let url = `${path}/${id}`
        deleteLoading(url)
    })
}

function closeDeletePopup() {
    deletePopup.classList.add("hidden")
}

function deleteLoading(url) {
    window.location.replace(url);
}

function showInputAnggotaKas() {
    inputAnggotaKas.classList.remove("hidden")
}

function hideInputAnggotaKas() {
    inputAnggotaKas.classList.add("hidden")
}
