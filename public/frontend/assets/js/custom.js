"use strict";

//prealoader 
window.addEventListener("load", function(){
    var preload = document.querySelector(".preloader");
    preload?.classList.add("finish");
});


window?.addEventListener("scroll", function() {
    const headerElement = document?.querySelector(".header-part");
    const windowScroll = this?.scrollY;

    if(windowScroll > 0) headerElement?.classList?.add("active");
    else headerElement?.classList?.remove("active");
});


function headerNavigation() {
    const headerMenu = document?.querySelector(".header-menu");
    const headerNav = document?.querySelector(".header-nav");
    const headerNavClose = document?.querySelector(".header-nav-close");
    const headerNavList = document?.querySelector(".header-nav-list");
    let isOpen = false

    const openFunc = () => {
        headerNav?.classList?.add("active");
        headerNavList?.classList?.add("active");
        headerMenu?.classList?.replace('lni-menu', 'lni-close');
    }

    const closeFunc = () => {
        headerNav?.classList?.remove("active");
        headerNavList?.classList?.remove("active");
        headerMenu?.classList?.replace('lni-close', 'lni-menu');
    }

    headerMenu?.addEventListener("click", function() {
        isOpen = !isOpen

        if(isOpen) openFunc();
        else closeFunc();
    })

    headerNavClose?.addEventListener("click", function() {
        isOpen = !isOpen
        closeFunc();
    })
}
headerNavigation();


function inputFile() {
    const formFileGroup = document?.querySelectorAll(".form-file-group");

    formFileGroup?.forEach((groupItem) => {
        const formControl = groupItem?.querySelector(".form-control");
        const formClose = groupItem?.querySelector(".form-close");
        const formValue = groupItem?.querySelector(".form-value");
        const formFile = groupItem?.querySelector(".form-file");

        formControl?.addEventListener("change", function(event) {
            formValue.textContent = event.target.files[0].name;
            formFile.style.opacity = "1";
        })

        formClose?.addEventListener("click", function() {
            formFile.style.opacity = "0";
            formValue.textContent = "";
            formControl.value = '';
        })
    })
}
// function inputFileDocument() {
//     const formDocumentGroup = document?.querySelectorAll(".form-document-group");

//     formDocumentGroup?.forEach((groupItem) => {
//         const formControl = groupItem?.querySelector(".form-control");
//         const formDocumentClose = groupItem?.querySelector(".form-document-close");
//         const formDocumentValue = groupItem?.querySelector(".form-document-value");
//         const formDocumentFile = groupItem?.querySelector(".form-document");

//         formControl?.addEventListener("change", function(event) {
//             formDocumentValue.textContent = event.target.files[0].name;
//             formDocumentFile.style.opacity = "1";
//         })

//         formDocumentClose?.addEventListener("click", function() {
//             formDocumentFile.style.opacity = "0";
//             formDocumentValue.textContent = "";
//             formControl.value = '';
//         })
//     })
// }


inputFile();
// inputFileDocument();


function checkStatus() {
    let targetElm = document?.querySelectorAll(".going-btn");

    targetElm?.forEach((item) => {
        item?.addEventListener("click", function() {
            this.innerHTML = '<i class="fa-solid fa-check"></i>going';
        })
    })
}
checkStatus();