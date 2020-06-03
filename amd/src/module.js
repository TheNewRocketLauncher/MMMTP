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
define(['jquery'], function($) { 
    return {
        init: function() {
 
            // Put whatever you like here. $ is available
            // to you as normal.
            $("#btn_open_form_insert_bacdt").click(function() {
                alert("Progress will insert three new BDT!");
                // Call to file php in ajax directory
                // Ajax call to get the results.
                
              });
            $("#btn_delete_hedt").click(function() {
                var list_id = [];
                var cusid_ele = document.getElementsByClassName('hdtcheckbox');
                for (var i = 0; i < cusid_ele.length; ++i) {
                    var item = cusid_ele[i];  
                    
                    if(item.value == '1')
                    {
                        list_id.push(item.name);
                    }
                }
                console.log(list_id)
                // get all elemeent by class
                // Call to file php in ajax directory
                // Ajax call to get the results.
                
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/delete_hdt.php', {
                        course: 1,
                        id: element
                    }).done(function(data){
                        alert(data);
                    }).fail(function(){
                        alert('Something wrong!');
                    });
                    
                });



                
            }); // end del
            $("#btn_delete_bacdt").click(function() {
                var list_id = [];
                var cusid_ele = document.getElementsByClassName('bdtcheckbox');
                for (var i = 0; i < cusid_ele.length; ++i) {
                    var item = cusid_ele[i];  
                    
                    if(item.value == '1')
                    {
                        list_id.push(item.name);
                    }
                }
                console.log(list_id)
                // get all elemeent by class
                // Call to file php in ajax directory
                // Ajax call to get the results.
                
                list_id.forEach(element => {
                    $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/delete_bdt.php', {
                        course: 1,
                        id: element
                    }).done(function(data){
                        alert(data);
                    }).fail(function(){
                        alert('Something wrong!');
                    });
                    
                });



                
              }); // end del
            $("#btn206").click(function() {
                alert("Handler for .click() called.");
              });

            $("#btn_insert_bacdt").click(function() {
                alert("Progress will insert three new BDT!");
                // Call to file php in ajax directory
                // Ajax call to get the results.
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/insert_bdt.php', {
                course: 1
            }).done(function(data){
                alert(data);
            }).fail(function(){
                alert('Something wrong!');
            });
              });

              
            
        }
    };
});
// define(['jquery'], function($) {

//     var module = {};

//     module.bind = function(){        

//         // Clear results.
//         $('#btn206').off('click').on('click', function(){
//             alert("Jquery! The paragraph was clicked.");
//         });

//     };

//     module.init = function(){
//         module.bind();
//     };
//     return module;

// });