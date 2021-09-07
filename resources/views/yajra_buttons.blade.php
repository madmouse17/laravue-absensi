<a id="edit" href="{{ route('user.edit', $id) }}" class="bg-lightBlue-500 text-white active:bg-lightBlue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Edit</a>
&nbsp;&nbsp;&nbsp;
<a href="{{ route('user.destroy', $id) }}" class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Hapus</a>
{{-- <script>
    $(document).ready(function() {
            $("a").click(function(event) {
                event.preventDefault();
                console.log('event :>> ', event);
               
            });
        });
</script> --}}