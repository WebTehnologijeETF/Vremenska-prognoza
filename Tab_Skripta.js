/**
 * Created by Haris on 9.4.2015.
 */
//KOD PREUZET S INTERNETA!

$(document).ready(function() {
    $('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = $(this).attr('href');

        $('.tabs ' + currentAttrValue).show().siblings().hide();

        $(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();
    });
});