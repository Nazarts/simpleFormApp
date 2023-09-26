document.addEventListener('DOMContentLoaded', function () {
    console.log('ok')
    document.getElementById('btn_submit').addEventListener('click', handleSubmit)
})

const inputValueExtract = (id) => document.getElementById(id)?.value;

function makeErrorAlert(el, after_element, message) {
    const wrapper = document.createElement('div')
    wrapper.innerHTML = [
        `<div class="alert alert-danger alert-dismissible" role="alert">`,
        `   <div>${message}</div>`,
        '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
        '</div>'
    ].join('');
    el.insertBefore(wrapper, after_element);
}

function validateSubmit(form, data) {
    let isValid = true;
    for (const userDataKey in data) {
        const currentEl = document.getElementById('user_form__' + userDataKey);
        if (data[userDataKey] === '') {

            makeErrorAlert(form, currentEl.parentNode, 'The field is required');

            isValid = false;
        }
    }
    if (data['re_password'] !== data['password']) {
        const currentEl = document.getElementById('user_form__re_password');
        makeErrorAlert(form, currentEl.parentNode, 'The passwords should match');
        isValid = false;
    }

    if (!data['email'].includes('@')) {
        const currentEl = document.getElementById('user_form__email');
        makeErrorAlert(form, currentEl.parentNode, 'The email should include "@" sign');
        isValid = false;
    }

    return isValid;
}

function handleSuccess() {

}

function handleResponse(request) {
    try {
        if (request.readyState === XMLHttpRequest.DONE) {
            let form = document.getElementById('user_form');
            if (request.status === 200) {
                form.classList.toggle('hidden');
            }
            else if (request.status === 400) {
                let response = JSON.parse(request.responseText);
                let mainContainer = document.getElementById('main_container');
                response.forEach((error) => {
                    makeErrorAlert(mainContainer, form, error['message']);
                })
            }
            else {
                console.log(request.responseText)
            }
        }
    }
    catch (e) {
        console.log(e)
    }
}

function sendRequest(userData) {
    const httpRequest = new XMLHttpRequest();

    httpRequest.open("POST", "server/view.php", true);
    httpRequest.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded",
    );
    let user_str = [];
    for (const userDataKey in userData) {
        user_str.push(userDataKey+'='+userData[userDataKey])
    }
    user_str = user_str.join('&');
    httpRequest.send(user_str);
    httpRequest.onreadystatechange = () => handleResponse(httpRequest);
}

async function handleSubmit(ev) {
    let user_data = {
        name: inputValueExtract('user_form__name'),
        surname: inputValueExtract('user_form__surname'),
        email: inputValueExtract('user_form__email'),
        password: inputValueExtract('user_form__password'),
        re_password: inputValueExtract('user_form__re_password'),
    }
    let form = document.getElementById('user_form');

    let isValid = validateSubmit(form, user_data);

    if (isValid) {
        sendRequest(user_data)

    }
}