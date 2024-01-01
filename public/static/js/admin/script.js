$('.view-item .content').DataTable();
$('.dataTables_length select').append('<option value="5">5</option>');
// Make option value 5 is default
$('.dataTables_length select option[value="5"]').attr('selected', 'selected');
// reload this script
$('.dataTables_length select').change();