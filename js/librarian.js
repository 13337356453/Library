$(function(){
    $('#menu h2').on('click', function(){
        $(this).next('ul').slideToggle();
    });
    $iframe=$("iframe");
    $("#new_b").click(function () {
        $iframe.attr('src','/include/newBook.php');
        $iframe.css('display','block');
        }
    );
    $("#down_b").click(function () {
        $iframe.attr('src','/include/downBook.php');
        $iframe.css('display','block');
    });
    $("#book_msg").click(function () {
        $iframe.attr('src','/include/bookSetting.php');
        $iframe.css('display','block');
    });
    $("#log").click(function () {
        $iframe.attr('src','/include/borrowingLog.php');
        $iframe.css('display','block');
    });
    $("#back_book").click(function () {
        $iframe.attr('src','/include/backBook.php');
        $iframe.css('display','block');
    });
});