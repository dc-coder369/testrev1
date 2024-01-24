 

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <!-- <script src="assets/vendor/simple-datatables/simple-datatables.js"></script> -->
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/crypto-js.js"></script>
  <script src="assets/js/dataTables.min.js"></script> 
<script type="text/javascript">
 
var table = new DataTable('.datatable', {
    initComplete: function () {
        this.api().columns().every(function () {
            let column = this;
            let title = column.footer().textContent;

            // Create input element
            let input = document.createElement('input');
            input.placeholder = title;
            column.footer().replaceChildren(input);

            // Event listener for user input
            input.addEventListener('keyup', () => {
                if (column.search() !== this.value) {
                    column.search(input.value).draw();
                }
            });
        });

        // Add sorting arrows to the header
        $('.datatable thead th').each(function () {
            var title = $(this).text();
            $(this).html(title + ' <i class="fas fa-sort"></i>');
        });

        // Handle click event for sorting arrows
        $('.datatable thead th').click(function () {
            var column = table.column($(this).index());
            var order = column.order()[0];
            var icon = order == 1 ? 'fas fa-sort-up' : 'fas fa-sort-down';
            console.log("order",icon)
            // Remove sorting arrows from other columns
            $('.datatable thead th').not(this).find('i').removeClass('fas fa-sort-up fas fa-sort-down');

            // Toggle sorting arrow for the clicked column
            $(this).find('i').removeClass('fas fa-sort-up fas fa-sort-down').addClass(icon);
        });
    }
});

$('.datatable').removeClass('dataTable')

$('#download-files-btn').on('click', function () {

    $(".temp-hide").remove(); 
    // Get the data of the filtered rows
    let filteredData = table.rows({ search: 'applied' }).data();
 
    // Extract the IDs from the filtered data
    let filteredIds = filteredData.map(rowData => rowData['DT_RowId'] );
    let idsArr =[]; 
    filteredIds.map(rowData => {
        idsArr.push(rowData)     
    })
    console.log("idsArr", idsArr)

    for(i=0; i<idsArr.length; i++){
        $("#download-all-files-form").append('<input type="hidden" name="ids[]" value="'+idsArr[i]+'" class="temp-hide">')
       
    }
    
 
});

</script>

</body>

</html>