const Modal = {
    open(){
        document
            .querySelector('.modal1-overlay')
            .classList
            .add('active')
    },
    close(){
        document
            .querySelector('.modal1-overlay')
            .classList
            .remove('active')
    }
}
document.querySelector('.select2-input')
document.querySelector('.select2-focusser').value = "Segurança da Informação"
const alert_message = document.querySelector('.select2-input');
const alert_message = document.querySelector('.alert-message');
const cep_btn = document.querySelector('.cep__btn');
const tabela = document.getElementById('tbl');
const nome = document.getElementById('nome');
const cep = document.getElementById('cep');
const rua = document.getElementById('rua');
const numero = document.getElementById('numero');
const cidade = document.getElementById('cidade');
const estado = document.getElementById('estado');

function clearForm() {
    nome.value = "";
    cep.value = "";
    rua.value = "";
    numero.value = "";
    cidade.value = "";
    estado.value = "MG";
}

cep_btn.addEventListener('click', function () {
    validateCEP(cep.value)
})

cep.addEventListener('keypress', enter)
function enter(event) {
    key = event.keyCode
    if (key === 13) {
        validateCEP(cep.value)
    }
}

function validateCEP(value){
    //* exclui pontuação e letras, deixando apenas digitos
    let cep_number = value.replace(/\D/g, '');
    // let cep = cep.replace('.','').replace('-','')
    //* verifica se campo cep possui valor informado.
    if (cep_number != "") {
        //* expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //* valida o formato do CEP.
        if(validacep.test(cep_number)) {
            requestCEP(cep_number)
        } 
        else {
            clearForm();
            alert_message.parentElement.classList.add('active')
            alert_message.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <strong>Erro!</strong> Formato de CEP inválido.`
            // alert("Formato de CEP inválido.");
        }
    }
    else {
        clearForm();
        alert_message.parentElement.classList.add('active')
        alert_message.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <strong>Erro!</strong> Campo CEP vazio`
    }
}

function requestCEP(cep) {
    const options = {
        method: 'GET',
        mode: 'cors',
        cache: 'default'
    }
    fetch(`https://viacep.com.br/ws/${cep}/json/`, options)
        .then(response => {
            response.json()
                .then(response => {
                    if (response.erro) {
                        throw new Error(`CEP informado não existe`)
                    }
                    console.log(response)
                    displayResults(response)
                })
                .catch(error => {
                    alert_message.parentElement.classList.add('active')
                    alert_message.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <strong>Erro!</strong> ${error.message}`
                    // alert(error.message)
                })
        })
}

function displayResults(response){
    rua.value = `${response.logradouro}`;
    cidade.value = `${response.localidade}`;
    estado.value = `${response.uf}`;
}

// function createLine(nome, cep, rua, numero, cidade, estado) {
//     clearForm();
//     Modal.close();
//     let numeroLinhas = tabela.rows.length;
//     /*insira uma linha após a última*/
//     let linha = tabela.insertRow(numeroLinhas);
//     /*inserir uma celula em cada coluna*/
//     let cell_name = linha.insertCell(0);
//     let cell_cep = linha.insertCell(1);   
//     let cell_state= linha.insertCell(2);
//     let cell_city= linha.insertCell(3);
//     let cell_street= linha.insertCell(4);
//     let cell_number= linha.insertCell(5);
//     let cell_del = linha.insertCell(6);

//     cell_name.innerHTML = `${nome}`; 
//     cell_cep.innerHTML =  `${cep}`;
//     cell_state.innerHTML =  `${cidade}`
//     cell_city.innerHTML = `${estado}`;
//     cell_street.innerHTML =  `${rua}`;
//     cell_number.innerHTML =  `${numero}`;
//     cell_del.innerHTML =  `<button type="button" onclick="removeLine(this)" class="btn btn-danger"><i class="fas fa-trash"></i></button>`;
// }

// function removeLine(linha) {
//     var i=linha.parentNode.parentNode.rowIndex;
//     document.getElementById('tbl').deleteRow(i);
//   } 

function validate(val) {
    let flag1 = true;
    let flag2 = true;
    let flag3 = true;
    let flag4 = true;
    let flag5 = true;
    let flag6 = true;

    if (val == 1 || val == 0) {
        if (nome.value == "") {
            nome.style.borderColor = "red";
            flag1 = false;
        }
        // else if (nome.value == "123") {
        //     nome.style.borderColor = "red";
        //     flag1 = false;
        // }
        else {
            nome.style.borderColor = "none";
            flag1 = true;
        }
    }
    if (val == 2 || val == 0) {
        if (cep.value == "") {
            cep.style.borderColor = "red";
            flag2 = false;
        }
        else {
            cep.style.borderColor = "green";
            flag2 = true;
        }
    }
    if (val == 3 || val == 0) {
        if (rua.value == "") {
            rua.style.borderColor = "red";
            flag3 = false;
        }
        else {
            rua.style.borderColor = "none";
            flag3 = true;
        }
    }
    if (val == 4 || val == 0) {
        if (numero.value == "") {
            numero.style.borderColor = "red";
            flag4 = false;
        }
        else {
            numero.style.borderColor = "none";
            flag4 = true;
        }
    }
    if (val == 6 || val == 0) {
        if (cidade.value == "") {
            cidade.style.borderColor = "red";
            flag5 = false;
        }
        else {
            cidade.style.borderColor = "none";
            flag5 = true;
        }
    }
    if (val == 7 || val == 0) {
        if (estado.value == "") {
            estado.style.borderColor = "red";
            flag6 = false;
        }
        else {
            estado.style.borderColor = "none";
            flag6 = true;
        }
    }
    flag = flag1 && flag2 && flag3 && flag4 && flag5 && flag6;
    return flag;
}