 

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
    "lengthMenu": [ [10, 50, 100, 500, -1], [10, 50, 100, 500, "All"] ],
    "pageLength": 100,
    'scrollX': true,
    "scrollCollapse": true,
    "autoWidth": false,
    "order": [] ,
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
       
    }
});

// $('.datatable').removeClass('dataTable')

$('#download-files-btn').on('click', function () {
    $(".temp-hide").remove(); 
    let filteredData = table.rows({ search: 'applied' }).data();
    // Extract the IDs from the filtered data
    let filteredIds = filteredData.map(rowData => rowData['DT_RowId'] );
    let idsArr =[]; 
    filteredIds.map(rowData => {
        idsArr.push(rowData)     
    }) 
    for(i=0; i<idsArr.length; i++){
        $("#download-all-files-form").append('<input type="hidden" name="ids[]" value="'+idsArr[i]+'" class="temp-hide">')
    }
});
</script>

</body>

</html>