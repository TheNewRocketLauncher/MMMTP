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
                }).done(function (response) {
                    var data = JSON.parse(response);

                    var id_bacdt = document.getElementById("id_bacdt");
                    id_bacdt.value = data.tenbac;

                    var x = document.getElementById('id_mahe');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    data.hedt.forEach(mahe => {
                        var option = document.createElement("option");
                        option.text = mahe;
                        option.value = mahe;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Có lỗi xảy ra!');
                });
            });

            $("#id_mahe").change(function () {
                // Get HDT
                var bdt = $("#id_mabac option:selected").text();
                var hdt = $("#id_mahe option:selected").text();
                // Get NKDT with HDT
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nienkhoa/get_nienkhoadt_from_hdt.php', {
                    course: 1,
                    hdt: hdt,
                    bdt: bdt,
                }).done(function (response) {
                    var data = JSON.parse(response);

                    var id_hedt = document.getElementById("id_hedt");
                    id_hedt.value = data.tenhe;

                    var x = document.getElementById('id_manienkhoa');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    data.nienkhoadt.forEach(manienkhoa => {
                        var option = document.createElement("option");
                        option.text = manienkhoa;
                        option.value = manienkhoa;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Có lỗi xảy ra!');
                });
            });

            $("#id_manienkhoa").change(function () {

                // Get HDT
                var bdt = $("#id_mabac option:selected").text();
                var hdt = $("#id_mahe option:selected").text();
                var nienkhoadt = $("#id_manienkhoa option:selected").text();
                // Get NKDT with HDT
                console.log("nienkhoadt: ", nienkhoadt);
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/get_nganhdt_from_nienkhoadt.php', {
                    course: 1,
                    nienkhoadt: nienkhoadt,
                    hdt: hdt,
                    bdt: bdt
                }).done(function (response) {
                    var data = JSON.parse(response);
                    console.log(data);
                    var id_nienkhoadt = document.getElementById("id_nienkhoa");
                    // id_nienkhoadt.value = data.tennienkhoa;
                    id_nienkhoadt.value = data.tennienkhoa;

                    var x = document.getElementById('id_manganh');
                    // Remove all options
                    while (x.length > 0) {
                        x.remove(x.length - 1);
                    }
                    data.nganhdt.forEach(manganh => {
                        var option = document.createElement("option");
                        option.text = manganh;
                        option.value = manganh;
                        x.add(option);
                    });
                }).fail(function () {
                    alert('Có lỗi xảy ra!');
                });
            });

            $("#id_machuyennganh").change(function () {

                var ma_chuyennganh = $("#id_machuyennganh option:selected").text();
                // Get HDT with BDT
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/get_tenchuyennganh.php', {
                    course: 1,
                    ma_chuyennganh: ma_chuyennganh
                }).done(function (response) {
                    // var data = JSON.parse(response);
                    // console.log(response);

                    var id_chuyennganhdt = document.getElementById("id_chuyenganhdt");
                    // id_chuyennganhdt.value = data.ten_chuyennganh;
                    id_chuyennganhdt.value = response;


                }).fail(function () {
                    alert('Có lỗi xảy ra!');
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


                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_muctieumonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {

                        if (index == arr.length - 1) {
                            window.location.reload();
                            // ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php';
                            // window.location.href =  M.cfg.wwwroot + '/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php';
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
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
                        alert('Có lỗi xảy ra!');
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
                        alert('Có lỗi xảy ra!');
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
                        alert('Có lỗi xảy ra!');
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
                        alert('Có lỗi xảy ra!');
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
                        alert('Có lỗi xảy ra!');
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
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/hedt/delete_hdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });

            $("#btn_clone_hedt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('hdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/hedt/clone_hdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
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
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/bacdt/delete_bdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });

            $("#btn_clone_bacdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('bdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/bacdt/clone_bdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });

            $("#btn_delete_nganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('nganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++ i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/delete_nganhdt.php', {id: element}).done(function (data) {
                        if (data != 'Success') {
                            alert(data);
                        } else if (index == arr.length - 1) {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });

            delete_nganhdt_thuoc_khoatuyen = function (ma_nienkhoa) {
                var list_id = [];
                var allElement = document.getElementsByClassName('nganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++ i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/delete_nganhdt_thuoc_khoatuyen.php', {
                        id: element,
                        ma_nienkhoa: ma_nienkhoa
                    }).done(function (data) {
                        if (index == arr.length - 1) { // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            }

            // Wait

            delete_ctdt_thuoc_nganh = function (ma_nganh) {
                var list_id = [];
                var allElement = document.getElementsByClassName('ctdtcheckbox');
                for (var i = 0; i < allElement.length; ++ i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/ctdt/delete_ctdt_thuoc_nganh.php', {
                        id: element,
                        ma_nganh: ma_nganh
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            }


            $("#btn_delete_chuyennganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('chuyennganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/delete_chuyennganhdt.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
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
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }

                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/nienkhoa/delete_nienkhoa.php", {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        if (data != 'Success') {
                            alert(data);
                        } else if (index == arr.length - 1) {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert("Có lỗi xảy ra!");
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
                        id: element,
                    }).done(function (data) {
                    
                        var result = JSON.parse(data);
                        if (result['error' == 1]) {
                            alert(result['errorMess']);
                        } else {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert("Có lỗi xảy ra!");
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
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/kkt/delete_kkt.php", {
                        course: 1,
                        ma_khoi: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Có lỗi xảy ra!");
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

                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/monhoc/delete_monhoc.php", {
                        course: 1,
                        id: element,
                    }).done(function (data) {
                        location.reload(true);
                    }).fail(function () {
                        alert("Có lỗi xảy ra!");
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
                        alert("Có lỗi xảy ra!");
                    });
                });
            });

            $("#btn_delete_caykkt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("ckktcheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element) => {
                    // alert(element);
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/caykkt/delete_caykkt.php", {
                            course: 1,
                            id: element,
                        })
                        .done(function (data) {
                            alert(data);
                            alert("off");
                            location.reload(true);
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });




            $("#id_tuychon_ctdt").change(function () {
                var list_id = [];
                var ma_ctdt = $("#id_tuychon_ctdt option:selected").text();


                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/get_monhoc_tu_ctdt.php", {
                        ma_ctdt: ma_ctdt
                    })
                    .done(function (data) { //array mamonhoc
                        var rsx = JSON.parse(data)

                        var x = document.getElementById('id_tuychon_mon');
                        // Remove all options
                        while (x.length > 0) {
                            x.remove(x.length - 1);
                        }

                        for (var i in rsx) {
                            var mamonhoc = rsx[i]

                            var option = document.createElement("option");
                            option.text = mamonhoc;
                            option.value = mamonhoc;
                            x.add(option);
                        }

                        //call function

                        get_monhoc(rsx[0])
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });

            });

            function get_monhoc(mamonhoc) {
                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/get_monhoc_tu_mamonhoc.php", {
                        mamonhoc: mamonhoc
                    })
                    .done(function (data) {
                        var rsx = JSON.parse(data)

                        if (rsx.mamonhoc != null && rsx.mamonhoc != '') {

                            document.getElementById("id_tenmonhoc1_thongtinchung").value = rsx.tenmonhoc_vi;
                            document.getElementById("id_tenmonhoc2_thongtinchung").value = rsx.tenmonhoc_en;
                            document.getElementById("id_masomonhoc_thongtinchung").value = rsx.mamonhoc;
                            document.getElementById("id_loaihocphan").value = rsx.loaihocphan;
                            document.getElementById("id_sotinchi_thongtinchung").value = rsx.sotinchi;
                            document.getElementById("id_tietlythuyet_thongtinchung").value = rsx.sotietlythuyet;
                            document.getElementById("id_tietthuchanh_thongtinchung").value = rsx.sotietthuchanh;
                            // document.getElementById("id_montienquyet_thongtinchung").value = null;
                            // document.getElementById("id_mota_decuong").value = rsx.mota;
                        } else {
                            document.getElementById("id_tenmonhoc1_thongtinchung").value = null;
                            document.getElementById("id_tenmonhoc2_thongtinchung").value = null;
                            document.getElementById("id_masomonhoc_thongtinchung").value = null;
                            document.getElementById("id_loaihocphan").value = null;
                            document.getElementById("id_sotinchi_thongtinchung").value = null;
                            document.getElementById("id_tietlythuyet_thongtinchung").value = null;
                            document.getElementById("id_tietthuchanh_thongtinchung").value = null;
                            // document.getElementById("id_montienquyet_thongtinchung").value = null;
                            // document.getElementById("id_mota_decuong").value = null;
                        }
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });
            }

            $("#id_tuychon_mon").change(function () {

                var mamonhoc = $("#id_tuychon_mon option:selected").text();

                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/get_monhoc_tu_mamonhoc.php", {
                        mamonhoc: mamonhoc
                    })
                    .done(function (data) {
                        console.log(data);
                        var rsx = JSON.parse(data)

                        if (rsx.mamonhoc != null && rsx.mamonhoc != '') {

                            document.getElementById("id_tenmonhoc1_thongtinchung").value = rsx.tenmonhoc_vi;
                            document.getElementById("id_tenmonhoc2_thongtinchung").value = rsx.tenmonhoc_en;
                            document.getElementById("id_masomonhoc_thongtinchung").value = rsx.mamonhoc;
                            document.getElementById("id_loaihocphan").value = rsx.loaihocphan;
                            document.getElementById("id_sotinchi_thongtinchung").value = rsx.sotinchi;
                            document.getElementById("id_tietlythuyet_thongtinchung").value = rsx.sotietlythuyet;
                            document.getElementById("id_tietthuchanh_thongtinchung").value = rsx.sotietthuchanh;
                            // document.getElementById("id_montienquyet_thongtinchung").value = null;
                            // document.getElementById("id_mota_decuong").value = rsx.mota;
                        } else {
                            document.getElementById("id_tenmonhoc1_thongtinchung").value = null;
                            document.getElementById("id_tenmonhoc2_thongtinchung").value = null;
                            document.getElementById("id_masomonhoc_thongtinchung").value = null;
                            document.getElementById("id_loaihocphan").value = null;
                            document.getElementById("id_sotinchi_thongtinchung").value = null;
                            document.getElementById("id_tietlythuyet_thongtinchung").value = null;
                            document.getElementById("id_tietthuchanh_thongtinchung").value = null;
                            // document.getElementById("id_montienquyet_thongtinchung").value = null;
                            // document.getElementById("id_mota_decuong").value = null;
                        }
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });

            });




            $("#btn_delete_lopmo").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("lopmocheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/delete_lopmo.php", {
                            course: 1,
                            id: element,
                        })
                        .done(function (data) {
                            location.reload(true);
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });

            $("#id_mamonhoc1").change(function () {
        // Get BDT
        var mamonhoc = $("#id_mamonhoc1 option:selected").text();
        var ma_ctdt = $("#id_ma_ctdt option:selected").text();

        // Get HDT with BDT
        $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/get_lopmo_from_mamonhoc.php", {
            course: 1,
            ma_ctdt: ma_ctdt,
            mamonhoc: mamonhoc,
          })
          .done(function (data) {
            // console.log(data);
            var res = JSON.parse(data);

            var fullname = document.getElementById("id_fullname");
            var shortname = document.getElementById("id_shortname");

            fullname.value = res["ten"];
            shortname.value = res["tenviettat"];
          })
          .fail(function () {
            alert("Có lỗi xảy ra!");
          });
      });
            $("#btn_clone_lopmo").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("lopmocheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/clone_lopmo.php", {
                            id: element,
                        })
                        .done(function (data) {
                            if (index == arr.length - 1) {
                                location.reload(true);
                            }
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });

            $("#id_btn_get_fullname").click(function () {
                // Get BDT

                var tenlopmo = document.getElementById("id_tenlopmo").value;

                console.log(tenlopmo);
                var mamonhoc = $("#id_mamonhoc option:selected").text();
                var ma_ctdt = $("#id_ma_ctdt option:selected").text();
                // Get HDT with BDT

                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/get_fullname_from_tenlopmo.php", {
                        course: 1,
                        ma_ctdt: ma_ctdt,
                        mamonhoc: mamonhoc,
                    })
                    .done(function (data) {
                        // var saaa = JSON.parse(data);
                        document.getElementById("id_fullname").value = JSON.parse(data) + " - " + tenlopmo;
                        document.getElementById("id_shortname").value = mamonhoc + " - " + tenlopmo;
                        // x.val = saaa;
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });
            });

            $("#id_ma_ctdt").change(function () {
                // Get BDT
                var ma_ctdt = $("#id_ma_ctdt option:selected").text();
                // Get HDT with BDT
                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/get_mamonhoc_from_ma_ctdt.php", {
                        course: 1,
                        ma_ctdt: ma_ctdt,
                    })
                    .done(function (response) {
                        var data = JSON.parse(response);
                        var id_bacdt = document.getElementById("id_bacdt");
                        var id_hedt = document.getElementById("id_hedt");
                        var id_nienkhoa = document.getElementById("id_nienkhoa");
                        var id_nganh = document.getElementById("id_nganh");
                        var id_chuyennganh = document.getElementById("id_chuyennganh");
                        var id_mota = document.getElementById("id_mota_ctdt");
                        id_bacdt.value = data.ctdt[0];
                        id_hedt.value = data.ctdt[1];
                        id_nienkhoa.value = data.ctdt[2];
                        id_nganh.value = data.ctdt[3];
                        id_chuyennganh.value = data.ctdt[4];
                        id_mota.value = data.ctdt[5];

                        var x = document.getElementById("id_mamonhoc1");
                        // Remove all options
                        while (x.length > 1) {
                            x.remove(x.length - 1);
                        }
                        var count = 1;
                        data.monhoc.forEach((mamonhoc) => {
                            var option = document.createElement("option");
                            option.text = mamonhoc;
                            option.value = mamonhoc;
                            x.add(option);
                        });
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });
            });

            /// CayKKT
            $("#btn_addcaykkt_remove_khoi").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                var id = 'null';
                if (list_id.length != 0) {
                    id = list_id[0];
                    if (list_id.length > 1) {
                        alert('Chỉ được chọn một khối');
                    }
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/caykkt/newcaykkt_addfuntion.php', {
                        id: id,
                        type: 3,
                        paramfirst: 'null'
                    }).done(function () {
                        // console.log(JSON.parse(data));
                        location.reload(true);
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                } else if (list_id.length > 1) {
                    alert('Xin vui lòng chọn một khối');
                }
            });

            $("#id_btn_addcaykkt_add_khoi").click(function () {
                var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                if (ma_khoi != "Chọn khối... ") {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/caykkt/newcaykkt_addfuntion.php', {
                        id: 'nocheck',
                        type: 1,
                        paramfirst: ma_khoi
                    }).done(function () {
                        // console.log(JSON.parse(data));
                        location.reload(true);
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                } else {
                    alert('Vui lòng chọn một khối');
                }
            });

            $("#id_btn_addcaykkt_addkhoi_asChild").click(function () {
                var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                if (ma_khoi != "Chọn khối... ") {
                    var list_id = [];
                    var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                    for (var i = 0; i < allElement.length; ++i) {
                        var item = allElement[i];
                        if (item.value == '1') {
                            list_id.push(item.name);
                        }
                    }
                    if (list_id.length == 0) {
                        alert('Hãy check một khối để làm khối cha');
                    } else if (list_id.length > 1) {
                        alert('Chỉ được check một khối duy nhất');
                        return;
                    } else {
                        var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                        $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/caykkt/newcaykkt_addfuntion.php', {
                            id: list_id[0],
                            type: 2,
                            paramfirst: ma_khoi
                        }).done(function (data) {
                            // console.log(JSON.parse(data));
                            location.reload(true);
                        }).fail(function () {
                            alert('Có lỗi xảy ra!');
                        });
                    }
                } else {
                    alert('Vui lòng chọn một khối');
                }
            });

            $("#btn_addcaykkt_moveUp").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length > 1) {
                    alert('Vui lòng chọn một khối?i');
                } else {
                    var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/get_chuyennganh_from_nganh.php', {
                        id: allElement[0],
                        type: 4,
                        paramfirst: ma_khoi
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
                        alert('Có lỗi xảy ra!');
                    });
                }
            });

            $("#btn_addcaykkt_moveDown").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length > 1) {
                    alert('Vui lòng chọn một khối');
                } else {
                    var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/get_chuyennganh_from_nganh.php', {
                        id: allElement[0],
                        type: 5,
                        paramfirst: ma_khoi
                    }).done(function (data) {
                        var list_mahe = JSON.parse(data);
                        var x = document.getElementById('id_select_chuyennganh');
                        // Remove all optionsbtn_addcaykkt_add_khoi
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
                        alert('Có lỗi xảy ra!');
                    });
                }
            });

            $("#btn_clone_nganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('nganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/clone_nganhdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });
            
            clone_nganhdt_thuoc_khoatuyen = function (ma_nienkhoa) {
                var list_id = [];
                var allElement = document.getElementsByClassName('nganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/clone_nganhdt_thuoc_khoatuyen.php', {
                        id: element,
                        ma_nienkhoa: ma_nienkhoa
                    }).done(function (data) {
                        if (index == arr.length - 1) { // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            }

            clone_ctdt_thuoc_nganh = function (ma_nganh) {
                var list_id = [];
                var allElement = document.getElementsByClassName('ctdtcheckbox');
                for (var i = 0; i < allElement.length; ++ i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/ctdt/clone_ctdt_thuoc_nganh.php', {
                        id: element,
                        ma_nganh: ma_nganh
                    }).done(function (data) {
                        if (index == arr.length - 1) { // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            }

            $("#btn_clone_chuyennganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('chuyennganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/clone_chuyennganhdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });
            $("#btn_clone_nienkhoa").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("nienkhoacheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/nienkhoa/clone_nienkhoa.php", {
                            id: element,
                        })
                        .done(function (data) {
                            if (index == arr.length - 1) {
                                location.reload(true);
                            }
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });

            $("#id_fetch_muctieu").click(function () {

                var ma_decuong = document.getElementById("id_ma_decuong_1").value;


                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/fetch_muctieu.php", {
                        ma_decuong: ma_decuong,
                    })
                    .done(function (data) {

                        var list = JSON.parse(data);
                        var x = document.getElementById("id_muctieu");
                        // Remove all options
                        while (x.length > 0) {
                            x.remove(x.length - 1);
                        }

                        list.forEach((idata) => {
                            var option = document.createElement("option");
                            option.text = idata;
                            option.value = idata;
                            x.add(option);
                        });
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });

            });

            $("#id_fetch_danhsach_cdr").click(function () {



                var ma_decuong = document.getElementById("id_ma_decuong_1").value;


                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/fetch_chuandaura.php", {
                        ma_decuong: ma_decuong,
                    })
                    .done(function (data) {
                        console.log('data', data)
                        var list = JSON.parse(data);
                        var x = document.getElementById("id_danhsach_cdr");
                        // Remove all options
                        while (x.length > 0) {
                            x.remove(x.length - 1);
                        }

                        list.forEach((idata) => {
                            var option = document.createElement("option");
                            option.innerHTML = idata;
                            option.value = idata;

                            x.appendChild(option);
                        });
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });

            });



            $("#id_ma_cdr_cha").change(function () {
                // Get BDT
                var ma_cdr = $("#id_ma_cdr_cha option:selected").text();

                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/chuandaura_ctdt/get_name_from_macdr.php", {
                        ma_cdr: ma_cdr,
                    })
                    .done(function (response) {
                        console.log("res", response);
                        var data = JSON.parse(response);

                        var ten_cdr = document.getElementById("id_ten_cdr");
                        ten_cdr.value = data;
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });
            });

            $("#btn_delete_chuandaura_ctdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("chuandauractdtcheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuandaura_ctdt/delete_chuandaura_ctdt.php', {
                            id: element,
                        })
                        .done(function (data) {
                            result = JSON.parse(data);
                            if (result['error'] == 0) {
                                location.reload(true);
                            } else {
                                alert(result['errorMess']);
                            }
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });
            $("#btn_clone_chuandaura_ctdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("chuandauractdtcheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/chuandaura_ctdt/clone_chuandaura_ctdt.php", {
                            id: element,
                        })
                        .done(function (data) {
                            if (index == arr.length - 1) {
                                location.reload(true);
                            }
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });




            $("#id_fetch_chuandaura").click(function () {



                var ma_decuong = document.getElementById("id_ma_decuong_1").value;


                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/fetch_chuandaura.php", {
                        ma_decuong: ma_decuong,
                    })
                    .done(function (data) {

                        var list = JSON.parse(data);
                        var x = document.getElementById("id_cacchuandaura_danhgia");

                        while (x.length > 0) {
                            x.remove(x.length - 1);
                        }

                        list.forEach((idata) => {
                            var option = document.createElement("option");
                            option.innerHTML = idata;
                            option.value = idata;

                            x.appendChild(option);
                        });
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });

            });

            
            $("#id_fetch_ctdt").click(function () {

                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/thongke/get_ctdt.php", {})
                    .done(function (data) {


                        var list = JSON.parse(data);


                        var x = document.getElementById("id_sort_ctdt");

                        while (x.length > 0) {
                            x.remove(x.length - 1);
                        }

                        list.forEach((idata) => {
                            var option = document.createElement("option");
                            option.text = idata.ma_ctdt;
                            option.value = idata.ma_ctdt;

                            x.add(option);
                        });

                        var ma_bac = document.getElementById("id_ma_bac");
                        var ma_he = document.getElementById("id_ma_he");
                        var ma_nienkhoa = document.getElementById("id_ma_nienkhoa");
                        var ma_nganh = document.getElementById("id_ma_nganh");
                        var ma_chuyennganh = document.getElementById("id_ma_chuyennganh");
                        ma_bac.value = list[0].ma_bac;
                        ma_he.value = list[0].ma_he;
                        ma_nienkhoa.value = list[0].ma_nienkhoa;
                        ma_nganh.value = list[0].ma_nganh;
                        ma_chuyennganh.value = list[0].ma_chuyennganh;


                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });

            });

            $("#id_sort_ctdt").change(function () {
                var ma_ctdt = document.getElementById("id_sort_ctdt").value;


                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/thongke/get_ctdt.php", {
                        ma_ctdt: ma_ctdt,
                    })

                    .done(function (data) {
                        // console.log(data);
                        var list = JSON.parse(data);


                        var ma_bac = document.getElementById("id_ma_bac");
                        var ma_he = document.getElementById("id_ma_he");
                        var ma_nienkhoa = document.getElementById("id_ma_nienkhoa");
                        var ma_nganh = document.getElementById("id_ma_nganh");
                        var ma_chuyennganh = document.getElementById("id_ma_chuyennganh");
                        var ten_chuandaura = document.getElementById("id_ten_chuandaura");

                        ma_bac.value = list[0].ma_bac;
                        ma_he.value = list[0].ma_he;
                        ma_nienkhoa.value = list[0].ma_nienkhoa;
                        ma_nganh.value = list[0].ma_nganh;
                        ma_chuyennganh.value = list[0].ma_chuyennganh;

                        ten_chuandaura.value = list[0].ten_chuandaura;
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });
            });

            $("#btn_clone_monhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('monhoc_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/clone_monhoc.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length - 1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });

            //Clone KKT
            $("#btn_clone_kkt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('kktcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                if (list_id.length == 0) {
                    alert("Vui lòng chọn 1 khối");
                } else if (list_id.length != 1) {
                    alert("Vui lòng chỉ chọn 1 khối")
                } else {
                    window.location.href = M.cfg.wwwroot + '/blocks/educationpgrs/pages/khoikienthuc/edit_kkt.php?ma_khoi=' + list_id[0];
                }
            });

            //Clone CAYKKT
            $("#btn_clone_caykkt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('ckktcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                if (list_id.length == 0) {
                    alert("Vui lòng chọn 1 cây");
                } else if (list_id.length != 1) {
                    alert("Vui lòng chỉ chọn 1 cây")
                } else {
                    window.location.href = M.cfg.wwwroot + '/blocks/educationpgrs/pages/caykkt/edit_caykkt_ttc.php?ma_cay=' + list_id[0];
                }
            });

            //Clone CAYKKT
            $("#btn_clone_ctdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('ctdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }

                if (list_id.length == 0) {
                    alert("Vui lòng chọn 1 ctdt");
                } else if (list_id.length != 1) {
                    alert("Vui lòng chỉ chọn 1 cdtd");
                    return;
                } else {
                    list_id.forEach((element) => {
                        $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/ctdt/clone_ctdt.php?id=' + list_id[0], {
                            id: element
                        }).done(function (data) {
                            location.reload(true);
                        }).fail(function () {
                            alert('Something wrong!');
                        });
                    });
                }
            });

            $("#btn_delete_lopmo").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName("lopmocheckbox");
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == "1") {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach((element) => {
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/delete_lopmo.php", {
                            course: 1,
                            id: element,
                        })
                        .done(function (data) {
                            location.reload(true);
                        })
                        .fail(function () {
                            alert("Có lỗi xảy ra!");
                        });
                });
            });

            $("#btn_delete_decuongmonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('decuong_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để xóa');
                    return;
                }
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/decuong/delete_decuongmonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        console.log(data);
                        location.reload(true);
                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
                });
            });

            $("#btn_clone_decuongmonhoc").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('decuong_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if (list_id.length == 0) {
                    alert('Hãy chọn dữ liệu để sao chép');
                    return;
                }
                if (list_id.length > 1) {
                    alert('Chọn 1 đề cương để tiếp tục thực hiện tác vụ này!');
                    return;
                }
                // list_id.forEach((element, index, arr) => {
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/decuong/clone_decuongmonhoc.php', {
                        id: list_id[0]
                    })
                    .done(function (data) {


                        window.location.href = M.cfg.wwwroot + "/blocks/educationpgrs/pages/monhoc/clone_decuong.php?ma_decuong=" + data;


                    }).fail(function () {
                        alert('Có lỗi xảy ra!');
                    });
            });

            //Chuan dau ra
            $("#id_btn_refresh_chitiet_cdr").click(function () {
                var ma_cay_cdr = $("#id_select_cdr option:selected").text();

                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/chuandaura_ctdt/get_node_cdr.php", {
                        ma_cay_cdr: ma_cay_cdr,
                    })
                    .done(function (data) {
                        var rsx = JSON.parse(data);

                        var x = document.getElementById('id_select_cdr_node');
                        // Remove all options
                        while (x.length > 1) {
                            x.remove(x.length - 1);
                        }

                        for (var i in rsx) {
                            var item = rsx[i]

                            var option = document.createElement("option");
                            option.text = item['value'] + " " + item['text'];
                            option.value = item['value'];
                            x.add(option);
                        }
                    })
                    .fail(function () {
                        alert("Có lỗi xảy ra!");
                    });
            });

            $("#id_select_cdr").change(function () {


            });

            // Chuẩn đầu ra
            $("#btn_del_node_cdr").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('cdr_checkbox');

                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }

                if (list_id.length != 0) {
                    var id = document.getElementById("id_cdr");
                    list_id.forEach((element) => {
                        $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuandaura_ctdt/delete_node_cdr.php', {
                            id: id.value,
                            id_con: element,
                        }).done(function (data) {
                            result = JSON.parse(data);
                            location.reload(true);
                            if (result['error'] == 0) {
                                // location.reload(true);
                            } else {
                                alert(result['errorMess']);
                            }
                        }).fail(function () {
                            alert('Lỗi không xác định!');
                        });
                    })
                } else {
                    alert('Không có node nào được chọn');
                }
            });

            // Xoá Chuẩn đầu ra từ page chitiet
            $("#btn_del_cdr").click(function () {
                var ma_cay_cdr = document.getElementById("id_select_cdr");
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuandaura_ctdt/delete_cdr.php', {
                    ma_cay_cdr: ma_cay_cdr.value,
                }).done(function (data) {
                    result = JSON.parse(data);
                    if (result['error'] == 0) {
                        window.location.href = M.cfg.wwwroot + "/blocks/educationpgrs/pages/chuandauractdt/index.php";
                    } else {
                        alert(result['errorMess']);
                    }
                }).fail(function () {
                    alert('Lỗi không biết!');
                });
            });

            $("#id_btn_edit_cdr").click(function () {
                var id = document.getElementById("id_cdr");
                window.location.href = M.cfg.wwwroot + "/blocks/educationpgrs/pages/chuandauractdt/update.php?id=" + id.value;
            });

            $("#id_btn_add_node_cdr").click(function () {
                var id = document.getElementById("id_cdr");
                var ten = document.getElementById("id_txt_ten");
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuandaura_ctdt/add_cdr_to_cdr.php', {
                    id: id.value,
                    ten: ten.value,
                }).done(function (data) {
                    result = JSON.parse(data);
                    if (result['error'] == 0) {

                    } else {
                        alert(result['errorMess']);
                    }
                    window.location.href = M.cfg.wwwroot + "/blocks/educationpgrs/pages/chuandauractdt/add_cdr.php?id=" + id.value;

                }).fail(function () {
                    alert('Lỗi không biết!');
                });
            });
            $("#btn_update_quyen").click(function () {
        var list_id = [];
        var allElement = document.getElementsByClassName("quyencheckbox");
        for (var i = 0; i < allElement.length; ++i) {
          var item = allElement[i];
          if (item.value == "1") {
            list_id.push(item.id);
          }
        }
        var url = window.location.href;
        var inx = url.indexOf("=");
        var role_id = url.slice(inx + 1, inx + 3);
        var list_quyen_id = list_id.toString();
        $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/quyen/update_quyen.php", {
          list_quyen_id: list_quyen_id,
          role_id,
        })
          .done(function (data) {
            // console.log(data);
            location.reload(true);
          })
          .fail(function () {
            alert("Có lỗi xảy ra!");
          });
        // });
      });



            $("#id_tuychon_mon_batky").click(function () {
                
                var mamonhoc = document.getElementById("id_tuychon_mon_batky").value;
                
                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/get_chitietmonhoc_from_eb_monhoc.php", {
                    mamonhoc: mamonhoc
                })
                .done(function (data) {
                    
                    var rsx = JSON.parse(data)

                    if (rsx.mamonhoc != null && rsx.mamonhoc != '') {

                        document.getElementById("id_tenmonhoc1_thongtinchung").value = rsx.tenmonhoc_vi;
                        document.getElementById("id_tenmonhoc2_thongtinchung").value = rsx.tenmonhoc_en;
                        document.getElementById("id_masomonhoc_thongtinchung").value = rsx.mamonhoc;
                        document.getElementById("id_loaihocphan").value = rsx.loaihocphan;
                        document.getElementById("id_sotinchi_thongtinchung").value = rsx.sotinchi;
                        document.getElementById("id_tietlythuyet_thongtinchung").value = rsx.sotietlythuyet;
                        document.getElementById("id_tietthuchanh_thongtinchung").value = rsx.sotietthuchanh;
                        // document.getElementById("id_montienquyet_thongtinchung").value = null;
                        // document.getElementById("id_mota_decuong").value = rsx.mota;
                    } else {
                        document.getElementById("id_tenmonhoc1_thongtinchung").value = null;
                        document.getElementById("id_tenmonhoc2_thongtinchung").value = null;
                        document.getElementById("id_masomonhoc_thongtinchung").value = null;
                        document.getElementById("id_loaihocphan").value = null;
                        document.getElementById("id_sotinchi_thongtinchung").value = null;
                        document.getElementById("id_tietlythuyet_thongtinchung").value = null;
                        document.getElementById("id_tietthuchanh_thongtinchung").value = null;
                        // document.getElementById("id_montienquyet_thongtinchung").value = null;
                        // document.getElementById("id_mota_decuong").value = null;
                    }

                })
                .fail(function () {
                    alert("Có lỗi xảy ra!");
                });
                // });
            });



            $("#id_eb_nganhdt").change(function () {
                
                var ma_nganh = $("#id_eb_nganhdt option:selected").text();

                $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/ctdt/get_pdf_from_nganh.php", {
                    ma_nganh: ma_nganh
                })
                .done(function (data) {
                    
                    
                    var result = JSON.parse(data);
                    console.log(result);

                })
                .fail(function () {
                    alert("Có lỗi xảy ra!");
                });
                // });
            });
            
            $("#id_fetch_chuandaura_cdio_muctieumonhoc").click(function () {
        var ma_ctdt = document.getElementById("id_ma_ctdt_1").value;

        $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/chuandaura_ctdt/get_cdr_from_ctdt.php", {
          ma_ctdt: ma_ctdt,
        })
          .done(function (data) {
            var list = JSON.parse(data);
            console.log("data:", list);
            var x = document.getElementById("id_chuandaura_cdio_muctieumonhoc");

            while (x.length > 0) {
              x.remove(x.length - 1);
            }

            list.forEach((idata) => {
              var option = document.createElement("option");
              option.innerHTML = idata.ten;
              option.value = idata.ma_tt;

              x.appendChild(option);
            });
          })
          .fail(function () {
            alert("Có lỗi xảy ra!");
          });
      });
        }
    };
});