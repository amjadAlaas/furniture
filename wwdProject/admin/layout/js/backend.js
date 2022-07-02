$(document).ready(function () {

    'use strict';

    //Dashboard

    $('.toggle-info').click(function () {

        $(this).toggleClass('selected').parent().next('.card-body').slideToggle();

        if($(this).hasClass('selected')){

            $(this).html('<i class="fa fa-arrow-circle-up fa-lg"></i>');

        }else{

            $(this).html('<i class="fa fa-arrow-circle-down fa-lg"></i>');

        }

    });

    //index when click on input
    $('[placeholder]').focus(function (){

        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');

    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));

    });

    // Convert Password

    var passField= $('.password')
    $('.show-pass').hover(function () {

        passField.attr('type', 'text');

    }, function (){

            passField.attr('type', 'password');

    });
    // confirmatio Button To Delete Record 
    $('.confirm').click(function () {
        return confirm('Are You sure?!');
    });

    // Category View Option

    $('.cat h3').click(function () {

        $(this).next('.full-view').slideToggle(300);

    });
    $('.option span').click(function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if($(this).data('view') === 'full'){

            $('.cat .full-view').slideDown(300);

        }else{

            $('.cat .full-view').slideUp(300);

        }

    });
});