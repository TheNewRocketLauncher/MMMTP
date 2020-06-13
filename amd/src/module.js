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

            $("#id_mabac").change(function () {
                // Get BDT
                var bdt = $("#id_mabac option:selected").text();
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
        }
    };
});