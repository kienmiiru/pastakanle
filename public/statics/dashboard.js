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