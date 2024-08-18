function decrypt(encryptedData, key) {
    const hmac = encryptedData.slice(0, 64)
    const encrypted = encryptedData.slice(64)
    // Verify HMAC
    const computedHmac = CryptoJS.HmacSHA256(encrypted, key).toString(CryptoJS.enc.Hex)
    if (hmac !== computedHmac) {
        throw new Error('Invalid HMAC')
    }

    // Decrypt the ciphertext
    const bytes = CryptoJS.AES.decrypt(encrypted, key)
    return bytes.toString(CryptoJS.enc.Utf8)
}



async function decryptPaste(e) {
    let passphrase = await showModalPrompt('This paste appears to be encrypted. You can decrypt it by entering the correct passphrase')
    if (passphrase === false) return
    try {
        let decrypted = decrypt($('#paste-view-text').innerText, passphrase)
        $('#paste-view-text').innerText = decrypted
        e.remove()
        addNotification('success', 'Paste has been decrypted successfully')
    } catch (_) {
        addNotification('error', 'Incorrect passphrase')
    }
}

async function deletePaste(pasteCode) {
    if (!await showModalConfirm('Are you sure?')) return
    let formData = new FormData()
    formData.append('paste_code', pasteCode)

    let json = await fetch('/delete', {
        method: 'post',
        body: formData
    }).then(res => res.json())

    if (json.status == 'success') {
        location.reload()
    } else {
        addNotification('error', json.message)
    }
}