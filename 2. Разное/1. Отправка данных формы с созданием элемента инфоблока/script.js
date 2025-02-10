fetch(form.action, {
    method: 'POST',
    body: new FormData(form)
}).then(response => response.json()).then((data) => {
    console.log(this);
    console.log(data);
});