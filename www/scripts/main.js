function changeStatus() {
    let status = document.getElementById('err');
    status.style.display = 'none';
}
function disableCheckbox() {
    let initiator = document.getElementById('is-random');
    let dependent = document.getElementById('is-light');

    if (!initiator.checked) {
        dependent.checked = false;
    }
}
function setExtraEdit() {
    let selector = document.getElementById('is-extra-edit');
    let container = document.getElementById('extra-edit-container');

    if (selector.checked) {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
}