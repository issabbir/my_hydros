<footer class="footer footer-static footer-light">
	<p class="clearfix mb-0"><span class="float-left d-inline-block">2019 &copy; Chittagong Port Authority</span><span
				class="float-right d-sm-inline-block d-none">
			Operation and Maintenance by<a class="text-primary font-weight-bold"
			           href="https://site.cnsbd.com"
			           target="_blank">
				<img src="{{asset('assets/images/logo/cns-logo.png')}}" alt="users view avatar"/>
			</a>
		</span>
		<button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
	</p>

</footer>
<script type="text/javascript" language="javascript" src="{{asset('assets/sweetalert.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
{{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}

<script type="text/javascript" >

    // $(document).ready(function() {
    //     $('#example').DataTable( {
    //        // "ajax": '../ajax/data/arrays.txt'
    //     } );
    // } );

</script>

<script>
    // Add a new repeating section
    var  attrs = ['id', 'name'];
    var lastRepeatingGroup;

    function resetAttributeNames(section) {
        var tags = section.find('input, label'), idx = section.index();
        tags.each(function() {
            var $this = $(this);
            $.each(attrs, function(i, attr) {
                var attr_val = $this.attr(attr);
                if (attr_val) {
                    $this.attr(attr, attr_val.replace(/_\d+$/, '_'+(idx + 1)))
                }
            })
        })

    }

    $('.addFight').click(function(e){
        e.preventDefault();
        if (!lastRepeatingGroup) {
            lastRepeatingGroup = $(document).find('.defaultSection');
            //lastRepeatingGroup = lastRepeatingGroup.clone();
        }

        var cloned = lastRepeatingGroup.clone();
        cloned.find('input').val('');
        cloned.addClass('repeatingSection');
        $('.repeatingSection').last().after(cloned.show());
         setTimeout(cloned.find('select.designation_id, select.emp_id').select2(),800);
        //cloned.insertAfter(lastRepeatingGroup);
        resetAttributeNames(cloned)
    });

    // Delete a repeating section
    $(document).on('click','.deleteFight',function(e){
        e.preventDefault();
        var current_fight = $(this).parents('div.repeatingSection');
        var other_fights = current_fight.siblings('.repeatingSection');
        if (other_fights.length === 0) {
            alert("You should atleast have one fight");
            return;
        }
        current_fight.slideUp('slow', function() {
            current_fight.remove();

            // reset fight indexes
            other_fights.each(function() {
                resetAttributeNames($(this));
            })
        })
    });

    $(document).ready(function() {
        if (!lastRepeatingGroup) {
            lastRepeatingGroup = $(document).find('.defaultSection');
            //lastRepeatingGroup = lastRepeatingGroup.clone();
        }

    });

</script>
