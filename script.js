$(document).ready(function () {
    // Fungsi untuk menampilkan pesan alert
    function showAlert(message, type) {
        const alertBox = $('<div class="alert-box"></div>')
            .addClass('fixed top-4 left-1/2 transform -translate-x-1/2 bg-' + (type === 'success' ? 'green' : 'red') + '-500 text-white p-4 rounded-md shadow-md')
            .text(message);
        $('body').append(alertBox);

        setTimeout(function () {
            alertBox.fadeOut(function () {
                $(this).remove();
            });
        }, 3000); // Pesan hilang setelah 3 detik
    }

    function fetchImages() {
        $.ajax({
            url: 'fetch_images.php',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const imageList = $('#imageList');
                imageList.empty();

                data.forEach(image => {
                    const listItem = `
               
                      <li class="bg-white rounded-lg shadow p-4 flex items-center border border-gray-200">
                                    <img src="uploads/${image.file_name}" alt="${image.name}" class="w-16 h-16 object-cover rounded-md">
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">${image.name}</h3>
                                        <div class="mt-2 space-x-2">
                                            <button class="edit-btn bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 text-sm" 
                                                data-id="${image.id}" 
                                                data-name="${image.name}">
                                                Edit
                                            </button>
                                            <button class="delete-btn bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 text-sm" 
                                                data-id="${image.id}">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </li>

                    `;
                    imageList.append(listItem);
                });

                bindActions();
            }
        });
    }

    function bindActions() {
        $('.edit-btn').click(function () {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#action').val('edit');
            $('#id').val(id);
            $('#name').val(name);
        });

        $('.delete-btn').click(function () {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this image?')) {
                $.ajax({
                    url: 'image_actions.php',
                    method: 'POST',
                    data: { action: 'delete', id: id },
                    success: function (response) {
                        const result = JSON.parse(response);
                        if (result.status === 'success') {
                            fetchImages();
                            showAlert(result.message, 'success');
                        } else {
                            showAlert(result.message, 'error');
                        }
                    }
                });
            }
        });
    }

    $('#imageForm').submit(function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        $.ajax({
            url: 'image_actions.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    fetchImages();
                    $('#imageForm')[0].reset();
                    $('#action').val('add'); // reset action ke tambah
                    showAlert(result.message, 'success');
                } else {
                    showAlert(result.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                showAlert('An error occurred: ' + error, 'error');
            }
        });
    });

    fetchImages();
});
