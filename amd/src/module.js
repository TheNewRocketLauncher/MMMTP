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
            $("#btn_delete_bacdt").click(function() {
                alert("Progress will delete BDT!");
                // Call to file php in ajax directory
                // Ajax call to get the results.
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/delete_bdt.php', {
                course: 1,
                id_bac: 1
            }).done(function(data){
                alert(data);
            }).fail(function(){
                alert('Something wrong!');
            });
              });


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


              $("#btn_delete_decuong").click(function() {
                alert("Progress will delete Đề cương!");
                // Call to file php in ajax directory
                // Ajax call to get the results.
                $.post(M.cfg.wwwroot + '/blocks/educationpgrs/ajax/delete_decuong.php', {
                course: 1,
                //ma_monhoc: abc;
            }).done(function(data){
                alert(data);
            }).fail(function(){
                alert('Something wrong!');
            });
              }); 
              
            
        }
    };
});
