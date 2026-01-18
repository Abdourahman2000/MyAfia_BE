<script>
    function printExternal(url) {
        let bodyWidth = $('html').width();
        let bodyHeight = $('html').height();
        var printWindow = window.open(url, 'Print', "left=0, top=0, width=" + bodyWidth + ", height=" + bodyHeight +
            ", toolbar=0, resizable=0");

        printWindow.addEventListener('load', function() {
            if (Boolean(printWindow.chrome)) {
                printWindow.print();
                setTimeout(function() {
                    printWindow.close();
                }, 500);
            } else {
                printWindow.print();
                printWindow.close();
            }
        }, true);
    }
</script>
