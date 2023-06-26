/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// var path = location.pathname.split("/");
// var url = location.origin + "/" + path[1];
var path = location.pathname.split("/");
var url = location.origin + "/" + path[1];
var base_url = location.origin;
var urlid = path[2];

$("ul.sidebar-menu li a").each(function () {
  if ($(this).attr("href").indexOf(url) !== -1) {
    $(this)
      .parent()
      .addClass("active")
      .parent()
      .parent("li")
      .addClass("active");
  }
});
//dataTables
// $("#table-2").dataTable();
//alert
// function submitDel(id) {
//   $("#del-" + id).submit();
// }

function returnLogout() {
  var link = $("#logout").attr("href");
  $(location).attr("href".link);
}

function tglIndo(string) {
  bulanIndo = [
    "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
  ];

  tanggal = string.split("-")[2];
  bulan = string.split("-")[1];
  tahun = string.split("-")[0];

  return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
}
$(function ($) {
  "use strict";
  // $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
  //     jqXHR.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrfToolsCallProcedure"]').attr("content"));
  // });
  // $.ajaxSetup({
  //     headers: {
  //         "X-CSRF-TOKEN": $('meta[name="csrfToolsCallProcedure"]').attr("content")
  //     },
  //     dataType: "json",
  //     statusCode: {
  //         // 500: function () {
  //         //     alertError('Server mengalami masalah.', false, false)
  //         // },
  //         // 403: function () {
  //         //     alertError('Tindakan yang Anda minta tidak diperbolehkan.', false, false)
  //         // }
  //     }
  // });
  // global error datatables
  // $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
  //     if (settings.jqXHR.status == 403) {
  //         if (settings.jqXHR.responseJSON) {
  //             loadPage(settings.jqXHR.responseJSON.ResponseRedirect);
  //         } else {
  //             var data = JSON.parse(settings.jqXHR.responseText);
  //             loadPage(data.ResponseRedirect);
  //         }
  //     }
  // };

  // $.extend(true, $.fn.dataTableExt.oApi, {
  //     fnPagingInfo: function (oSettings) {
  //         return {
  //             iStart: oSettings._iDisplayStart,
  //             iEnd: oSettings.fnDisplayEnd(),
  //             iLength: oSettings._iDisplayLength,
  //             iTotal: oSettings.fnRecordsTotal(),
  //             iFilteredTotal: oSettings.fnRecordsDisplay(),
  //             iPage: Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
  //             iTotalPages: Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
  //         };
  //     }
  // });
  // $.extend(true, $.fn.dataTable.defaults, {
  //     language: {
  //         processing: "loading...",
  //         search: "Cari:",
  //         lengthMenu: "Menampilkan _MENU_ data",
  //         info: "Menampilkan _START_ - _END_ dari total _TOTAL_ data",
  //         infoEmpty: "Tidak ada data yang ditampilkan",
  //         infoFiltered: "(dari total _MAX_ data)",
  //         zeroRecords: "Tidak ada hasil pencarian ditemukan",
  //         emptyTable: "Data masih kosong",
  //         paginate: {
  //             first: "<i class='bx bx-chevrons-left' ></i>",
  //             last: "<i class='bx bx-chevrons-right' ></i>",
  //             next: "<i class='bx bx-chevron-right' ></i>",
  //             previous: "<i class='bx bx-chevron-left' ></i>",
  //         }
  //     },
  //     processing: true,
  //     serverSide: true,
  //     bLengthChange: false,
  //     dom: "lrtip",
  //     iDisplayLength: 10,
  //     deferRender: true,
  //     searching: true,
  //     rowCallback: function (row, data, iDisplayIndex) {
  //         var info = this.fnPagingInfo();
  //         var page = info.iPage;
  //         var length = info.iLength;
  //         $("td:eq(0)", row).html();
  //     },
  //     drawCallback: function (settings) {
  //         $('[data-bs-toggle="tooltip"]').tooltip();
  //     }
  // });

  // jquery validate


});
