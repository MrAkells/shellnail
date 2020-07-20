<footer id="footer"><?php echo $text_footer; ?><br /><?php echo $text_version; ?>
    
    <div id="scroll-top" class="hidden-xs" title='На верх страницы'><i class='fa fa-arrow-up' style='font-size: 2em; color: white'></i> </div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#scroll-top").hide();
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 300) {
                    $('#scroll-top').fadeIn();
                } else {
                $('#scroll-top').fadeOut();
                }
            });
            $('#scroll-top').click(function () {
            $('body,html').animate({scrollTop: 0}, 800);
            return false;
        });
    });
});
</script>
    
</footer>
</div>
</body>
</html>
