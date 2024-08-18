let form = $('#main form')
let messagesDiv = $('#messages')

form.addEventListener('submit', e => {
    console.log('h)')
    e.preventDefault()
    let oldPasswordInput = $('#old-password')
    let newPasswordInput = $('#new-password')
    let verifyPasswordInput = $('#verify-password')

    let conditions = [
        [newPasswordInput.value.length >= 8 && oldPasswordInput.value.length >= 8, 'Password should be at least 8 characters'],
        [newPasswordInput.value === verifyPasswordInput.value, 'Password doesn\'t match']
    ]

    let errorMessage = ''
    for (let [isFulfilled, message] of conditions) {
        if (!isFulfilled) errorMessage += message + '\n'
    }

    if (errorMessage) {
        messagesDiv.innerText = errorMessage
        messagesDiv.classList.remove('nodisplay')
        return
    } else {
        messagesDiv.classList.add('nodisplay')
    }

    let formData = new FormData(form)

    let req = fetch('/password', {
        method: 'post',
        body: formData
    }).then(d => d.json())
    req.then(d => {
        if (d.status == 'success') {
            location.reload()
        } else {
            messagesDiv.classList.remove('nodisplay')
            messagesDiv.innerText = d.message
        }
    })
})