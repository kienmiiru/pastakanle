let $ = s => document.querySelector(s)
let $$ = s => document.querySelectorAll(s)

let dropdownButtons = $$('.dropdown')
for (let dropdownButton of dropdownButtons) {
    let dropdownOpened = false
    let dropdownContent = dropdownButton.querySelector('.dropdown-content')
    let dropdownSpan = dropdownButton.querySelector('span')

    dropdownSpan.addEventListener('click', () => {
        dropdownOpened = !dropdownOpened

        if (dropdownOpened) {
            dropdownSpan.innerText = dropdownSpan.innerText.replace('▼', '▲')
            dropdownContent.classList.remove('nodisplay')
        } else {
            dropdownSpan.innerText = dropdownSpan.innerText.replace('▲', '▼')
            dropdownContent.classList.add('nodisplay')
        }
    })
}

let loginMessageDiv = $('#login-message')
let loginButton = $('#login-button')
if (loginButton) {
    loginButton.addEventListener('click', () => {
        let username = $('#login-username').value
        let password = $('#login-password').value
        let formData = new FormData()
        formData.append('username', username)
        formData.append('password', password)

        let req = fetch('/login', {
            method: 'post',
            body: formData
        }).then(d => d.json())
        req.then(d => {
            if (d.status == 'success') {
                if (typeof saveToLocalStorage === 'function') {
                    saveToLocalStorage()
                }
                location.reload()
            } else {
                loginMessageDiv.classList.remove('nodisplay')
                loginMessageDiv.innerText = d.message
            }
        })
    })
}

let logoutButton = $('#logout-button')
if (logoutButton) {
    logoutButton.addEventListener('click', async () => {
        let json = await fetch('/logout', {
            method: 'post',
        }).then(res => res.json())
    
        if (json.status == 'success') {
            if (typeof saveToLocalStorage === 'function') {
                saveToLocalStorage()
            }
            location.reload()
        }
    })
}

let notificationListDiv = $('#ntf-list')

function addNotification(type, message) {
    let div = document.createElement('div')
    notificationListDiv.append(div)
    div.classList.add('ntf', 'ntf-' + type)
    div.onclick = () => div.remove()
    div.innerHTML = `
                <div class="ntf-title"></div>
                ${message}`
    setTimeout(() => div.remove(), 3000)
}

function showModalConfirm(message) {
    return new Promise((resolve) => {
        let div = document.createElement('div')
        document.body.append(div)
        div.classList.add('modal')
        div.innerHTML = `
            <div class="modal-content">
                ${message}
                <div style="margin-top: 8px;">
                    <button class="checked">Yes</button>
                    <button>No</button>
                </div>
            </div>`
    
        div.querySelectorAll('button').forEach((button, index) => {
            button.addEventListener('click', () => {
                if (index === 0) { resolve(true) }
                else { resolve(false) }
                div.remove()
            })
        })
    })
}

function showModalPrompt(message) {
    return new Promise((resolve) => {
        let div = document.createElement('div')
        document.body.append(div)
        div.classList.add('modal')
        div.innerHTML = `
            <div class="modal-content">
                ${message}
                <input style="margin: 8px" type="text">
                <div style="margin-top: 8px;">
                    <button class="checked">OK</button>
                    <button>Cancel</button>
                </div>
            </div>`
        let input = div.querySelector('input')
        input.focus()
    
        div.querySelectorAll('button').forEach((button, index) => {
            button.addEventListener('click', () => {
                if (index === 0) { resolve(input.value) }
                else { resolve(false) }
                div.remove()
            })
        })
    })
}