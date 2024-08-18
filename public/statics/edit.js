let textTextarea = $('#paste-text')
let charLimitDiv = $('#char-limit')
let charLimitEncryptedDiv = $('#char-limit-encrypted')
let encryptedLength = 0

textTextarea.addEventListener('input', () => {
    let textLength = textTextarea.value.length
    charLimitDiv.innerText = textLength.toLocaleString() + charLimitDiv.innerText.slice(-8)
    encryptedLength = (Math.floor(textLength / 16) + 1) * 16
    encryptedLength += 64 + 8 + 8 // 64 bytes HMAC, 8 bytes salt marker, 8 bytes salt
    charLimitEncryptedDiv.innerText = `Encrypted: ${encryptedLength.toLocaleString()}/200,000`
})

let encryptionEnableInput = $('#paste-encryption-enable')
let encryptionDisableInput = $('#paste-encryption-disable')
let encryptionKeyInput = $('#paste-encryption-key')

encryptionEnableInput.addEventListener('change', () => {
    charLimitEncryptedDiv.classList.remove('nodisplay')
    textTextarea.maxLength = 199919
    charLimitDiv.innerText = charLimitDiv.innerText.slice(0, -7) + '199,919'
    encryptionKeyInput.disabled = false
})

encryptionDisableInput.addEventListener('change', () => {
    charLimitEncryptedDiv.classList.add('nodisplay')
    textTextarea.maxLength = 200000
    charLimitDiv.innerText = charLimitDiv.innerText.slice(0, -7) + '200,000'
    encryptionKeyInput.disabled = true
})

function encrypt(plaintext, key) {
    const encrypted = CryptoJS.AES.encrypt(plaintext, key).toString()
    // HMAC with fixed length (64)
    const hmac = CryptoJS.HmacSHA256(encrypted, key).toString()
    return hmac + encrypted
}

let editButton = $('#edit')
let previewButton = $('#preview')

editButton.addEventListener('click', e => {
    e.preventDefault()
    let titleInput = $('#paste-title')
    let visibilityOption = $('input[name="visibility"]:checked')
    let expirationOption = $('input[name="expiration"]:checked')
    let encryptionOption = $('input[name="paste-encryption"]:checked')?.value == '1'

    let conditions = [
        [titleInput.value, 'Title can\'t be empty'],
        [textTextarea.value, 'Paste content can\'t be empty'],
        [['0', '1', '2'].includes(visibilityOption?.value), 'Invalid visibility value'],
        [['-1', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'].includes(expirationOption?.value), 'Invalid expiration value'],
        [!encryptionOption || encryptionKeyInput.value, 'Please enter encryption passphrase'],
        [!encryptionOption || encryptedLength <= 200000, 'Paste data after encryption is too long']
    ]

    let errorMessage = false
    for (let [isFulfilled, message] of conditions) {
        if (!isFulfilled) {
            errorMessage = true
            addNotification('info', message)
        }
    }

    if (errorMessage) {
        return
    } else {
        if (encryptionOption) {
            textTextarea.value = encrypt(textTextarea.value, encryptionKeyInput.value)
        }

        submitForm()
    }
})

async function submitForm() {
    let form = new FormData($('#main'))
    let formData = new FormData() // Avoid sending encryption key
    formData.append('paste_code', form.get('paste_code'))
    formData.append('title', form.get('title'))
    formData.append('text', form.get('text'))
    formData.append('visibility', form.get('visibility'))
    formData.append('expiration', form.get('expiration'))

    let json = await fetch('/edit', {
        method: 'post',
        body: formData
    }).then(res => res.json())

    if (json.status == 'success') {
        location.href = json.message
    } else {
        addNotification('error', json.message)
    }
}