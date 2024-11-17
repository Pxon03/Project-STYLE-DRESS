
//ส่วนหัว
const header = document.querySelector("header");
const menu = document.querySelector("#menu-icon");
const navmenu = document.querySelector(".navmenu");

if (header) {
  // ใช้ Throttle เพื่อลดการเรียกฟังก์ชันเมื่อมีการเลื่อนหน้าเว็บ
  let lastScrollY = 0;
  const throttle = (func, limit) => {
    let inThrottle;
    return function () {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  };

  // ฟังก์ชัน toggle sticky class เมื่อมีการเลื่อน
  const onScroll = () => {
    header.classList.toggle("sticky", window.scrollY > 0);
  };

  // เพิ่มการเลื่อนด้วย throttle
  window.addEventListener("scroll", throttle(onScroll, 100));
}

if (menu && navmenu) {
  // ฟังก์ชัน toggle สำหรับเมนู
  menu.onclick = () => {
    menu.classList.toggle("bx-x");
    navmenu.classList.toggle("open");
  };
}


//card

// สำหรับหน้า clothes
let clothesPreviewContainer = document.querySelector('.clothes-list .products-preview');
let clothesPreviewBox = clothesPreviewContainer.querySelectorAll('.preview');

document.querySelectorAll('.clothes-list .products-container .product').forEach(product => {
  product.onclick = () => {
    clothesPreviewContainer.style.display = 'flex';
    let name = product.getAttribute('data-name');
    clothesPreviewBox.forEach(preview => {
      let target = preview.getAttribute('data-target');
      if (name == target) {
        preview.classList.add('active');
      }
    });
  };
});

clothesPreviewBox.forEach(close => {
  close.querySelector('.fa-times').onclick = () => {
    close.classList.remove('active');
    clothesPreviewContainer.style.display = 'none';
  };
});

// สำหรับหน้า accessories
let accessoriesPreviewContainer = document.querySelector('.accessories-list .products-preview');
let accessoriesPreviewBox = accessoriesPreviewContainer.querySelectorAll('.preview');

document.querySelectorAll('.accessories-list .products-container .product').forEach(product => {
  product.onclick = () => {
    accessoriesPreviewContainer.style.display = 'flex';
    let name = product.getAttribute('data-name');
    accessoriesPreviewBox.forEach(preview => {
      let target = preview.getAttribute('data-target');
      if (name == target) {
        preview.classList.add('active');
      }
    });
  };
});

accessoriesPreviewBox.forEach(close => {
  close.querySelector('.fa-times').onclick = () => {
    close.classList.remove('active');
    accessoriesPreviewContainer.style.display = 'none';
  };
});




//slide
var slides = document.querySelectorAll('.slide');
var btns = document.querySelectorAll('.btn');
let currentSlide = 1;

// ฟังก์ชันการเปลี่ยนสไลด์
var manualNav = function (index) {
  // ลบคลาส active จากทุกสไลด์และปุ่ม
  slides.forEach((slide) => slide.classList.remove('active'));
  btns.forEach((btn) => btn.classList.remove('active'));

  // เพิ่มคลาส active ให้กับสไลด์และปุ่มตาม index ที่เลือก
  slides[index].classList.add('active');
  btns[index].classList.add('active');
}

// เพิ่ม event listener ให้กับทุกปุ่ม
btns.forEach((btn, i) => {
  btn.addEventListener("click", () => {
    manualNav(i);
    currentSlide = i;
  });
});


