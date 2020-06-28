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
                
                
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/monhoc/delete_muctieumonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        alert(data)
                        if(index == arr.length - 1)
                        {
                            window.location.reload();
                            // ref = $CFG->wwwroot . '/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php';
                            // window.location.href =  M.cfg.wwwroot + '/blocks/educationpgrs/pages/monhoc/them_decuongmonhoc.php';
                        }
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
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/bacdt/delete_bdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length-1) {
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Something wrong!');
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
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/bacdt/clone_bdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length-1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
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
            
            $("#btn_delete_caykkt").click(function () {
		        var list_id = [];
		        var allElement = document.getElementsByClassName("ckktcheckbox");
		        for (var i = 0; i < allElement.length; ++i) {
		          var item = allElement[i];
		          if (item.value == "1") {
		            list_id.push(item.name);
		          }
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
		              alert("Something wrong!");
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

                        for(var i in rsx){
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
		              alert("Something wrong!");
                    });
                    
              });
            
              function get_monhoc(mamonhoc){
                    $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/get_monhoc_tu_mamonhoc.php", {
                        mamonhoc: mamonhoc
                    })
                    .done(function (data) {
                        var rsx = JSON.parse(data)
                        
                        if(rsx.mamonhoc != null  && rsx.mamonhoc != ''){
                            
                            document.getElementById("id_tenmonhoc1_thongtinchung").value = rsx.tenmonhoc_vi;
                            document.getElementById("id_tenmonhoc2_thongtinchung").value = rsx.tenmonhoc_en;
                            document.getElementById("id_masomonhoc_thongtinchung").value = rsx.mamonhoc;
                            document.getElementById("id_loaihocphan").value = rsx.loaihocphan;
                            document.getElementById("id_sotinchi_thongtinchung").value = rsx.sotinchi;
                            document.getElementById("id_tietlythuyet_thongtinchung").value = rsx.sotietlythuyet;
                            document.getElementById("id_tietthuchanh_thongtinchung").value = rsx.sotietthuchanh;
                            // document.getElementById("id_montienquyet_thongtinchung").value = null;
                            document.getElementById("id_mota").value = rsx.mota;
                        }else{
                            document.getElementById("id_tenmonhoc1_thongtinchung").value = null;
                            document.getElementById("id_tenmonhoc2_thongtinchung").value = null;
                            document.getElementById("id_masomonhoc_thongtinchung").value = null;
                            document.getElementById("id_loaihocphan").value = null;
                            document.getElementById("id_sotinchi_thongtinchung").value = null;
                            document.getElementById("id_tietlythuyet_thongtinchung").value = null;
                            document.getElementById("id_tietthuchanh_thongtinchung").value = null;
                            // document.getElementById("id_montienquyet_thongtinchung").value = null;
                            document.getElementById("id_mota").value = null;
                        }
                    })
                    .fail(function () {
                        alert("Something wrong!");
                    });
              }

              $("#id_tuychon_mon").change(function () {
		        
		        var mamonhoc = $("#id_tuychon_mon option:selected").text();
                
                
		        $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/decuong/get_monhoc_tu_mamonhoc.php", {
                    mamonhoc: mamonhoc
		          })
                .done(function (data) {
                    var rsx = JSON.parse(data)
                    
                    if(rsx.mamonhoc != null  && rsx.mamonhoc != ''){
                        
                        document.getElementById("id_tenmonhoc1_thongtinchung").value = rsx.tenmonhoc_vi;
                        document.getElementById("id_tenmonhoc2_thongtinchung").value = rsx.tenmonhoc_en;
                        document.getElementById("id_masomonhoc_thongtinchung").value = rsx.mamonhoc;
                        document.getElementById("id_loaihocphan").value = rsx.loaihocphan;
                        document.getElementById("id_sotinchi_thongtinchung").value = rsx.sotinchi;
                        document.getElementById("id_tietlythuyet_thongtinchung").value = rsx.sotietlythuyet;
                        document.getElementById("id_tietthuchanh_thongtinchung").value = rsx.sotietthuchanh;
                        // document.getElementById("id_montienquyet_thongtinchung").value = null;
                        document.getElementById("id_mota").value = rsx.mota;
                    }else{
                        document.getElementById("id_tenmonhoc1_thongtinchung").value = null;
                        document.getElementById("id_tenmonhoc2_thongtinchung").value = null;
                        document.getElementById("id_masomonhoc_thongtinchung").value = null;
                        document.getElementById("id_loaihocphan").value = null;
                        document.getElementById("id_sotinchi_thongtinchung").value = null;
                        document.getElementById("id_tietlythuyet_thongtinchung").value = null;
                        document.getElementById("id_tietthuchanh_thongtinchung").value = null;
                        // document.getElementById("id_montienquyet_thongtinchung").value = null;
                        document.getElementById("id_mota").value = null;
                    }
                })
                .fail(function () {
                    alert("Something wrong!");
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
                console.log('xin chao viet nam', list_id)
                
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/decuong/delete_decuongmonhoc.php', {
                        course: 1,
                        id: element
                    }).done(function (data) {
                        alert(data)
                        if(index == arr.length - 1)
                        {
                            window.location.reload();

                        }
                    }).fail(function () {
                        alert('Something wrong!');
                    });
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
		              alert("Something wrong!");
		            });
		        });
		      });
		      
		      $("#id_mamonhoc").change(function () {
			        // Get BDT
			        var mamonhoc = $("#id_mamonhoc option:selected").text();
			        // Get HDT with BDT
			        $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/lopmo/get_lopmo_from_mamonhoc.php", {
			          course: 1,
			          mamonhoc: mamonhoc,
			        })
			          .done(function (data) {
			            var list_lopmo = JSON.parse(data);
			            var x = document.getElementById("id_lopmo");
			            // Remove all options
			            while (x.length > 0) {
			              x.remove(x.length - 1);
			            }
			            var count = 1;
			            list_lopmo.forEach((item) => {
			              var option = document.createElement("option");
			              option.text = item;
			              option.value = item;
			              x.add(option);
			            });
			          })
			          .fail(function () {
			            alert("Something wrong!");
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
			              alert("Something wrong!");
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
			            alert("Something wrong!");
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
			            // var list_monhoc = JSON.parse(data.monhoc);
			            console.log(data.monhoc);
			            console.log(data.ctdt);
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
			
			            var x = document.getElementById("id_mamonhoc");
			            // Remove all options
			            while (x.length > 0) {
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
			            alert("Something wrong!");
			          });
			      });
				
				/// CayKKT
            $("#btn_addcaykkt_delete_khoi").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if(list_id.length > 1){
                    alert('Vui lòng ch?n m?t kh?i');
                } else{
                    var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/caykkt/newcaykkt_addfuntion.php', {
                        id: list_id[0],
                        type: 3,
                        paramfirst: ma_khoi
                    }).done(function () {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                }
            });

            $("#btn_addcaykkt_add_khoi").click(function () {
                var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                if(ma_khoi != '0'){
                    var list_id = [];
                    var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                    for (var i = 0; i < allElement.length; ++i) {
                        var item = allElement[i];
                        if (item.value == '1') {
                            list_id.push(item.name);
                        }
                    }
                    if(list_id.length > 1){
                        alert('Vui lòng ch?n m?t kh?i');
                    } else{
                        $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/caykkt/newcaykkt_addfuntion.php', {
                            id: allElement && allElement[0] || "nocheck",
                            type: 1,
                            paramfirst: ma_khoi
                        }).done(function (data) {
                            location.reload(true);
                        }).fail(function () {
                            alert('Something wrong!');
                        });
                    }
                } else{
                    alert('Không có kh?i nào du?c ch?n');
                }
            });

            $("#btn_addcaykkt_addkhoi_asChild").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('add_caykkt_checkbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                if(list_id.length > 1){
                    alert('Vui lòng ch?n m?t kh?i');
                } else{
                    var ma_khoi = $("#id_select_ma_khoi option:selected").text();
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/caykkt/newcaykkt_addfuntion.php', {
                        id: allElement[0],
                        type: 2,
                        paramfirst: ma_khoi
                    }).done(function () {
                        location.reload(true);
                    }).fail(function () {
                        alert('Something wrong!');
                    });
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
                if(list_id.length > 1){
                    alert('Vui lòng ch?n m?t kh?i');
                } else{
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
                        alert('Something wrong!');
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
                if(list_id.length > 1){
                    alert('Vui lòng ch?n m?t kh?i');
                } else{
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
                        alert('Something wrong!');
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
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/nganhdt/clone_nganhdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length-1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Something wrong!');
                    });
                });
            });
            
            $("#btn_clone_chuyennganhdt").click(function () {
                var list_id = [];
                var allElement = document.getElementsByClassName('chuyennganhdtcheckbox');
                for (var i = 0; i < allElement.length; ++i) {
                    var item = allElement[i];
                    if (item.value == '1') {
                        list_id.push(item.name);
                    }
                }
                list_id.forEach((element, index, arr) => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/chuyennganhdt/clone_chuyennganhdt.php', {
                        id: element
                    }).done(function (data) {
                        if (index == arr.length-1) {
                            // alert(arr[index]);
                            location.reload(true);
                        }
                    }).fail(function () {
                        alert('Something wrong!');
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
			              alert("Something wrong!");
			            });
			        });
			      });
        }
    };
});
