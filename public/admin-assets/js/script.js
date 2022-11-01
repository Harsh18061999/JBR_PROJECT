/* Common Delete */
function deleteRecord(id, url) {
	swal({
		title: "Are you sure?",
		text: "This entry will be permanently deleted!!",
		icon: 'warning',
		buttons: [
			'No, cancel it!',
			'Yes, I am sure!'
		],
	}).then(function(isConfirm) {
		if (isConfirm) {
			$.ajax({
				type: 'GET',
				url: url,
				success: function(response) { 
					if(response.status) {
						swal({
							title: 'Deleted!',
							text: "This entry has been deleted.",
							type: 'success',
							icon: 'success',
						});
						setTimeout(function(){ location.reload(true); }, 2000);
					} else {
						var msg = (response.message) ? response.message : "Invalid record.";
						swal({
							title: 'Error!',
							text: msg,
							type: 'error',
							icon: 'error'
						});
					}
				}
			});
		}
	});
}

$(document).ready(function() {

	$('.mainmenu').addClass('js-enabled');
	$('.mainmenu .hs-menu-flow-horizontal').before('<a class="mobile-trigger"><i></i></a>');
	$('.mainmenu .hs-item-has-children > a').after('<a class="child-triggerm"><span></span></a>');
	$('a.mobile-trigger').click(function() {
	$(this).next('.mainmenu .hs-menu-flow-horizontal').slideToggle(250);
	$('body').toggleClass('mobile-open');
	$('a.child-triggerm').removeClass('child-open');
	$('.hs-menu-children-wrapper').slideUp(250);
	return false;
	});

	$('.mainmenu a.child-triggerm').click(function() {
	  $(this).parent().siblings('.hs-item-has-children').find('a.child-triggerm').removeClass('child-open');
	  $(this).parent().siblings('.hs-item-has-children').find('.hs-menu-children-wrapper').slideUp(250);
	  $(this).parent().siblings('.hs-item-has-children').removeClass('child_open');
	  $(this).next('.hs-menu-children-wrapper').slideToggle(250);
	  $(this).next('.hs-menu-children-wrapper').children('.hs-item-has-children').find('.hs-menu-children-wrapper').slideUp(250);
	  $(this).next('.hs-menu-children-wrapper').children('.hs-item-has-children').find('a.child-triggerm').removeClass('child-open');
	  $(this).toggleClass('child-open');
	  $(this).parent().toggleClass('child_open');
	  return false;
	});

 });