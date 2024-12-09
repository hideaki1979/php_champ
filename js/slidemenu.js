// ハンバーガーメニュー押下時（スライドメニュー表示・非表示切り替え）
export function slideMenu() {
    // ハンバーガーメニュー、スライドメニュー要素取得
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const slideMenu = document.querySelector(".slide-menu");

    // ハンバーガーメニュー押下時にスライドメニュー表示・非表示切り替え
    hamburgerMenu.addEventListener("click", () => {
        hamburgerMenu.classList.toggle("open");
        slideMenu.classList.toggle("open");
    });
}