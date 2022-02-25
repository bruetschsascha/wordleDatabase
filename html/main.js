
    let body = document.querySelector('body');
    body.addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
    document.querySelector("form").submit();
    }
});

