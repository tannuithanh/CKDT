const button = document.createElement('button');
button.textContent = 'Greet me!'
document.body.insertAdjacentElement('afterbegin', button);
button.addEventListener('click', () => {
    const promise = new Promise((resolve, reject) => {
        const url = 'http://localhost/API/Controller/Question/Read.php?id=1711032';
        $.getJSON(url, data => {
            resolve(data);
        });
    });

//and then later

    promise.then(data => {
        alert(data)
    });
});