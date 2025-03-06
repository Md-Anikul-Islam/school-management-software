// Select all elements with the class "editor"
const editorElements = document.querySelectorAll(".sdmg_quill_editor");
// Initialize Quill for each editor element
editorElements.forEach((element) => {
    new Quill(element, {
        theme: "snow",
        modules: {
            toolbar: [
                [{ font: [] }, { size: [] }],
                ["bold", "italic", "underline", "strike"],
                [{ color: [] }, { background: [] }],
                [{ script: "super" }, { script: "sub" }],
                [{ header: [!1, 1, 2, 3, 4, 5, 6] }, "blockquote", "code-block"],
                [{ list: "ordered" }, { list: "bullet" }, { indent: "-1" }, { indent: "+1" }],
                ["direction", { align: [] }],
                ["link", "image", "video"],
                ["clean"],
            ],
        },
    });
});
