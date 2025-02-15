//Resaltamos el link del modulo visitado
function active_menu_link() {
    let has_class_menu = false;
    let url_now = window.location.pathname;
    url_now = url_now.slice(url_now.lastIndexOf("/"));
    let urls_menu_app = document.querySelectorAll(
        "#sidebar .sidebar-wrapper .sidebar-menu .sidebar-item"
    );

    //Recorremos menu para agregar class active
    for (let i = 0; i < urls_menu_app.length; i++) {
        let url_menu = urls_menu_app[i]
            .querySelector(".sidebar-link")
            .getAttribute("href");
        if (url_menu != null) {
            url_menu = "/" + url_menu;
            if (url_menu == url_now) {
                urls_menu_app[i].classList.add("active");
                has_class_menu = true;
            }
        }
    }

    if (has_class_menu == false) {
        /*url_now = window.location.pathname;
        url_now = url_now.slice(url_now.indexOf("views"));
        url_now = url_now.slice(0, url_now.lastIndexOf("/"));*/

        if (url_now) {
            let urls_submenu_app = document.querySelectorAll(
                "#sidebar .sidebar-wrapper .sidebar-menu .submenu-item"
            );

            //Recorremos submenu para agregar class active
            for (let i = 0; i < urls_submenu_app.length; i++) {
                let url_submenu = urls_submenu_app[i]
                    .querySelector(".submenu-link")
                    .getAttribute("href");
                if (url_submenu != "#") {
                    /*url_submenu = url_submenu.slice(url_submenu.indexOf("views"));
                    url_submenu = url_submenu.slice(0,url_submenu.lastIndexOf("/"));*/
                    if ("/" + url_submenu == url_now) {
                        urls_submenu_app[
                            i
                        ].parentElement.parentElement.classList.add("active");
                        urls_submenu_app[i].parentElement.classList.remove(
                            "submenu-closed"
                        );
                        urls_submenu_app[i].parentElement.classList.add(
                            "submenu-open"
                        );
                        urls_submenu_app[i].classList.add("active");
                    }
                }
            }
        } else {
            document
                .querySelector(
                    "#sidebar .sidebar-wrapper .sidebar-menu .sidebar-item.home"
                )
                .classList.add("active");
        }
    }
}

$(document).ready(function () {
    active_menu_link(); //Resaltamos el link del modulo visitado
});
