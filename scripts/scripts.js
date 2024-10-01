fetch(url, {
    method: "get",
    headers: new Headers({
    "ngrok-skip-browser-warning": "69420",
        }),
    })
    .then((response) => response.json())
    .then((data) => console.log(data))
    .catch((err) => console.log(err));    
