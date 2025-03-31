function handleCrud(createRoute,storeRoute,showRoute,editRoute,updateRoute,destroyRoute,tableTarget,modalTitles,paginationRoute,csrf) {
    // Create
    $('.add').on('click', function() {
        $.get(createRoute, function(data) {
            $('#modal-title').html(modalTitles.create);
            $('#Form input[name="_method"][value="PUT"]').remove();
            $('.submit').html('Save');
            $('.create_edit_modal_content').html(data);
            $('#Form').attr('action', storeRoute);
            $('#create_edit_modal').modal('show');
        }).fail(function(xhr, textStatus, errorThrown) {
            if (xhr.status === 403) {
                toastr.error(xhr.responseJSON.message || 'Permission denied.');
            }
        });
    });

    // View
    window.view = function(id) {
        $.get(showRoute.replace(':id', id), function(data) {
            $('.show_content').html(data);
            $('#showModal').modal('show');
        }).fail(function(xhr, textStatus, errorThrown) {
            if (xhr.status === 403) {
                toastr.error(xhr.responseJSON.message || 'Permission denied.');
            }
        });
    }

    // Edit
    window.edit = function(id) {
        $.get(editRoute.replace(':id', id), function(data) {
            $('#modal-title').html(modalTitles.edit);
            $('#Form').attr('method', 'POST');
            $('#Form').attr('action', updateRoute.replace(':id', id));
            $('#Form input[name="_method"]').remove();
            $('#Form').append('<input type="hidden" name="_method" value="PUT">');
            $('.create_edit_modal_content').html(data);
            $('.submit').html('Update');
            $('#create_edit_modal').modal('show');
        }).fail(function(xhr, textStatus, errorThrown) {
            if (xhr.status === 403) {
                toastr.error(xhr.responseJSON.message || 'Permission denied.');
            }
        });
    }

    // Delete
    window.destroy = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e6533c',
            cancelButtonColor: '#000',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: destroyRoute.replace(':id', id),
                    type: "DELETE",
                    data: {
                        _token: csrf
                    },
                    dataType: "JSON",
                    success: function(response) {
                        fetch_data(page, query);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 403) {
                            toastr.error(xhr.responseJSON.message || 'Permission denied.');
                        }else{
                            toastr.error('An error occurred: ' + error, 'Error!');
                        }
                    }
                });
            }
        })
    }

    $(".submit").click(function(e) {
        e.preventDefault();
        let form = $('#Form')[0];
        let data = new FormData(form);
        let id = $('#id').val();
        let type = $('#type').val();
        let url = type == 1 ? storeRoute : updateRoute.replace(':id', id);
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "JSON",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.error').text('');
                $('.form-control').removeClass('input-error');
            },
            success: function(response) {
                if (response.errors) {
                    var errorMsg = '';
                    $.each(response.errors, function(field, errors) {
                        console.log(field);
                        console.log(errors);
                        
                        //$.each(errors, function(index, error) {
                            $('#error-' + field).html(errors[0]);
                            $('#' + field).addClass('input-error');
                            //errorMsg += error + '<br>';
                        //});
                    });
                    //toastr.error('An error occurred: ' + errorMsg, 'Error!');
                } else {
                    $('#create_edit_modal').modal('hide');
                    toastr.success(response.success, 'Success!');
                    fetch_data(page, query);
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred: ' + error, 'Error!');
            }
        });
    });

    // Pagination and search
    var page;
    var query;

    function fetch_data(page, query) {
        $.ajax({
            url: paginationRoute + '?page=' + page,
            data: {
                'query': query,
            },
        }).done(function(response) {
            if (tableTarget==='tbodyBTransaction') {
                $('#bank-transaction').html(response);
            }else{
                $(tableTarget).html(response);
            }
            let dataRows = $(tableTarget).find('tr').not(':last-child').filter(function () {
                return !$(this).hasClass('empty-row');
            });
            if (dataRows.length === 0 && page > 1) {
                page--;
                $('#hidden_page').val(page);
                fetch_data(page, query);
            }
        }).fail(function() {
            console.log("Failed to load data!");
        });
    }

    $('#search').on('keyup', function() {
        page = $('#hidden_page').val();
        query = $('#search').val();
        fetch_data(page, query);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        page = $(this).attr('href').split('page=')[1];
        query = $('#search').val();
        fetch_data(page, query);
    });
}
