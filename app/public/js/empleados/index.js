const url_api = "app/methods/empleados/index.php";
let guardarButton = document.getElementById("save_data");
let initChoice = "";
//Configuracion validaciones de formulario
let options = {
    focus: "first",
    excluded:
        "input[type=button], input[type=submit], input[type=reset], .search, .ignore",
    triggerAfterFailure: "change blur",
    errorsContainer: function (element) {},
    trigger: "change",
    successClass: "is-valid",
    errorClass: "is-invalid",
    classHandler: function (el) {
        return el.$element.closest(".form-group");
    },
    errorsContainer: function (el) {
        return el.$element.closest(".form-group");
    },
    errorsWrapper: '<div class="parsley-error"></div>',
    errorTemplate: "<span></span>",
};
let form_empleado = $("#form-empleado").parsley(options);

//Funciones Javascript
class empleados {
    //Listamos data en datatable
    get_data() {
        const formData = new FormData();
        formData.append("opcn", "get_empleados");

        fetch(url_api, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                this.draw_table(false);
                throw new Error(response.status);
            }
            return response.json();
        })
        .then((data) => {
            data.state
                ? this.draw_table(true, data.data_empleados)
                : this.draw_table(false);
        });
    }

    //Dibujar tabla
    draw_table(has_data_table, datos = []) {
        if (has_data_table) {
            let rows = "";
            let estado = "";
            datos.forEach((value) => {
                estado =
                    value.boletin === "1"
                        ? '<span class="badge bg-success">Si</span>'
                        : '<span class="badge bg-danger">No</span>';
                rows += `
                    <tr>
                        <td>${value.nombre}</td>
                        <td>${value.email}</td>
                        <td>${value.genero}</td>
                        <td>${value.area}</td>
                        <td>${estado}</td>
                        <td>
                            <a href="#" onclick="empleadosClass.update_data(${value.id})" class="btn btn-outline-secondary" title="Editar" data-bs-toggle="modal" data-bs-target="#newusermodal"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" onclick="empleadosClass.remove_data(${value.id})" class="btn btn-outline-danger" title="Borrar"><i class="bi bi-trash3"></i></a>
                        </td>
                    </tr>`;
            });
            document.querySelector("#table1 tbody").innerHTML = rows;
            initialize_table();
        } else {
            document.querySelector("#table1 tbody").innerHTML = '<tr><td colspan="6" class="text-center">Sin resultados</td></tr>';
        }
    }

    //Listado de areas
    async load_areas() {
        const formData = new FormData();
        formData.append("opcn", "get_areas");
        let array_areas = [];

        await fetch(url_api, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.status);
            }
            return response.json();
        })
        .then((data) => {
            if (data.state) {
                array_areas = data.data_items;
            }
        });
        return array_areas;
    }

    //Listado de roles
    async load_roles() {
        const formData = new FormData();
        formData.append("opcn", "get_roles");
        let array_roles = [];

        await fetch(url_api, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.status);
            }
            return response.json();
        })
        .then((data) => {
            if (data.state) {
                array_roles = data.data_roles;
            }
        });
        return array_roles;
    }

    //Actualizar data
    update_data(id) {
        this.clearForm("edit");

        const formData = new FormData();
        formData.append("opcn", "get_empleado_by_id");
        formData.append("id", id);
        let data_empleado = [];

        fetch(url_api, {
            method: "POST",
            body: formData,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(response.status);
            }
            return response.json();
        })
        .then((data) => {
            if (data.state) {
                data_empleado = data.data_empleado;
                //Asignar datos
                form_empleado.element.id.value = data_empleado.id;
                form_empleado.element.nombre.value = data_empleado.nombre;
                form_empleado.element.email.value = data_empleado.email;

                data_empleado.genero == "M"
                    ? (form_empleado.element.genero1.checked = true)
                    : (form_empleado.element.genero2.checked = true);

                initChoice.setChoiceByValue(data_empleado.area_id);
                form_empleado.element.descripcion.value = data_empleado.descripcion;
                form_empleado.element.boletin.checked = data_empleado.boletin === "1" ? true : false;

                const idroles = data_empleado.roles.split(",");
                const checkboxsload = document.querySelectorAll(".list-checkbox input[type=checkbox]");
                checkboxsload.forEach((element) => {
                    idroles.forEach((rol) => {
                        if (rol == element.value) {
                            element.checked = true;
                            return;
                        }
                    });
                });
            }
        });
    }

    //Borramos data
    remove_data(id) {
        if (window.confirm("¿Estas seguro de querer borrar este empleado?") == true) {
            const formData = new FormData();
            formData.append("opcn", "delete_empleados");
            formData.append("id", id);

            fetch(url_api, {
                method: "POST",
                body: formData,
            })
            .then((response) => {
                if (!response.ok) {
                    empleadosClass.message_user(false,"Ups! Algo mal sucedio.");
                    throw new Error(response.status);
                }
                return response.json();
            })
            .then((data) => {
                empleadosClass.message_user(data.state, data.message);
            });
        } 
    }

    //Limpiar formulario
    clearForm(action) {
        document.getElementById("form-empleado").reset();
        if (action == "new") {
            document.querySelector("#newusermodal .modal-title").innerHTML ="Agregar empleado";
            form_empleado.element.action.value = "create";
        } else {
            document.querySelector("#newusermodal .modal-title").innerHTML = "Editar empleado";
            form_empleado.element.action.value = "update";
        }
    }

    //Mensajes de confirmacion al usuario
    message_user(tipo_confirmacion, msj) {
        let background = tipo_confirmacion ? "#4fbe87" : "#f27474";
        Toastify({
            text: msj,
            duration: 3000,
            close: true,
            stopOnFocus: false,
            gravity: "top",
            position: "center",
            style: { background: background },
            callback: function () {
                if (tipo_confirmacion) {
                    window.location.reload();
                } else {
                    guardarButton.removeAttribute("data-indicator"); // Remove loading indication
                    guardarButton.disabled = false; // Enable button
                }
            },
        }).showToast();
    }
}
var empleadosClass = new empleados();

//Inicializamos elementos listas desplegables
async function initialize_component_select() {
    //Inicializar listas desplegables
    let data_areas = await empleadosClass.load_areas();
    initChoice = new Choices(document.querySelector("#areas"), {
        choices: data_areas,
        allowHTML: true,
    });
}

//Inicializamos elementos checkbox
async function initialize_component_checkbox() {
    let data_roles = await empleadosClass.load_roles();
    let checkbox_html = `<label class="form-label">Roles</label>`;
    let validador_checkbox = "";
    data_roles.forEach((value, index) => {
        validador_checkbox = index == 0 ? 'data-parsley-required="true"' : "";
        checkbox_html += `
            <div class="form-check">
                <input type="checkbox" id="rol${value.id}" name="rolescheck" value="${value.id}" class="form-check-input" ${validador_checkbox} />
                <label for="rol${value.id}"class="form-check-label form-label">${value.nombre}</label>
            </div>`;
    });
    document.querySelector(".list-checkbox").innerHTML = checkbox_html;
}

//Inicializamos datatable con datos
function initialize_table() {
    let config_datatable = $("#table1").DataTable({
        responsive: true,
    });
    const setTableColor = () => {
        document
            .querySelectorAll(".dataTables_paginate .pagination")
            .forEach((dt) => {
                dt.classList.add("pagination-primary");
            });
    };
    setTableColor();
    config_datatable.on("draw", setTableColor);
}

//Funciones de cargue JQuery
$(document).ready(function () {
    empleadosClass.get_data();
    initialize_component_select();
    initialize_component_checkbox();
});

//Evento guardar formulario
guardarButton.addEventListener("click", function (e) {
    e.preventDefault();

    if (form_empleado.validate()) {
        guardarButton.setAttribute("data-indicator", "on"); // Show loading indication
        guardarButton.disabled = true; // Disable button to avoid multiple click

        const { nombre, email, genero1, areas, descripcion, boletin, id } = form_empleado.element;
        const checked = document.querySelectorAll(".list-checkbox input[type=checkbox]:checked");
        const roles = Array.from(checked).map((x) => x.value);

        const empleadoData = {
            opcn: "create_empleados",
            nombre: nombre.value,
            email: email.value.trim(),
            genero: genero1.checked ? "M" : "F",
            area_id: areas.value,
            boletin: boletin.checked ? 1 : 0,
            descripcion: descripcion.value,
            roles: roles.toString(),
        };

        if (form_empleado.element.action.value == "update") {
            empleadoData.id = id.value;
            empleadoData.opcn = "update_empleados";
        }

        $.ajax({
            url: url_api,
            data: empleadoData,
            type: "post",
            dataType: "json",
        }).done(function (data) {
            let state_message = data.state ? true : false;
            setTimeout(function () {
                empleadosClass.message_user(state_message, data.message);
            }, 500);
        });
    }
});
