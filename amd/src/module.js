// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    block_quick_course
 * @copyright  2019 Conn Warwicker <conn@cmrwarwicker.com>
 * @link       https://github.com/cwarwicker/moodle-block_quick_course
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery'], function ($) {
    return {
        init: function () {
            $("#btn_open_form_insert_bacdt").click(function () {
                alert("Progress will insert three new BDT!");
            });

            $("#id_select_mabac").change(function () {
                // Get BDT
                var bdt = $("#id_select_mabac option:selected").text();
                // Get HDT with BDT
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/hedt/get_hdt_from_bdt.php', {
                    course: 1,
                    bdt: bdt
                }).done(function (data) {
                    var list_mahe = JSON.parse(data);
                    var x = document.getElementById('id_mahe');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    var count = 1;
                    list_mahe.forEach(mahe => {
                        var option = document.createElement("option");
                        option.text = mahe;
                        option.value = mahe;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Something wrong!');
                });
            });

            $("#btn_delete_muctieumonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('muctieumonhoc_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_muctieumonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_chuandauramonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('chuandaura_monhoc_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_chuandauramonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_khgdltmonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('kehoachgiangday_LT_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_kehoachgiangday.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_danhgiamonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('danhgiamonhoc_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_danhgiamonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_tainguyenmonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('tainguyenmonhoc_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_tainguyenmonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_quydinhchungmonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('quydinhchung_monhoc_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_quydinhchungmonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_hedt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('hdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/hedt/delete_hdt.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_bacdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('bdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/bacdt/delete_bdt.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_nganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('nganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/delete_nganhdt.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_chuyennganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('chuyennganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/delete_chuyennganhdt.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });

            $("#btn_delete_khoahoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("khoahoccheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/khoahoc/delete_khoahoc.php", {
                        course: 1,
                        id: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Something wrong!");
                    });
                });
                location.reload(true);
            });

            $("#btn_delete_nienkhoa").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("nienkhoacheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/nienkhoa/delete_nienkhoa.php", {
                        course: 1,
                        id: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Something wrong!");
                    });
                });
            });

            $("#btn_delete_ctdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("ctdtcheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/ctdt/delete_ctdt.php", {
                        course: 1,
                        id: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Something wrong!");
                    });
                });
            });

            $("#btn_delete_kkt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("kktcheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/kkt/delete_kkt.php", {
                        course: 1,
                        id: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Something wrong!");
                    });
                });
            });

            $("#btn_delete_monhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("monhoc_checkbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/monhoc/delete_monhoc.php", {
                        course: 1,
                        id: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Something wrong!");
                    });
                });
            });
            
            $("#btn_remove_subject_from_list_mon").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("kktlistmon");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/kkt/delete_monthuockhoi_global.php", {
                        mamonhoc: element
                    }).done(function (data) {
                        //location.reload(true);
                    }).fail(function () {
                        alert("Something wrong!");
                    });
                });
            });
            
            $("#id_select_bacdt").change(function () {
                // Get BDT
                var bdt = $("#id_select_bacdt option:selected").text();
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/hedt/get_hdt_from_bdt.php', {
                    course: 1,
                    bdt: bdt
                }).done(function (data) {
                    var list_mahe = JSON.parse(data);
                    var x = document.getElementById('id_select_hedt');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    var count = 1;
                    list_mahe.forEach(ma_he => {
                        var option = document.createElement("option");
                        option.text = ma_he;
                        option.value = ma_he;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Something wrong!');
                });
            });

            $("#id_select_hedt").change(function () {
                // Get BDT
                var ma_he = $("#id_select_hedt option:selected").text();
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nienkhoa/get_nienkhoa_from_hedt.php', {
                    course: 1,
                    ma_he: ma_he
                }).done(function (data) {
                    var list_mahe = JSON.parse(data);
                    var x = document.getElementById('id_select_nienkhoa');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    var count = 1;
                    list_mahe.forEach(ma_nienkhoa => {
                        var option = document.createElement("option");
                        option.text = ma_nienkhoa;
                        option.value = ma_nienkhoa;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Something wrong!');
                });
            });

            $("#id_select_nienkhoa").change(function () {
                // Get BDT
                var ma_nienkhoa = $("#id_select_nienkhoa option:selected").text();
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/get_nganh_from_nienkhoa.php', {
                    course: 1,
                    ma_nienkhoa: ma_nienkhoa
                }).done(function (data) {
                    var list_mahe = JSON.parse(data);
                    var x = document.getElementById('id_select_nganh');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    var count = 1;
                    list_mahe.forEach(ma_nganh => {
                        var option = document.createElement("option");
                        option.text = ma_nganh;
                        option.value = ma_nganh;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Something wrong!');
                });
            });

            $("#id_select_nganh").change(function () {
                // Get BDT
                var ma_nganh = $("#id_select_nganh option:selected").text();
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/get_chuyennganh_from_nganh.php', {
                    course: 1,
                    ma_nganh: ma_nganh
                }).done(function (data) {
                    var list_mahe = JSON.parse(data);
                    var x = document.getElementById('id_select_chuyennganh');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    var count = 1;
                    list_mahe.forEach(ma_chuyennganh => {
                        var option = document.createElement("option");
                        option.text = ma_chuyennganh;
                        option.value = ma_chuyennganh;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Something wrong!');
                });
            });
        }
    };
});