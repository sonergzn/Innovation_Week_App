let options = [
    ['bold', 'italic', 'underline'],
    [{'list': 'ordered'}, {'list': 'bullet'}],
    [{'indent': '-1'}, {'indent': '+1'}],
    [{'header': [1, 2, 3, 4, 5, 6, false]}],
    [{'color': []}, {'background': []}],
    [{'align': []}],
    ['clean']
];

let editor = new Quill('#editor', {
    modules: {
        toolbar: options,
    },
    theme: 'snow'
});

function sanitize(string) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#x27;',
        "/": '&#x2F;',
    };
    const reg = /[&<>"'/]/ig;
    return string.replace(reg, (match)=>(map[match]));
}

window.onload = () => {
    console.log("Script loading");

    const form = document.getElementById('form');
    const content = document.getElementById('content');

    editor.root.innerHTML = content.value;

    form.onsubmit = (event) => {
        content.value = sanitize(editor.root.innerHTML);
    }
};
