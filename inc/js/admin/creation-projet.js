$(document).ready(function () {

    $("#fileuploader").uploadFile({
        url: "/validation/admin/projets/upload-projet-files-validation.php",
        fileName: "myfile",
        dragDrop: true,
        acceptFiles: "image/*",
        statusBarWidth: 600,
        dragdropWidth: 600,
        multiple: false,
        showPreview: true,
        previewHeight: "auto",
        previewWidth: "300px",
        onSuccess: function () {
            location.reload();
        }
    });

    $("#debut").datepicker({
        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthNamesShort: ["Janv.", "Févr.", "Mars", "Avr.", "Mai", "Juin", "Juil.", "Août", "Sept.", "Oct.", "Nov.", "Déc."],
        dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
        prevText: "Précédent",
        nextText: "Suivant",
        changeMonth: true,
        changeYear: true,
        currentText: "Aujourd'hui",
        dateFormat: "dd/mm/yy",
        yearRange:"c-20:c+30",
    });

    $("#fin").datepicker({
        changeMonth: true,
        changeYear: true,
        currentText: "Aujourd'hui",
        dateFormat: "dd/mm/yy",
        monthNames: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthNamesShort: ["Janv.", "Févr.", "Mars", "Avr.", "Mai", "Juin", "Juil.", "Août", "Sept.", "Oct.", "Nov.", "Déc."],
        dayNames: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
        prevText: "Précédent",
        nextText: "Suivant",
        yearRange:"c-20:c+30",
    });


    tinymce.init({
        selector: '#description',
        placeholder: 'La description du projet...',
        menubar: false,
        plugins: 'lists save autosave',
        toolbar: 'save | undo redo | bold italic | bullist numlist indent outdent | alignleft aligncenter alignright alignjustify',
        save_onsavecallback: () => {
            saveDescription(tinymce.activeEditor.getContent());
        },
        setup: (editor) => {
            editor.on('focusout', () => {
                tinymce.activeEditor.execCommand('mceSave');
            });
        }
    });

    tinymce.init({
        selector: '#objectif',
        placeholder: 'Les objectifs du projet...',
        menubar: false,
        plugins: 'lists save autosave',
        toolbar: 'save | undo redo | bold italic | bullist numlist indent outdent | alignleft aligncenter alignright alignjustify',
        save_onsavecallback: () => {
            saveObjectif(tinymce.activeEditor.getContent());
        },
        setup: (editor) => {
            editor.on('focusout', () => {
                tinymce.activeEditor.execCommand('mceSave');
            });
        }
    });

    tinymce.init({
        selector: '#resultat',
        placeholder: 'Les resultats du projet...',
        menubar: false,
        plugins: 'lists save autosave',
        toolbar: 'save | undo redo | bold italic | bullist numlist indent outdent | alignleft aligncenter alignright alignjustify',
        save_onsavecallback: () => {
            saveResultat(tinymce.activeEditor.getContent());
        },
        setup: (editor) => {
            editor.on('focusout', () => {
                tinymce.activeEditor.execCommand('mceSave');
            });
        }
    });

    function saveDescription(descriptionContent) {
        $.post("/validation/admin/projets/update-description-validation.php", {description: descriptionContent}, function (data) {
            if (data.type === "session") {
                $(location).attr("href", "/wps-admin")
            }
        }, "json")
    }

    function saveObjectif(objectifContent) {
        $.post("/validation/admin/projets/update-objectif-validation.php", {objectif: objectifContent}, function (data) {
            if (data.type === "session") {
                $(location).attr("href", "/wps-admin")
            }
        }, "json")
    }

    function saveResultat(resultatContent) {
        $.post("/validation/admin/projets/update-resultat-validation.php", {resultat: resultatContent}, function (data) {
            if (data.type === "session") {
                $(location).attr("href", "/wps-admin")
            }
        }, "json")
    }

    /**
     Ajout d'un nouveau client */
    inputValidation("#nom-client", "nom du client", 2, 50, true);
    $("#btn-confirm-add-client").on("click", function () {

        $("#btn-confirm-add-client").attr("disabled", "disabled")
        gifLoader("#btn-confirm-add-client");
        $(".error").text("");

        const nom = $("#nom-client").val();

        $.post("/validation/admin/projets/add-client-validation.php", {nom}, function (data) {

            if (data.type == null && data.nom == null) {

                $(".client-container").html('');

                let html = "<label for='client'>Client</label> "
                html += "<select name='client' id='client' class='form-select form-select-md'>";

                data.forEach(client => {
                    if (client.nom.toLowerCase() === nom) {
                        html += "<option value='" + client.id + "' selected='selected'>" + client.nom + "</option>";
                    } else {
                        html += "<option value='" + client.id + "'>" + client.nom + "</option>";
                    }

                })

                html += "</select>";
                html += "<div class='error'></div>";

                $(".client-container").append(html);
                $("#btn-close-add-client").trigger("click");

            } else if (data.type === "session") {

                $(location).attr("href", "/wps-admin")

            } else {

                $("#btn-confirm-add-client").removeAttr("disabled")

                if (data.nom != null) {
                    $("#nom-client").addClass("is-invalid")
                    $("#nom-client").parent().find(".error").text(data.nom)
                } else {
                    $("#nom-client").removeClass("is-invalid").addClass("is-valid")
                    $("#nom-client").parent().find(".error").text("")
                }

            }

        }, "json")

    })

    /**
     Ajout d'un nouveau domaine */
    inputValidation("#nom-domaine", "nom du domaine", 2, 30, true);
    $("#btn-confirm-add-domaine").on("click", function () {

        $("#btn-confirm-add-domaine").attr("disabled", "disabled")
        gifLoader("#btn-confirm-add-domaine");
        $(".error").text("");

        const nom = $("#nom-domaine").val();

        $.post("/validation/admin/projets/add-domaine-validation.php", {nom}, function (data) {


            if (data.type == null && data.nom == null) {

                $(".domaine-container").html("");

                let html = "<label for='domaine'>Domaine</label> "
                html += "<select name='domaine' id='domaine' class='form-select form-select-md'>";

                data.forEach(domaine => {
                    if (domaine.nom.toLowerCase() === nom) {
                        html += "<option value='" + domaine.id + "' selected='selected'>" + domaine.nom + "</option>";
                    } else {
                        html += "<option value='" + domaine.id + "'>" + domaine.nom + "</option>";
                    }

                })

                html += "</select>";
                html += "<div class='error'></div>";

                $(".domaine-container").append(html);
                $("#btn-close-add-domaine").trigger("click");

            } else if (data.type === "session") {

                $(location).attr("href", "/wps-admin")

            } else {

                $("#btn-confirm-add-domaine").removeAttr("disabled")

                if (data.nom != null) {
                    $("#nom-domaine").addClass("is-invalid")
                    $("#nom-domaine").parent().find(".error").text(data.nom)
                } else {
                    $("#nom-domaine").removeClass("is-invalid").addClass("is-valid")
                    $("#nom-domaine").parent().find(".error").text("")
                }

            }

        }, "json")

    })

    /*
    Ajout d'un nouveau lieu*/
    inputValidation("#nom-lieu", "nom du lieu", 2, 20, true);
    $("#btn-confirm-add-lieu").on("click", function () {

        $("#btn-confirm-add-lieu").attr("disabled", "disabled")
        gifLoader("#btn-confirm-add-lieu");
        $(".error").text("");

        const nom = $("#nom-lieu").val();

        $.post("/validation/admin/projets/add-lieu-validation.php", {nom}, function (data) {

            if (data.type == null && data.nom == null) {

                $(".lieu-container").html("");

                let html = "<label for='lieu'>Lieu</label> "
                html += "<select name='lieu' id='lieu' class='form-select form-select-md'>";

                data.forEach(lieu => {
                    if (lieu.nom.toLowerCase() === nom) {
                        html += "<option value='" + lieu.id + "' selected='selected'>" + lieu.nom + "</option>";
                    } else {
                        html += "<option value='" + lieu.id + "'>" + lieu.nom + "</option>";
                    }

                })

                html += "</select>";
                html += "<div class='error'></div>";

                $(".lieu-container").append(html);
                $("#btn-close-add-lieu").trigger("click");

            } else if (data.type === "session") {

                $(location).attr("href", "/wps-admin")

            } else {

                $("#btn-confirm-add-lieu").removeAttr("disabled")

                if (data.nom != null) {
                    $("#nom-lieu").addClass("is-invalid")
                    $("#nom-lieu").parent().find(".error").text(data.nom)
                } else {
                    $("#nom-lieu").removeClass("is-invalid").addClass("is-valid")
                    $("#nom-lieu").parent().find(".error").text("")
                }

            }

        }, "json")

    })


    /**
     Ajouter un projet */
    $("#project-references").on("submit", function (event) {
        event.preventDefault();

        $("#btn-add-projet").attr("disabled", "disabled")
        gifLoader("#btn-add-projet");
        $(".error").text("");

        const data = new FormData(this);
        data.append("description",$("#description").val())
        data.append("objectif",$("#objectif").val())
        data.append("resultat",$("#resultat").val())

        $.ajax({
            url: "/validation/admin/projets/add-projet-validation.php",
            method: "POST",
            data: data,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                if (data.type === "success") {

                    location.reload();

                } else if (data.type === "session") {

                    $(location).attr("href", "/w1-admin")

                } else {
                    $("#btn-add-projet").removeAttr("disabled")

                    Object.entries(data).forEach(([key, value]) => {
                        $("#" + key).addClass("is-invalid")
                        $("#" + key).parent().find(".error").text(value)
                    });
                }
            }
        });
    })

    //supprimer une image de projet
    $(".btn-delete-one-image").on("click", function () {

        const chemin = $(this).val();

        $.post("/validation/admin/projets/delete-projet-image-validation.php", {chemin}, function (data) {

            if (data.type === "success") {

                location.reload();

            } else if (data.type === "session") {

                $(location).attr("href", "/wps-admin")

            }

        }, "json")

    })

    //choisir de l'image d'illustration
    $("#illustration").change(function () {

        const reader = new FileReader();

        reader.addEventListener("load", function () {
            $("#img-container img").attr("src", this.result)
        })

        reader.readAsDataURL(this.files[0]);

    });


})


