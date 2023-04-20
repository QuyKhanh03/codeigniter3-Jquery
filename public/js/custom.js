$(document).ready(function () {
	listProjects();
	//show modal add+edit
	$("body").on("click", ".showModal", function (e) {
		$("#modalProject").modal("show");
		$(".title_header").text("Thêm project");
		$("#form")[0].reset();
		$('input[name="id"]').val('');
	});
	
	// edit
	$("body").on("click", ".editItem", function (e) {

		$("#modalProject").modal();
		$(".title_header").html("Sửa Project");
		$("#form")[0].reset();
		var id = $(this).attr("data-id");
		$.ajax({
			url: "http://project.test/index.php/project/edit/" + id,
			type: "GET",
			dataType: "json",
			success: function (response) {
				$(".text-danger").remove();
				$.each(response, function (i, item) {
					$('[name="' + i + '"]').val(item);
				});
			},
		});
		$("#submit").on("click", function (e) {
			e.preventDefault();
			update(id);
		})
	});

	$("body").on("click", "#submit", function (e) {
		e.preventDefault();
		let id = $('input[name="id"]').val();
		let url;
		if (id) {
			url = 'http://project.test/index.php/project/update/' + id;
		}else{
			url = 'http://project.test/index.php/project/create';
		}
		$.ajax({
			url: url,
			type: "POST",
			dataType: "json",
			data: $("#form").serialize(),
			success: function (response) {
				$(".text-danger").remove();
				if (response.response == "success") {
					toastr["success"](response.message);
					table.ajax.reload(null, false);
					$("#modalProject").modal("hide");
				} else {
					$.each(response.errors, function (i, item) {
						$('[name="' + i + '"]').after(
							'<span class="text-danger">' + item + "</span>"
						);
					});
				}
			},
		});
	});


	//delete
	$("body").on("click", ".removeItem", function (e) {
		e.preventDefault();
		var id = $(this).attr("data-id");
		if (confirm("Are you sure you want to delete this?")) {
			$.ajax({
				url: "http://project.test/delete/" + id,
				type: "POST",
				dataType: "json",
				success: function (data) {
					toastr[data.response](data.message);

					if (data.response == "success") {
						table.ajax.reload(null, false);
					}
				},
			});
		}
	});
});

function listProjects() {
	table = $("#table").DataTable({
		processing: true, //Feature control the processing indicator.
		serverSide: true, //Feature control DataTables' server-side processing mode.
		order: [], //Initial no order.

		// Load data for the table's content from an Ajax source
		ajax: {
			url: "http://project.test/listProjects",
			type: "POST",
		},

		//Set column definition initialisation properties.
		columnDefs: [
			{
				targets: [0], //first column / numbering column
				orderable: false, //set not orderable
			},
		],
	});
}
