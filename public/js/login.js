"use strict";

{
//   const checkbox = document.querySelector("#checkbox");
//   checkbox.addEventListener("change", () => {
//     const consented = document.querySelectorAll(".consented");
//     if (checkbox.checked) {
//       consented.forEach(element => {
//         element.disabled = false;
//       });
//     } else {
//       consented.forEach((element) => {
//         element.disabled = true;
//       });
//     }
//   });

  const tabs = document.querySelectorAll(".tabs li a");
  const contents = document.querySelectorAll(".content");
  tabs.forEach((tab) => {
    tab.addEventListener("click", (e) => {
      e.preventDefault();
      tabs.forEach((tab) => {
        tab.classList.remove("active");
      });
      tab.classList.add("active");
      document.querySelector(".consent").classList.toggle("transparent");

      contents.forEach((content) => {
        content.classList.remove("active");
      });
      document.querySelector(`#${tab.dataset.id}`).classList.add("active");
    });
  });
}
