const popup = document.getElementById("popup-majority")
const main = document.getElementById("main")
const isMajor = localStorage.getItem("isMajor")
if (!isMajor) {
    displayPopup()

    const isMajorBtn = document.getElementById("is-major-btn")
    isMajorBtn.addEventListener("click", () => {
        localStorage.setItem("isMajor", true)
        displayPage()
    })

    const isNotMajorBtn = document.getElementById("is-not-major-btn")
    isNotMajorBtn.addEventListener("click", () => {
        history.back()
    })
}

function displayPopup() {
    popup.style.display = "block"
    main.style.display = "none"
}

function displayPage() {
    popup.style.display = "none"
    main.style.display = "block"
}