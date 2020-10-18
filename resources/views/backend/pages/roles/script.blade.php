<script>

	function checkPermissionByGroup(groupName, groupCheckbox){
		if($(groupCheckbox).is(':checked')) {
			$(`input.${groupName}`).prop('checked', true);
		} else {
			$(`input.${groupName}`).prop('checked', false);
		}

	}

	function checkGroupCheckbox(groupName) {
		let totalInGroup = $(`.${groupName}`).length;
		let totalChecked = 0;
		
		$(`.${groupName}`).each((i, el) => {
			if ($(el).prop('checked')) {
				totalChecked++;
			}
		})

		if (totalChecked == totalInGroup) {
			$(`#${ groupName }-checkbox`).prop('checked', true)
		}else{
			$(`#${ groupName }-checkbox`).prop('checked', false)
		}
	}

	function checkAllCheckbox() {
		let count = {{ count($groups) }};
		let checkedValue = 0

		$('.permission-group-checkbox').each((i,groupEl) => {
			if($(groupEl).prop('checked')){
				checkedValue++
			}
	    })

		if(checkedValue == count) {
		   $('.all-checkbox').prop('checked',true)
		}else{
		   $('.all-checkbox').prop('checked',false)

		}
	}

	checkAllCheckbox();


	$("#checkPermissionAll").click(function (){
		if($(this).is(':checked')){
			$('input[type=checkbox]').prop('checked', true);
		}else{
			$('input[type=checkbox]').prop('checked', false);
		}
	});


	$('.permission-checkbox').on('change', function (e) {
		let groupClassName = `${ $(this).attr('data-group-name') }`
		checkGroupCheckbox(groupClassName)
		checkAllCheckbox()
	})


	$('.permission-group-checkbox').on('change', function(e){
		let groupClassName = `${$(this).attr('data-group-name')}`
		checkGroupCheckbox(groupClassName)
		checkAllCheckbox()
	})
	
/*End*/

	$(".creteRoleForm").submit(function(e){
		e.preventDefault();
		 let data = $(this).serialize();
		$.ajax({
			url :"{{ route('roles.store') }}" ,
			type:'POST',
			data:data,
			success:function(response){
				if(response.status){
					$('input[type=checkbox]').prop('checked', false);
					$("#role").val('');
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.addEventListener('mouseenter', Swal.stopTimer)
							toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					})

					Toast.fire({
						icon: 'success',
						title: 'Role create successfully!'
					})
				}else{
					const Toast = Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
						didOpen: (toast) => {
							toast.addEventListener('mouseenter', Swal.stopTimer)
							toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					})

					Toast.fire({
						icon: 'warning',
						title: response.message
					})
				}
			},
			error:function(error){
				console.log(error)
			}
		});
	});

</script>
