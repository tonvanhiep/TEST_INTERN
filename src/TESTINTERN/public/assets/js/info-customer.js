function editInfo(x)
{
    if (x.className == 'btn btn-outline-secondary mb-3') {
        x.textContent = "セーブ";
        x.className = "btn btn-primary mb-3";

        document.getElementById('btn-cancel').hidden = false;
        let arrInp = document.getElementsByClassName('info-customer');
        for (let index = 0; index < arrInp.length; index++) {
            arrInp[index].disabled = false;
        }
    }
    else if (x.className == 'btn btn-primary mb-3') {
        document.getElementById('form-edit-info').submit();
    }
}

