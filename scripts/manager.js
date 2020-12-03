$(document).ready(function () {
  $("#tutor").on("change", function (e) {
    let tutor = $(this).val();
    console.log(tutor);
    if (tutor === null || tutor === "null") {
      return;
    }
    getAlumnos(tutor);
  });
  $("#asignar-est").on("click", function () {
    let values = $("#noasignados").val();
    let id = $("#tutor").val();
    console.log(values);
    $.ajax({
      type: "POST",
      url: "index.php?controlador=ManageUsers&accion=asignarAlumnos",
      dataType: "json",
      data: {
        estudiantes: values,
        tutorid: id,
      },
      success: function (data) {
        console.log(data);
        getAlumnos(id);
      },
    });
  });

  $("#remover-est").on("click", function () {
    let values = $("#asignados").val();
    let id = $("#tutor").val();
    console.log(values);
    $.ajax({
      type: "POST",
      url: "index.php?controlador=ManageUsers&accion=removerAlumnos",
      dataType: "json",
      data: {
        estudiantes: values,
        tutorid: id,
      },
      success: function (data) {
        console.log(data);
        getAlumnos(id);
      },
    });
  });
  $(".various3").fancybox({
    width: 1100,
    height: 380,
    autoScale: false,
    transitionIn: "elastic",
    transitionOut: "elastic",
    speedIn: 500,
    type: "iframe",
    hideOnOverlayClick: false,
  });
  $(".various2").fancybox({
    width: 600,
    height: 190,
    autoScale: false,
    transitionIn: "elastic",
    transitionOut: "elastic",
    speedIn: 500,
    type: "iframe",
    hideOnOverlayClick: false,
  });
  $(".various4").fancybox({
    width: 1100,
    height: 450,
    autoScale: false,
    transitionIn: "elastic",
    transitionOut: "elastic",
    speedIn: 500,
    type: "iframe",
    hideOnOverlayClick: false,
  });
  $("img").css("border", "0");
  oTable = $("#mytable")
    .dataTable({
      fnCreatedRow: function (nRow, aData, iDataIndex) {
        $(nRow).addClass("class1");
        $("td:eq(0)", nRow).addClass("init2");
        $("td:eq(1)", nRow).addClass("item2");
        $("td:eq(2)", nRow).addClass("item2");
        $("td:eq(3)", nRow).addClass("item2");
        $("td:eq(4)", nRow).addClass("item2");
        $("td:eq(5)", nRow).addClass("item2");
        $("td:eq(6)", nRow).addClass("item2");
        $("td:eq(7)", nRow).addClass("item2");
        $("td:eq(8)", nRow).addClass("item2");
        $("td:eq(5)", nRow).css({
          "text-align": "center",
          width: "20px",
        });
        $("td:eq(7)", nRow).css({
          "text-align": "center",
          width: "20px",
        });
        $("td:eq(8)", nRow).css({
          "text-align": "center",
          width: "20px",
        });
      },
      aLengthMenu: [
        [10, 20, 50, 100, -1],
        [10, 20, 50, 100, "Todos"],
      ],
      iDisplayLength: 10,
      oLanguage: {
        sEmptyTable: "No existen datos disponibles",
        sInfo: "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
        sInfoEmpty: "Mostrando desde 0 hasta 0 de 0 registros",
        sInfoFiltered: "(filtrado de _MAX_ registros en total)",
        sInfoPostFix: "",
        sInfoThousands: ",",
        sLengthMenu: "Mostrar _MENU_ registros",
        sLoadingRecords: "Cargando...",
        sProcessing: "Procesando...",
        sSearch: "Buscar:",
        sZeroRecords: "No se encontraron resultados",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        oAria: {
          sSortAscending: ": activar para Ordenar Ascendentemente",
          sSortDescending: ": activar para Ordendar Descendentemente",
        },
      },
      sPaginationType: "full_numbers",
      oSearch: {
        bSmart: false,
      },
      aaSorting: [[6, "desc"]],
      aoColumns: [
        null,
        {
          bSortable: false,
        },
        null,
        {
          bSortable: false,
        },
        {
          bSortable: false,
        },
        {
          bSortable: false,
        },
        {
          sType: "format-date",
          bSearchable: false,
        },
        {
          bSortable: false,
          bSearchable: false,
        },
        {
          bSortable: false,
          bSearchable: false,
        },
      ],
    })
    .columnFilter({
      aoColumns: [
        {
          type: "text",
        },
        {
          type: "text",
        },
        {
          type: "number",
        },
        {
          type: "number",
        },
        {
          type: "select",
        },
        null,
        null,
        null,
      ],
    });
  $("#perfilfilter .filter_column .select_filter").change(function () {
    // oTable.fnFilter( "^\\s*" + $('#perfilfilter .filter_column .select_filter').val() + "\\s*$", 4, true);
    oTable.fnFilter(
      "^" +
        $("#perfilfilter .filter_column .select_filter")
          .val()
          .replace("%20", " ") +
        "$",
      4,
      true
    );
    $("#perfilfilter .filter_column .select_filter option[value='']").remove();
  });
  // $('#estadofilter .filter_column .select_filter').change(function(){
  //   oTable.fnFilter( "^" + $('#estadofilter .filter_column .select_filter').val() + "$", 5, true);
  //  $("#estadofilter .filter_column .select_filter option[value='']").remove();
  //});
  $(".callback").fancybox({
    autoDimensions: false,
    width: 400,
    height: 130,
    autoScale: false,
    overlayOpacity: 0.1,
    transitionIn: "elastic",
    transitionOut: "fade",
    speedIn: 500,
    hideOnOverlayClick: false,
    overlayColor: "#000",
    showCloseButton: false,
    padding: 0,
    margin: 0,
  });
  $(".callback2").fancybox({
    autoDimensions: false,
    width: 400,
    height: 130,
    autoScale: false,
    overlayOpacity: 0.1,
    transitionIn: "elastic",
    transitionOut: "fade",
    speedIn: 500,
    hideOnOverlayClick: false,
    overlayColor: "#000",
    showCloseButton: false,
    padding: 0,
    margin: 0,
  });
});

function getAlumnos(id) {
  $.ajax({
    type: "POST",
    url: "index.php?controlador=ManageUsers&accion=ajaxAlumnos",
    dataType: "json",
    data: {
      idTutor: id,
    },
    success: function (data) {
      console.log(data);
      if (data.alumnos !== null) {
        $("#asignados").empty();
        $(".no-result1").empty();
        data.alumnos.forEach(function (element) {
          $("#asignados").append(
            `<option value="${element.id}">${element.nombre}</option>`
          );
        });
      } else {
        $("#asignados").empty();
        $(".no-result1").empty().prepend("No se encontraron resultados");
      }
      if (data.noasignados !== null) {
        $("#noasignados").empty();
        $(".no-result").empty();
        data.noasignados.forEach(function (element) {
          $("#noasignados").append(
            `<option value="${element.id}">${element.nombre}</option>`
          );
        });
      } else {
        $("#noasignados").empty();
        $(".no-result").empty().prepend("No se encontraron resultados");
      }
    },
  });
}

jQuery.fn.dataTableExt.oSort["format-date-asc"] = function (a, b) {
  var x = a == "-" ? 0 : a.replace("-", "").replace("-", "");
  var y = b == "-" ? 0 : b.replace("-", "").replace("-", "");
  return x - y;
};

jQuery.fn.dataTableExt.oSort["format-date-desc"] = function (a, b) {
  var x = a == "-" ? 0 : a.replace("-", "").replace("-", "");
  var y = b == "-" ? 0 : b.replace("-", "").replace("-", "");
  return y - x;
};
var oTable;

function confirmfunction(id) {
  $("#nombrecalldel").html($("#" + id).attr("callback"));
  $(".callback").trigger("click");
  $("#accept").click(function () {
    $.ajax({
      type: "POST",
      url: $("#" + id).attr("tar"),
      dataType: "json",
      data: {
        verify: $("#" + id).attr("verify"),
      },
      success: function (data) {
        if (data.res == "si") {
          $("#state" + data.idrow)
            .html("")
            .append(
              '<img class="delete" src="images/disable.png" title="inactivo"/>'
            );
          $("#" + id).removeAttr("tar");
          $.fancybox.close();
          $("#" + id).removeAttr("onclick");
          $("#" + id).unbind("click");
          $("#" + id).remove();
          $("#otrootro" + data.idrow)
            .html("")
            .append(
              '(<a id="' +
                data.ididid +
                '"\n\
                          callback="' +
                data.nombre +
                '"\n\
                          tar="index.php?controlador=ManageUsers&accion=enableUser" \n\
                          onclick="confirmfunction2($(this).attr(\'id\'))" \n\
                          verify="' +
                data.verify +
                '" \n\
                          href="#"\n\
                          style="cursor: pointer; color: #005500; font-weight: bold;">activar</a>)'
            );
          message("Se ha inactivado el usuario", "images/iconos_alerta/ok.png");
        } else {
          $.fancybox.close();
          message(
            "No se pudo inactivar el usuario",
            "images/iconos_alerta/error.png"
          );
        }
      },
    });
  });
  $("#cancel").click(function () {
    $.fancybox.close();
  });
}

function confirmfunction2(id) {
  $("#nombrecalldel2").html($("#" + id).attr("callback"));
  $(".callback2").trigger("click");
  $("#accept2").click(function () {
    $.ajax({
      type: "POST",
      url: $("#" + id).attr("tar"),
      dataType: "json",
      data: {
        verify: $("#" + id).attr("verify"),
      },
      success: function (data) {
        if (data.res == "si") {
          $("#state" + data.idrow)
            .html("")
            .append(
              '<img class="delete" src="images/enable.png" title="activo"/>'
            );
          $("#" + id).removeAttr("tar");
          $.fancybox.close();
          $("#" + id).removeAttr("onclick");
          $("#" + id).unbind("click");
          $("#" + id).remove();
          $("#otrootro" + data.idrow)
            .html("")
            .append(
              '(<a id="' +
                data.ididid +
                '"\n\
                          callback="' +
                data.nombre +
                '"\n\
                          tar="index.php?controlador=ManageUsers&accion=disableUser" \n\
                          onclick="confirmfunction($(this).attr(\'id\'))" \n\
                          verify="' +
                data.verify +
                '" \n\
                          href="#"\n\
                          style="cursor: pointer; color: #005500; font-weight: bold;">inactivar</a>)'
            );
          message("Se ha activado el usuario", "images/iconos_alerta/ok.png");
        } else {
          $.fancybox.close();
          message(
            "No se pudo activar el usuario",
            "images/iconos_alerta/error.png"
          );
        }
      },
    });
  });
  $("#cancel2").click(function () {
    $.fancybox.close();
  });
}

function createData(
  id,
  nombre,
  alias,
  cedula,
  perfil,
  estado,
  grupo,
  fehaingreso,
  idcode,
  idverify
) {
  var addId = $("#mytable")
    .dataTable()
    .fnAddData([
      nombre,
      alias,
      id,
      cedula,
      perfil,
      "<div id='state" +
        id +
        "' style='height: 0px'> \n\
          <img class='delete' src='images/enable.png'/>\n\
          </div>\n\
          <div id='otrootro" +
        id +
        "' style='height: 4px'>\n\
          (<a id='dell" +
        idcode +
        "' \n\
          callback='" +
        nombre +
        "'\n\
          tar='index.php?controlador=ManageUsers&accion=disableUser'\n\
          verify='" +
        idverify +
        "'\n\
          href='#'\n\
          onclick='confirmfunction($(this).attr('id'))'\n\
          style='cursor: pointer; color: #005500; font-weight: bold;'>inactivar</a></div>)",
      fehaingreso,
      "<a class='various4" +
        id +
        "' title='Editar usuario' href='index.php?controlador=ManageUsers&accion=editUser&iduser=" +
        id +
        "' style='width: 15px; margin-left: auto; margin-right: auto;'>" +
        "<img src='images/edit.png' width='22px' height='22px' title='ver detalles'/></a>",
      "<a class='various2" +
        id +
        "' title='Cambiar perfil' href='index.php?controlador=ManageUsers&accion=editProfile&iduser=" +
        id +
        "' style='width: 15px; margin-left: auto; margin-right: auto;'>\n\
              <img src='images/user_group.png' width='22px' height='22px' title='Cambiar perfil'/></a>",
    ]);
  var theNode = $("#mytable").dataTable().fnSettings().aoData[addId[0]].nTr;
  theNode.setAttribute("id", id);
  $(".various4" + id).fancybox({
    width: 1100,
    height: 450,
    autoScale: false,
    transitionIn: "elastic",
    transitionOut: "elastic",
    speedIn: 500,
    type: "iframe",
    hideOnOverlayClick: false,
  });
  $(".various2" + id).fancybox({
    width: 600,
    height: 190,
    autoScale: false,
    transitionIn: "elastic",
    transitionOut: "elastic",
    speedIn: 500,
    type: "iframe",
    hideOnOverlayClick: false,
  });
}

function updatedata(id, nombre, cedula) {
  $("#nombre" + id).html(nombre);
  $("#cedula" + id).html(cedula);
}

function updatedata2(id, perfil) {
  $("#perfil" + id).html(perfil);
}
