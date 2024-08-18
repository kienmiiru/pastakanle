let form = $('form')
let messagesDiv = $('#messages')
let button = $('#button')

form.addEventListener('submit', (e) => {
    e.preventDefault()
    let usernameInput = $('#username')
    let passwordInput = $('#password')
    let verifyPasswordInput = $('#verify-password')

    let conditions = [
        [usernameInput.value.length >= 4, 'Username should be at least 4 characters'],
        [usernameInput.value.length <= 20, 'Username should not be longer than 20 characters'],
        [usernameInput.value.split('').every(d => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_'.includes(d)), 'Username can only contain alphanumeric characters and underscores'],
        [passwordInput.value.length >= 8, 'Password should be at least 8 characters'],
        [passwordInput.value === verifyPasswordInput.value, 'Password doesn\'t match']
    ]

    let errorMessage = ''
    for (let [isFulfilled, message] of conditions) {
        if (!isFulfilled) errorMessage += message + '\n'
    }

    if (errorMessage) {
        messagesDiv = $('#messages')
        messagesDiv.innerText = errorMessage
        messagesDiv.classList.remove('nodisplay')
        return
    } else {
        messagesDiv.classList.add('nodisplay')
        submitForm()
    }
})

async function submitForm() {
    let formData = new FormData(form)

    let json = await fetch('/register', {
        method: 'post',
        body: formData
    }).then(res => res.json())

    if (json.status == 'success') {
        location.href = json.message
    } else {
        addNotification('error', json.message)
    }
}