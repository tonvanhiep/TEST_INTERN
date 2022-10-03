function editCustomerId(id) {
    let btnEdit = document.getElementById('btn-edit-inp-'+id);
    let classId = 'inp-row-' + id;
    let arrInp = document.getElementsByClassName(classId);

    if (btnEdit.textContent == "Sửa") {
        for (let index = 0; index < arrInp.length; index++) {
            arrInp[index].disabled = false;
            btnEdit.innerText = "Lưu";
            btnEdit.className = "btn btn-outline-success";
        }
    }
    else if (btnEdit.textContent == "Lưu") {
        for (let index = 0; index < arrInp.length; index++) {
            arrInp[index].disabled = true;
            btnEdit.innerText = "Sửa";
            btnEdit.className = "btn btn-outline-warning";
        }
        //luu len database qua ajax
    }

}

function deleteCustomerId(id) {}
