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
define(["jquery"], function ($) {
  return {
    init: function () {
      // Put whatever you like here. $ is available
      // to you as normal.
      $("#id_select_loaikhoi").change(function() {
        // alert(1359);
        // Get BDT
        // var loaikhoi = $( "#id_mabac option:selected" ).text();
        // // Get HDT with BDT
        // if(loaikhoi == "Bắt buộc"){
        //   alert(1359);
        //   document.getElementById('fgroup_id_gtxt_loaikhoi').hidden = true;
        //   document.getElementById('id_gtxt_loaikhoi').hidden = true;
        // }else if(loaikhoi == 0){
        //   //document.getElementById('id_select_codieukien').hidden = true;
        //   //document.getElementById('id_gtxt_loaikhoi').hidden = true;
        // }
      });
      $("#btn_open_form_insert_bacdt").click(function () {
        alert("Progress will insert three new BDT!");
        // Call to file php in ajax directory
        // Ajax call to get the results.
      });
      $("#btn_delete_hedt").click(function () {
        var list_id = [];
        var cusid_ele = document.getElementsByClassName("hdtcheckbox");
        for (var i = 0; i < cusid_ele.length; ++i) {
          var item = cusid_ele[i];

          if (item.value == "1") {
            list_id.push(item.name);
          }
        }
        console.log(list_id);
        // get all elemeent by class
        // Call to file php in ajax directory
        // Ajax call to get the results.

        list_id.forEach((element) => {
          $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/delete_hdt.php", {
            course: 1,
            id: element,
          })
            .done(function (data) {
              alert(data);
            })
            .fail(function () {
              alert("Something wrong!");
            });
        });
      }); // end del
      $("#btn_delete_bacdt").click(function () {
        var list_id = [];
        var cusid_ele = document.getElementsByClassName("bdtcheckbox");
        for (var i = 0; i < cusid_ele.length; ++i) {
          var item = cusid_ele[i];

          if (item.value == "1") {
            list_id.push(item.name);
          }
        }
        console.log(list_id);
        // get all elemeent by class
        // Call to file php in ajax directory
        // Ajax call to get the results.

        list_id.forEach((element) => {
          $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/delete_bdt.php", {
            course: 1,
            id: element,
          })
            .done(function (data) {
              alert(data);
            })
            .fail(function () {
              alert("Something wrong!");
            });
        });
      }); // end del

      $("#btn_delete_khoahoc").click(function () {
        var list_id = [];
        var cusid_ele = document.getElementsByClassName("khoahoccheckbox");
        for (var i = 0; i < cusid_ele.length; ++i) {
          var item = cusid_ele[i];
          if (item.value == "1") {
            list_id.push(item.name);
          }
        }
        list_id.forEach((element) => {
          $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/delete_khoahoc.php", {
            course: 1,
            id: element,
          })
            .done(function (data) {
              // alert(data);
            })
            .fail(function () {
              alert("Something wrong!");
            });
        });
        location.reload(true);
      }); // end del

      //delete nien khoa
      $("#btn_delete_nienkhoa").click(function () {
        var list_id = [];
        var cusid_ele = document.getElementsByClassName("nienkhoacheckbox");
        for (var i = 0; i < cusid_ele.length; ++i) {
          var item = cusid_ele[i];
          if (item.value == "1") {
            list_id.push(item.name);
          }
        }
        list_id.forEach((element) => {
          $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/delete_nienkhoa.php", {
            course: 1,
            id: element,
          })
            .done(function (data) {
              // alert(data);
            })
            .fail(function () {
              alert("Something wrong!");
            });
        });
        location.reload(true);
      }); // end del

      $("#btn_delete_ctdt").click(function () {
        // alert("hi");
        var list_id = [];
        var cusid_ele = document.getElementsByClassName("ctdtcheckbox");
        for (var i = 0; i < cusid_ele.length; ++i) {
          var item = cusid_ele[i];
          if (item.value == "1") {
            list_id.push(item.name);
          }
        }
        list_id.forEach((element) => {
          $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/delete_ctdt.php", {
            course: 1,
            id: element,
          })
            .done(function (data) {
              // alert(data);
            })
            .fail(function () {
              alert("Something wrong!");
            });
        });
        location.reload(true);
      }); // end del

      $("#btn_delete_kkt").click(function () {
        // alert("hi");
        var list_id = [];
        var cusid_ele = document.getElementsByClassName("kktcheckbox");
        for (var i = 0; i < cusid_ele.length; ++i) {
          var item = cusid_ele[i];
          if (item.value == "1") {
            list_id.push(item.name);
          }
        }
        list_id.forEach((element) => {
          $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/delete_kkt.php", {
            course: 1,
            id: element,
          })
            .done(function (data) {
              // alert(data);
              location.reload(true);

            })
            .fail(function () {
              alert("Something wrong!");
            });
        });
      }); // end del

      $("#btn206").click(function () {
        alert("Handler for .click() called.");
      });

      $("#btn_insert_bacdt").click(function () {
        alert("Progress will insert three new BDT!");
        // Call to file php in ajax directory
        // Ajax call to get the results.
        $.post(M.cfg.wwwroot + "/blocks/educationpgrs/ajax/insert_bdt.php", {
          course: 1,
        })
          .done(function (data) {
            alert(data);
          })
          .fail(function () {
            alert("Something wrong!");
          });
      });
    },
  };
});
